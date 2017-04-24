<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => $baseUrl,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser', // required for POST input via `php://input`
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            /*'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),*/

            /*'rules' => [
                #'' => 'site/index',
                '<action>' => 'site/<action>',
                '<action>' => 'user/<action>',
                '<action>' => 'payment/<action>',
            ],*/
            "rules" => [
                #'' => 'site/index',
                #'<action>'=>'site/<action>',
                #'<action>'=>'user/<action>',
                #'<action>'=>'payment/<action>',

                //Site Controller
                "/" => "site/index",
                "about-us" => "site/about-us",
                "contact-us" => "site/contact-us",
                "terms-of-use" => "site/terms-of-use",
                "feedback" => "site/help-feedback",
                "logout" => "site/logout",

                "basic-details" => "site/basic-details",
                "education-occupation" => "site/education-occupation",
                "life-style" => "site/life-style",
                "about-family" => "site/about-family",
                "about-yourself" => "site/about-yourself",
                "verification" => "site/verification",
                "partner-preferences" => "site/partner-preferences",

                //User Controller
                "dashboard" => "user/dashboard",
                "my-profile" => "user/my-profile",
                "profile" => "user/profile",
                "photos" => "user/photos",
                "setting" => "user/setting",

                //Payment Controller
                "payment" => "payment/payment",

            ]
        ]

    ],
    'params' => $params,
];
