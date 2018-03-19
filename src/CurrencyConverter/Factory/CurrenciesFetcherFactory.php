<?php

namespace AB\CurrencyConverter\Factory;

use AB\CurrencyConverter\CurrencyFetcher;
use AB\CurrencyConverter\Validator\CurrencyValidator;
use AB\CurrencyConverter\Validator\RatesValidator;
use AB\CurrencyConverter\Validator\RateValidator;

class CurrenciesFetcherFactory
{
    /**
     * @return CurrencyFetcher
     */
    public static function create()
    {
        return new CurrencyFetcher(
            new CurrencyValidator(),
            new RatesValidator(),
            new RateValidator()
        );
    }
}