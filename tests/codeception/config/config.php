<?php
/**
 * Application configuration shared by all applications and test types
 */
return [
    'language' => 'en-US',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@tests/codeception/common/fixtures/data',
            'templatePath' => '@tests/codeception/common/templates/fixtures',
            'namespace' => 'tests\codeception\common\fixtures',
        ],
    ],
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=rgk_test',
            'username' => 'root',
            'password' => 'q88srHrm',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'fileTransportPath' => '/home/panik/projects/rgk/tests/codeception/mail',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'KUNW0kagNN4qm0oNhVWOb_aLM1Zug481',
        ],
    ],
];
