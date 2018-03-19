<?php

namespace AB\CurrencyConverter\Entity;

class Currency
{
    /** @var string */
    private $name;
    /** @var string */
    private $code;
    /** @var Rates[] */
    private $rates;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return Rates[]
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * @param Rates $rates
     */
    public function addRates(Rates $rates)
    {
        $this->rates[$rates->getDate()->format('d-m-Y')] = $rates;
    }

    public function getRatesByDate($date)
    {
        return $this->rates[$date];
    }
}