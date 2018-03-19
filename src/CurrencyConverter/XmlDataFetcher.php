<?php

namespace AB\CurrencyConverter;

use AB\CurrencyConverter\Exception\DataFetcherException;

abstract class XmlDataFetcher
{

    /**
     * @param string $filePath
     * @return \SimpleXMLElement
     * @throws DataFetcherException
     */
    protected function loadXmlFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new DataFetcherException("Currencies file does not exists '{$filePath}'");
        }

        return simplexml_load_file($filePath);
    }
}