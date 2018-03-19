<?php

namespace AB\CurrencyConverter\Validator;

use AB\CurrencyConverter\Exception\ValidatorException;

abstract class XmlDataValidator
{
    const FIELDS = [];

    /**
     * @param $data
     * @throws ValidatorException
     */
    public function validate($data)
    {
        foreach (self::FIELDS as $field) {
            if (!property_exists($data, $field)) {
                throw new ValidatorException($field, "Missing field '{$field}''");
            }
        }
    }
}