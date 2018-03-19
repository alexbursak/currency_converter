<?php

require_once dirname(__FILE__) . './../../../vendor/autoload.php';

$exchangeRatesPath = dirname(__FILE__) . '/../../../data/ExchangeRates.xml';
$ordersPath = dirname(__FILE__) . '/../../../data/Orders.xml';

try {
    $orders = \AB\CurrencyConverter\Factory\OrdersFetcherFactory::create()->getData($ordersPath);
} catch (\AB\CurrencyConverter\Exception\DataFetcherException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}

$converter = new \AB\CurrencyConverter\Converter(
    \AB\CurrencyConverter\Factory\CurrenciesFetcherFactory::create()->getData($exchangeRatesPath)
);

if (!$orders->getById($argv[1])) {
    echo "Order with ID '{$argv[1]}' not found" . PHP_EOL;
    exit(1);
}

try {
    print_r($converter->convertCurrency($orders->getById($argv[1]), $argv[2]));
    exit(0);
} catch (\AB\CurrencyConverter\Exception\ConverterException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}