<?php

/**
 * Created by PhpStorm.
 * User: VitProg
 * Date: 29.09.2015
 * Time: 14:00
 */
class CurrencySourceUa extends CurrencySourceBase {

    public $url = 'http://www.bank.gov.ua/control/uk/curmetal/currency/search?formType=searchFormDate&time_step=daily&date={{date}}&outer=xml';
    public $dateFormat = 'dd.MM.yyyy';
    public $xmlElement = 'currency';

    /**
     * @param SimpleXMLElement $xmlRow
     * @return CurrencyRaw
     */
    protected function parseRow(SimpleXMLElement $xmlRow) {
        $currency = new CurrencyRaw();
        $currency->lang = 'ua';
        $currency->num_code = (int)$xmlRow->digital_code;
        $currency->char_code = (string)$xmlRow->letter_code;
        $currency->nominal = (int)$xmlRow->number_of_units;
        $currency->name = (string)$xmlRow->{'сurrency_name'};
        $currency->cost = doubleval(str_replace(',', '.', (string)$xmlRow->exchange_rate));

        return $currency;
    }
}