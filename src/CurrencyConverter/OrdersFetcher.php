<?php

namespace AB\CurrencyConverter;

use AB\CurrencyConverter\Collection\Orders;
use AB\CurrencyConverter\Entity\Order;
use AB\CurrencyConverter\Entity\Product;
use AB\CurrencyConverter\Exception\DataFetcherException;
use AB\CurrencyConverter\Exception\ValidatorException;
use AB\CurrencyConverter\Validator\OrderValidator;
use AB\CurrencyConverter\Validator\ProductValidator;

class OrdersFetcher extends XmlDataFetcher
{
    /** @var OrderValidator */
    private $orderValidator;
    /** @var ProductValidator */
    private $productValidator;

    /**
     * @param OrderValidator $orderValidator
     * @param ProductValidator $productValidator
     */
    public function __construct(
        OrderValidator $orderValidator,
        ProductValidator $productValidator
    ) {
        $this->orderValidator = $orderValidator;
        $this->productValidator = $productValidator;
    }


    /**
     * @param string $filePath
     * @return Orders
     * @throws DataFetcherException
     */
    public function getData($filePath)
    {
        $data = $this->loadXmlFile($filePath);
        $orders = new Orders();

        foreach ($data->order as $xmlOrder) {

            try {
                $this->orderValidator->validate($xmlOrder);
            } catch (ValidatorException $e) {
                throw new DataFetcherException("Order Error: Missing field '{$e->getField()}'", null, $e);
            }

            $order = new Order();
            $order->setId((string)$xmlOrder->id);
            $order->setCurrency((string)$xmlOrder->currency);
            $order->setDate(\DateTime::createFromFormat('d/m/Y',(string)$xmlOrder->date));

            foreach ($xmlOrder->products->product as $xmlProduct) {

                try {
                    $this->productValidator->validate($xmlProduct->attributes());
                } catch (ValidatorException $e) {
                    throw new DataFetcherException("Order Error: Missing field '{$e->getField()}'", null, $e);
                }

                $product = new Product();
                $product->setTitle((string)$xmlProduct->attributes()->title);
                $product->setPrice((float)$xmlProduct->attributes()->price);

                $order->addProduct($product);
            }

            $orders->addOrder($order);
        }

        return $orders;
    }
}