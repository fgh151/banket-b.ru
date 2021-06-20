<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
//    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php'
//    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'name' => 'BB - api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\api\controllers',
    'bootstrap' => ['log',],
    'modules' => [
        'v2' => \app\api\versions\v2\Version::class
//        'gii' => 'yii\gii\Module',
//        'allowedIPs' => ['*']
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
            'cookieValidationKey' => 'jds87y8^&hgf65&GHVCR%5r5$#^&*(JDtdkj'
        ],
        'user' => [
            'identityClass' => 'app\common\models\MobileUser',
            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'OPTIONS <controller:\w+>/<action:\w+>' => 'options/index',
                'OPTIONS <controller:\w+>/<action:\w+>/<id:\d+>/' => 'options/index',
                'proposal/delete/<proposalId:\w+>/<organizationId:\w+>' => 'proposal/delete',
                'proposal/dialogs/<proposalId:\d+>' => 'proposal/dialogs',
                '<controller:\w+>/<action:\w+>/<id:\d+>/' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>/' => '<module>/<controller>/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
