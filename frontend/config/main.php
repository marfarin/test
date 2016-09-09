<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'common\components\EventNotificator'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'class' => 'common\components\UserConfig',

            // Comment this if you don't want to record user logins
            'on afterLogin' => function ($event) {
                \common\models\UserVisitLog::newVisitor($event->identity->id);
            }
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '<controller>/<action>' => '<controller>/<action>',
            ],
        ],
    ],
    'modules'=>[
        'gridview'=> [
            'class'=>'\kartik\grid\Module',
            // other module settings
        ],
    ],
    'as beforeRequest' => [  //if guest user access site so, redirect to login page.
        'class' => \yii\filters\AccessControl::className(),
        'rules' => [
            [
                'controllers' => ['auth'],
                'actions' => ['login', 'error', 'requestPasswordReset', 'registration', 'captcha', 'confirm-registration-email'],
                'allow' => true,
            ],
            [
                'controllers' => ['manage-data'],
                'actions' => ['put-data', 'index'],
                'allow' => true,
            ],
            [
                'controllers' => ['site'],
                'actions' => ['index'],
                'allow' => true
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];
