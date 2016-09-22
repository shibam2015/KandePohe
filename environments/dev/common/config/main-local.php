<?php
error_reporting(0);
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2_kande',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        /*'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],*/
        'mailer' => [
         'class' => 'yii\swiftmailer\Mailer',
         'viewPath' => '@common/mail',
         //'useFileTransport' => false,
         'transport' => [
             'class' => 'Swift_SmtpTransport',
             'host' => 'smtp.gmail.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
             'username' => 'test.vcoderteam@gmail.com',
             'password' => 'vcoderteam',
             'port' => '587', // Port 25 is a very common port too
             'encryption' => 'tls', // It is often used, check your provider or mail server specs
         ],
     ],
        'urlManager' => [
        'class' => 'yii\web\UrlManager',
        // Disable index.php
        'showScriptName' => false,
        // Disable r= routes
        'enablePrettyUrl' => true,
        'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        ),
        ],
        'user' => [
            'identityClass' => 'app\common\models\User', // User must implement the IdentityInterface
            'enableAutoLogin' => true,
        ]
    ],
];
