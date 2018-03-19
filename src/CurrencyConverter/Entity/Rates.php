<?php

namespace AB\CurrencyConverter\Entity;

class Rates
{
    /** @var \DateTime */
    private $date;
    /** @var Rate[] */
    private $rates;

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return Rate[]
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * @param Rate $rate
     */
    public function addRate(Rate $rate)
    {
        $this->rates[$rate->getCode()] = $rate;
    }

    /**
     * @param $code
     * @return Rate
     */
    public function getByCode($code)
    {
        return isset($this->rates[$code]) ? $this->rates[$code] : null;
    }
}