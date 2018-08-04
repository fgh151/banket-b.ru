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
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
        ],
        'user' => [
            'identityClass' => 'app\common\models\MobileUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-admin', 'httpOnly' => true],
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
                'proposal/delete/<proposalId:\d+>/<organizationId:\d+>' => 'proposal/delete',
                'proposal/dialogs/<proposalId:\d+>' => 'proposal/dialogs',
                '<controller:\w+>/<action:\w+>/<id:\d+>/' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
