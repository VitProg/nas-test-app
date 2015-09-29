<?php

/**
 * Created by PhpStorm.
 * User: VitProg
 * Date: 29.09.2015
 * Time: 13:56
 *
 * @property string $lang
 * @property integer $num_code
 * @property string $char_code
 * @property integer $nominal
 * @property string $name
 * @property string $cost
 */
class CurrencyRaw extends CComponent {

    const LANG_RU = 'ru';
    const LANG_UA = 'ua';

    public $lang;
    public $num_code;
    public $char_code;
    public $nominal;
    public $name;
    public $cost;

    /**
     * Returns the list of attribute names of the model.
     * @return array list of attribute names.
     */
    public function attributeNames() {
        return [
            'lang',
            'num_code',
            'char_code',
            'nominal',
            'name',
            'cost'
        ];
    }
}