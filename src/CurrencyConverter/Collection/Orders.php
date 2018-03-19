<?php

namespace AB\CurrencyConverter\Collection;

use AB\CurrencyConverter\Entity\Order;

class Orders
{
    /** @var Order[] */
    private $orders;

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param Order $product
     */
    public function addOrder(Order $product)
    {
        $this->orders[$product->getId()] = $product;
    }

    /**
     * @param $id
     * @return Order|null
     */
    public function getById($id)
    {
        return isset($this->orders[$id]) ? $this->orders[$id] : null;
    }
}