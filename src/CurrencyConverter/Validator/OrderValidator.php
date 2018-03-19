<?php

namespace AB\CurrencyConverter\Validator;

class OrderValidator extends XmlDataValidator
{
    const FIELDS = [
        'id',
        'currency',
        'date',
        'products'
    ];
}