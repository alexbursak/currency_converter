<?php

namespace AB\CurrencyConverter;

use AB\CurrencyConverter\Entity\Currencies;
use AB\CurrencyConverter\Entity\Currency;
use AB\CurrencyConverter\Entity\Rate;
use AB\CurrencyConverter\Entity\Rates;
use AB\CurrencyConverter\Exception\DataFetcherException;
use AB\CurrencyConverter\Exception\ValidatorException;
use AB\CurrencyConverter\Validator\CurrencyValidator;
use AB\CurrencyConverter\Validator\RatesValidator;
use AB\CurrencyConverter\Validator\RateValidator;

class CurrencyFetcher extends XmlDataFetcher
{

    /** @var CurrencyValidator */
    private $currencyValidator;
    /** @var RatesValidator */
    private $ratesValidator;
    /** @var RateValidator */
    private $rateValidator;

    /**
     * @param CurrencyValidator $currencyValidator
     * @param RatesValidator $ratesValidator
     * @param RateValidator $rateValidator
     */
    public function __construct(
        CurrencyValidator $currencyValidator,
        RatesValidator $ratesValidator,
        RateValidator $rateValidator
    ) {
        $this->currencyValidator = $currencyValidator;
        $this->ratesValidator = $ratesValidator;
        $this->rateValidator = $rateValidator;
    }


    /**
     * @param string $filePath
     * @return Currencies
     * @throws DataFetcherException
     */
    public function getData($filePath)
    {
        $data = $this->loadXmlFile($filePath);

        $currencies = new Currencies();

        foreach ($data as $currencyRaw) {

            try {
                $this->currencyValidator->validate($currencyRaw);
            } catch (ValidatorException $e) {
                throw new DataFetcherException("Currency Error: Missing field '{$e->getField()}'", null, $e);
            }

            $currency = new Currency();
            $currency->setName((string)$currencyRaw->name);
            $currency->setCode((string)$currencyRaw->code);

            foreach ($currencyRaw->rateHistory->rates as $xmlRate) {

                try {
                    $this->ratesValidator->validate($xmlRate);
                } catch (ValidatorException $e) {
                    throw new DataFetcherException("Currency Error: Missing field '{$e->getField()}'", null, $e);
                }

                $date = \DateTime::createFromFormat('d/m/Y', (string) $xmlRate->attributes()->date);
                $rates = new Rates();
                $rates->setDate($date);

                foreach ($xmlRate->rate as $xmlRate1) {

                    try {
                        $this->rateValidator->validate($xmlRate1->attributes());
                    } catch (ValidatorException $e) {
                        throw new DataFetcherException("Currency Error: Missing field '{$e->getField()}'", null, $e);
                    }

                    $rate = new Rate();
                    $rate->setCode((string)$xmlRate1->attributes()['code']);
                    $rate->setValue((string)$xmlRate1->attributes()['value']);
                    $rates->addRate($rate);
                }

                $currency->addRates($rates);
            }

            $currencies->addCurrency($currency);
        }

        return $currencies;
    }
}