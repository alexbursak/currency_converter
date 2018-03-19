<?php

namespace AB\CurrencyConverter\Entity;

class Order
{
    /** @var int */
    private $id;
    /** @var string */
    private $currency;
    /** @var \DateTime */
    private $date;
    /** @var Product[] */
    private $products;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

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
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product $products
     */
    public function addProduct(Product $products)
    {
        $this->products[] = $products;
    }

    /**
     * @return float
     */
    public function getOrderTotal()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }

        return $total;
    }
}