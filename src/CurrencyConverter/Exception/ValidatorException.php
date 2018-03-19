<?php

namespace AB\CurrencyConverter\Exception;

class ValidatorException extends \Exception
{
    /**
     * @var string
     */
    private $field;

    public function __construct($field, $message = null, $code = null, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
}