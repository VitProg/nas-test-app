<?php


/**
 * Created by PhpStorm.
 * User: VitProg
 * Date: 29.09.2015
 * Time: 13:59
 */
class CurrencyParser {

    protected static $sources = [
        'ru' => 'CurrencySourceRu',
        'ua' => 'CurrencySourceUa',
    ];

    const RUB_CODE = 643;
    const UAH_CODE = 980;

    private function __construct() {}
    private function __clone() {}

    public static function parse($date) {

        $date = date('Y-m-d', strtotime($date));

        require_once ('sources/CurrencySourceBase.php');

        /** @var CurrencyRaw[][] $data */
        $data = [];
        $codes = [];

        foreach (static::$sources as $lang => $sourceClass) {
            require_once ('sources/' . $sourceClass . '.php');

            /** @var CurrencySourceBase $source */
            $source = new $sourceClass();
            $data[$lang] = $source->parse($date);
            $codes = array_merge($codes, array_keys($data[$lang]));
        }

//        CVarDumper::dump($data, 3, 1);return;
        if (isset($data['ru'][self::UAH_CODE])) {
            $costRubUah = $data['ru'][self::UAH_CODE]->cost;
        } else {
            throw new Exception('Cost RUB:UAH not found');
        }

        $tr = Yii::app()->db->beginTransaction();

        Currency::model()->deleteAll('date = :date', [':date' => $date]);

        foreach ($codes as $code) {
            try {
                /** @var CurrencyRaw $ru */
                /** @var CurrencyRaw $ua */
                $ru = empty($data['ru']) == false && empty($data['ru'][$code]) == false ? $data['ru'][$code] : null;
                $ua = empty($data['ua']) == false && empty($data['ua'][$code]) == false ? $data['ua'][$code] : null;

                if (!$ru && !$ua) {
                    continue;
                }

                $currency = new Currency();

                $currency->date = $date;
                $currency->num_code = $code;
                $currency->char_code = $ru ? $ru->char_code : $ua->char_code;
                $currency->name_ru = $ru ? $ru->name : null;
                $currency->name_ua = $ua ? $ua->name : null;
                $currency->nominal_ru = $ru ? $ru->nominal : null;
                $currency->nominal_ua = $ua ? $ua->nominal : null;
                $currency->cost_rub = $ru ? ($ru->cost / $currency->nominal_ru) : null;
                $currency->cost_uah = $ua ? ($ua->cost / $currency->nominal_ua) : null;
                $currency->diff = $ru && $ua ? ($currency->cost_uah / $costRubUah) - $currency->cost_rub : null;

                if ($currency->save(true) == false) {
//                    CVarDumper::dump([$currency->getAttributes(), $currency->errors], 3, 1);
//                    $tr->rollback();
//                    throw new Exception('Con not save currency in DB');
                }

            } catch (Exception $ex) {
                continue;
            }
        }

        $tr->commit();

        return true;
    }

}