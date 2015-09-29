<?php

/**
 * Created by PhpStorm.
 * User: VitProg
 * Date: 29.09.2015
 * Time: 14:00
 */
class CurrencySourceRu extends CurrencySourceBase {

    public $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req={{date}}';
    public $dateFormat = 'dd/MM/yyyy';
    public $xmlElement = 'Valute';

    /**
     * @param SimpleXMLElement $xmlRow
     * @return CurrencyRaw
     */
    protected function parseRow(SimpleXMLElement $xmlRow) {

        $currency = new CurrencyRaw();
        $currency->lang = 'ru';
        $currency->num_code = (int)$xmlRow->NumCode;
        $currency->char_code = (string)$xmlRow->CharCode;
        $currency->nominal = (int)$xmlRow->Nominal;
        $currency->name = (string)$xmlRow->Name;
        $currency->cost = doubleval(str_replace(',', '.', (string)$xmlRow->Value));

        return $currency;
    }
}