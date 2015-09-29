<?php

/**
 * Created by PhpStorm.
 * User: VitProg
 * Date: 29.09.2015
 * Time: 14:00
 */
abstract class CurrencySourceBase {

    public $url;
    public $dateFormat = 'dd/mm/YYYY';
    public $xmlElement = 'currency';

    /**
     * @param $date
     * @return string
     */
    public function getUrl($date) {
        $time = is_numeric($date) ? $date : strtotime($date);
        return str_replace('{{date}}', Yii::app()->dateFormatter->format($this->dateFormat, $time), $this->url);
    }

    /**
     * @param $date
     * @return CurrencyRaw[]
     */
    public function parse($date) {

        $xml = new XMLReader();
        $url = $this->getUrl($date);
        $xml->open($url);
        $xml->setParserProperty(XMLReader::VALIDATE, false);

        Yii::log('Open XML from `' . $url . '`', CLogger::LEVEL_INFO, 'currency-parser');

        $data = [];
        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::ELEMENT && $xml->localName == $this->xmlElement) {

                $xmlRow = null;
                try {
                    $xmlRow = new SimpleXMLElement($xml->readOuterXml());
                } catch (Exception $e) {
                    continue;
                }

                if (($rowObj = $this->parseRow($xmlRow))) {
                    $data[$rowObj->num_code] = $rowObj;
//                    Yii::log('Parsed XML row `' . json_encode($rowObj) . '`', CLogger::LEVEL_INFO, 'currency-parser');
                } else {
                    Yii::log('Error parsed XML row', CLogger::LEVEL_WARNING, 'currency-parser');
                }
            }
        }

        return $data;
    }

    /**
     * @param SimpleXMLElement $xmlRow
     * @return CurrencyRaw
     */
    abstract protected function parseRow(SimpleXMLElement $xmlRow);

}