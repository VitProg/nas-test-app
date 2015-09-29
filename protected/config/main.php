<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array(
		'log',
		'bootstrap',
		),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		'currency' => [
			'class' => 'application.modules.currency.CurrencyModule',
		],

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'currency' => 'currency/currency/index',
				'currency/<date:\d{4}-\d{2}-\d{2}>' => 'currency/currency/date',
				'admin/currency' => 'currency/currencyAdmin/index',
				'admin/currency/<date:\d{4}-\d{2}-\d{2}>' => 'currency/currencyAdmin/date',
				'admin/currency/parse' => 'currency/currencyAdmin/parse',

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'session' => array ( 
		    'sessionName' => 'nas-tes-app',
		    'class'=> 'CDbHttpSession',
		    'autoCreateSessionTable'=> false,
		    'connectionID' => 'db',
		    'sessionTableName' => 'session',
		    'useTransparentSessionID'   =>($_POST['PHPSESSID']) ? true : false,
		    'autoStart' => 'false',
		    'cookieMode' => 'only',
		    'timeout' => 300,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				array(
					'class'=>'CWebLogRoute',
				),
			),
		),

		'bootstrap' => array(
			'class' => 'bootstrap.components.Bootstrap',
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
