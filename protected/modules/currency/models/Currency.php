<?php

/**
 * This is the model class for table "currency".
 *
 * The followings are the available columns in table 'currency':
 * @property integer $id
 * @property string $date
 * @property integer $num_code
 * @property string $char_code
 * @property string $nominal_ru
 * @property string $nominal_ua
 * @property string $name_ru
 * @property string $name_ua
 * @property double $cost_rub
 * @property double $cost_uah
 * @property double $diff
 */
class Currency extends CActiveRecord {
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'currency';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, num_code, char_code', 'required'),
            array('num_code, nominal_ru, nominal_ua', 'numerical', 'integerOnly' => true),
            array('char_code', 'length', 'max' => 3),
            array('name_ru, name_ua', 'length', 'max' => 50),
            array('cost_rub, cost_uah, diff', 'numerical'),
//			array('cost_rub, cost_uah, diff', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, date, num_code, char_code, name_ru, name_ua, cost_rub, cost_uah, diff', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date' => 'Date',
            'num_code' => 'Num Code',
            'char_code' => 'Char Code',
            'nominal_ru' => 'Name Ru',
            'nominal_ua' => 'Name Ru',
            'name_ru' => 'Name Ru',
            'name_ua' => 'Name Ua',
            'cost_rub' => 'Cost Rub',
            'cost_uah' => 'Cost Uah',
            'diff' => 'Diff',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('num_code', $this->num_code);
        $criteria->compare('char_code', $this->char_code, true);
        $criteria->compare('nominal_ru', $this->nominal_ru, true);
        $criteria->compare('nominal_ua', $this->nominal_ua, true);
        $criteria->compare('name_ru', $this->name_ru, true);
        $criteria->compare('name_ua', $this->name_ua, true);
        $criteria->compare('cost_rub', $this->cost_rub, true);
        $criteria->compare('cost_uah', $this->cost_uah, true);
        $criteria->compare('diff', $this->diff, true);

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 100,
                ),
            )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Currency the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function costWithNominal($val) {
        if ($val != 'rub' && $val != 'uah') {
            return '';
        }
        return $this->{'cost_' . $val} * $this->{'nominal_' . ($val == 'rus' ? 'ru' : 'ua')};
    }
}
