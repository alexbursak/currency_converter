<?php

use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function test_convertCurrency()
    {
        $product = $this->prophesize(\AB\CurrencyConverter\Entity\Product::class);

        $rate = $this->prophesize(\AB\CurrencyConverter\Entity\Rate::class);

        $rates = $this->prophesize(\AB\CurrencyConverter\Entity\Rates::class);
        $rates->getByCode('EUR')->willReturn($rate->reveal());

        $currency = $this->prophesize(\AB\CurrencyConverter\Entity\Currency::class);
        $currency->getRatesByDate('01-01-2016')->willReturn($rates);

        $currencies = $this->prophesize(\AB\CurrencyConverter\Entity\Currencies::class);
        $currencies->getByCode('GBP')->willReturn($currency->reveal());

        $order = $this->prophesize(\AB\CurrencyConverter\Entity\Order::class);
        $order->getCurrency()->willReturn('GBP');
        $order->getDate()->willReturn(DateTime::createFromFormat('d-m-Y', '01-01-2016'));
        $order->getProducts()->willReturn([$product->reveal()]);
        $order->setCurrency('EUR')->shouldBeCalled();

        $converter = new \AB\CurrencyConverter\Converter($currencies->reveal());
        $converter->convertCurrency($order->reveal(), 'EUR');
    }
}