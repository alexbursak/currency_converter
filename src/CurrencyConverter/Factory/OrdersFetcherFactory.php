<?php

namespace AB\CurrencyConverter\Factory;

use AB\CurrencyConverter\OrdersFetcher;
use AB\CurrencyConverter\Validator\OrderValidator;
use AB\CurrencyConverter\Validator\ProductValidator;

class OrdersFetcherFactory
{
    /**
     * @return OrdersFetcher
     */
    public static function create()
    {
        return new OrdersFetcher(
            new OrderValidator(),
            new ProductValidator()
        );
    }
}