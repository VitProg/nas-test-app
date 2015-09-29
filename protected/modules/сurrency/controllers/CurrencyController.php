<?php

class CurrencyController extends Controller {

    public function actionIndex() {

        $date = Yii::app()->request->getParam('date', date('Y-m-d'));

        if ($date) {
            $this->redirect(Yii::app()->urlManager->createUrl('currency/currency/date', ['date' => $date]));
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
            'baseUrl' => Yii::app()->urlManager->createUrl('currency/currency/index'),
            'date' => $date,
            'model' => $model,
        ]);
    }
}