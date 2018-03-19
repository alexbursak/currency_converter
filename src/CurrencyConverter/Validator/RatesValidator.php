<?php

namespace AB\CurrencyConverter\Validator;

use AB\CurrencyConverter\Exception\ValidatorException;

class RatesValidator
{
    /**
     * @param $data
     * @throws ValidatorException
     */
    public function validate($data)
    {
        if (!property_exists($data->attributes(), 'date')) {
            throw new ValidatorException('date', "Missing field 'date''");
        }
        if (!property_exists($data, 'rate')) {
            throw new ValidatorException('rate', "Missing field 'rate''");
        }
    }
}