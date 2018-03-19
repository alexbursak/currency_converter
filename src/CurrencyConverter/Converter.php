<?php

namespace AB\CurrencyConverter;

use AB\CurrencyConverter\Entity\Currencies;
use AB\CurrencyConverter\Entity\Order;
use AB\CurrencyConverter\Exception\ConverterException;

class Converter
{
    /** @var Currencies */
    private $currencies;

    /**
     * @param $currencies
     */
    public function __construct(Currencies $currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * @param Order $order
     * @param string $currencyCode
     * @return Order
     * @throws ConverterException
     */
    public function convertCurrency(Order $order, $currencyCode)
    {
        $currency = $this->currencies->getByCode($order->getCurrency());
        $rates = $currency->getRatesByDate($order->getDate()->format('d-m-Y'));

        if(!$rates->getByCode($currencyCode)) {
            throw new ConverterException("Currency with such code not found - '{$currencyCode}'");
        }

        foreach ($order->getProducts() as $product) {
            $newPrice = $product->getPrice() * (float)$rates->getByCode($currencyCode)->getValue();
            $product->setPrice($this->roundPrice($newPrice));
        }
        $order->setCurrency($currencyCode);

        return $order;
    }

    /**
     * @param float $price
     * @return float
     */
    private function roundPrice($price)
    {
        return round($price * 100) / 100;
    }
}