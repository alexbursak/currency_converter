<?php

namespace AB\CurrencyConverter\Entity;

class Currencies
{
    /** @var Currency[] */
    private $currencies;

    /**
     * @return Currency[]
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }

    /**
     * @param Currency $currencies
     */
    public function addCurrency(Currency $currencies)
    {
        $this->currencies[$currencies->getCode()] = $currencies;
    }

    /**
     * @param string $code
     * @return Currency|null
     */
    public function getByCode($code)
    {
        return $this->currencies[$code];
    }
}