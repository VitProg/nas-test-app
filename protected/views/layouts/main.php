<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<? $this->widget(
    'bootstrap.widgets.TbNavbar',
    [
        'brand' => false,
        'fixed' => false,
        'items' => [
            [
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => [
                    ['label' => 'Home', 'url' => ['/currency']],
                    ['label' => 'Admin', 'url' => ['/admin/currency'], 'visible' => Yii::app()->user->name == 'admin'],
                    ['label' => 'Login', 'url' => ['/site/login'], 'visible' => Yii::app()->user->isGuest],
                    ['label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => ['/site/logout'], 'visible' => !Yii::app()->user->isGuest]
                ]
            ]
        ]
    ]
) ?>

<div class="container">
    <? if (isset($this->breadcrumbs)) { ?>
        <? $this->widget(
            'bootstrap.widgets.TbBreadcrumbs',
            array(
                'links' => $this->breadcrumbs,
            )
        ); ?>
    <? } ?>

    <?= $content ?>

    <div class="clear"></div>

    <footer id="footer">
        <hr>
        <?php echo Yii::powered(); ?>
    </footer>

</div>

</body>
</html>
