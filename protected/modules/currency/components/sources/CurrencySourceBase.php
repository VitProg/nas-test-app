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
        

        $temp_file = tempnam(sys_get_temp_dir(), 'currency-source');
        $fp = fopen($temp_file, 'w+');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);


        $xml->open($temp_file);
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

        @unlink($temp_file);

        return $data;
    }

    /**
     * @param SimpleXMLElement $xmlRow
     * @return CurrencyRaw
     */
    abstract protected function parseRow(SimpleXMLElement $xmlRow);

}