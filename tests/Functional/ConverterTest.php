<?php

namespace Functional;

use AB\CurrencyConverter\Collection\Orders;
use AB\CurrencyConverter\Converter;
use AB\CurrencyConverter\Factory\CurrenciesFetcherFactory;
use AB\CurrencyConverter\Factory\OrdersFetcherFactory;

use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /** @var Converter */
    private $sut;
    /** @var Orders */
    private $orders;

    public function setUp()
    {
        $this->orders = OrdersFetcherFactory::create()->getData(dirname(__FILE__) . '/../../data/Orders.xml');

        $this->sut = new Converter(
            CurrenciesFetcherFactory::create()->getData(dirname(__FILE__) . '/../../data/ExchangeRates.xml')
        );
    }

    public function test_convert_currency_eur()
    {
        $orderUnconverted = $this->orders->getById(1);
        $this->assertEquals('GBP', $orderUnconverted->getCurrency());
        $this->assertEquals(4.99, $orderUnconverted->getProducts()[0]->getPrice());

        $order = $this->sut->convertCurrency($orderUnconverted, 'EUR');
        $this->assertEquals('1', $order->getId());
        $this->assertEquals('EUR', $order->getCurrency());
        $this->assertEquals('01-01-2016', $order->getDate()->format('d-m-Y'));

        $this->assertEquals('Rimmel Lasting Finish Lipstick 4g', $order->getProducts()[0]->getTitle());
        $this->assertEquals(5.49, $order->getProducts()[0]->getPrice());
    }

    public function test_convert_currency_gbp()
    {
        $orderUnconverted = $this->orders->getById(2);
        $this->assertEquals('EUR', $orderUnconverted->getCurrency());
        $this->assertEquals(99.99, $orderUnconverted->getProducts()[0]->getPrice());
        $this->assertEquals(19.99, $orderUnconverted->getProducts()[1]->getPrice());

        $order = $this->sut->convertCurrency($orderUnconverted, 'GBP');
        $this->assertEquals('2', $order->getId());
        $this->assertEquals('GBP', $order->getCurrency());
        $this->assertEquals('02-01-2016', $order->getDate()->format('d-m-Y'));

        $this->assertEquals('GHD Hair Straighteners', $order->getProducts()[0]->getTitle());
        $this->assertEquals(79.99, $order->getProducts()[0]->getPrice());

        $this->assertEquals('Redken Shampure Shampoo', $order->getProducts()[1]->getTitle());
        $this->assertEquals(15.99, $order->getProducts()[1]->getPrice());
    }
}