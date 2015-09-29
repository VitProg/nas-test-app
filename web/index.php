<?php

// change the following paths if necessary
//$yii=dirname(__FILE__).'/vendor/yiisoft/yii/framework/yii.php';
$config=dirname(__FILE__).'/../protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

define('ROOT_DIR', realpath(__DIR__ . '/../'));
define('WEB_DIR', ROOT_DIR . '/web');
define('VENDOR_DIR', ROOT_DIR . '/protected/vendor');

require_once(VENDOR_DIR . '/autoload.php');

# Some global aliases
Yii::setPathOfAlias('root', ROOT_DIR);
Yii::setPathOfAlias('web', WEB_DIR);
Yii::setPathOfAlias('vendor', VENDOR_DIR);

Yii::setPathOfAlias('bootstrap', VENDOR_DIR . '/clevertech/yii-booster/src');

require_once(ROOT_DIR . '/protected/components/MyWebApplication.php');

$app = Yii::createApplication('MyWebApplication', $config);
$app->run();

//require_once($yii);
//Yii::createWebApplication($config)->run();
