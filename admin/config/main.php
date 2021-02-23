<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php'
//    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-admin',
    'name' => 'BB - admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\admin\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'homeUrl' => ['proposal/index'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
            'cookieValidationKey' => 'jds87y843hiuh7^&TG%^EW#Yg87td(JDtdkj'
        ],
        'user' => [
            'identityClass' => \app\common\models\Organization::class,// 'app\common\models\User',
            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-admin', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the admin
            'name' => 'advanced-admin',
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
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>/' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
