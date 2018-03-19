<?php

namespace AB\CurrencyConverter\Validator;

class CurrencyValidator extends XmlDataValidator
{
    const FIELDS = [
        'name',
        'code',
        'rateHistory',
    ];
}