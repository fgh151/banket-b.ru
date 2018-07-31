<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-cabinet',
    'name' => 'bb-cabinet',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'controllerNamespace' => 'app\cabinet\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-cabinet',
        ],
        'user' => [
            'identityClass' => 'app\common\models\Organization',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-cabinet', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the cabinet
            'name' => 'advanced-cabinet',
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
                'site/reset-password/<token:\S+>' => 'site/reset-password',
                'conversation/index/<proposalId:\d+>' => 'conversation/index',
                '<controller:\w+>/<action:\w+>/<id:\d+>/' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'formatter' => [
            'class' => \app\common\components\Formatter::class
        ]
    ],
    'params' => $params,
];
