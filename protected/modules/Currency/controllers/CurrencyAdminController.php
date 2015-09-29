<?php

/**
 * Created by PhpStorm.
 * User: VitProg
 * Date: 29.09.2015
 * Time: 13:00
 */
class CurrencyAdminController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return [
            ['allow', 'users' => ['admin']],
            ['deny'],
        ];
    }


    public function actionParse($date) {
        CurrencyParser::parse($date);
        header('Content-type: application/json');
        echo json_encode(['result' => true]);
        Yii::app()->realEnd();
    }


    public function actionIndex() {

        $date = Yii::app()->request->getParam('date', date('Y-m-d'));

        if ($date) {
            $this->redirect(Yii::app()->urlManager->createUrl('currency/currencyAdmin/date', ['date' => $date]));
        }

        $this->render('index');
    }

    public function actionDate($date = null) {

        $model = new Currency('search');
        $model->unsetAttributes();

        if (isset($_GET['Currency'])) {
            $model->setAttributes($_GET['Currency']);
        }

        $model->date = date('Y-m-d', strtotime($date));

        $this->render('index', [
            'baseUrl' => Yii::app()->urlManager->createUrl('currency/currencyAdmin/index'),
            'refreshUrl' => Yii::app()->urlManager->createUrl('currency/currencyAdmin/parse'),
            'date' => $date,
            'model' => $model,
        ]);
    }

}