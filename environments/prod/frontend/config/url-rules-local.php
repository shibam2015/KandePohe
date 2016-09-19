<?php 

$urlManager = [
	'class'	=> 'yii\web\urlManager',
    'enablePrettyUrl' => true,
    'showScriptName'	=> true,
    'rules' => [
       	'<controller:\w+>/<id:\w+>' => '<controller>',
    	'<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
    	'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    ],
];

return $urlManager;