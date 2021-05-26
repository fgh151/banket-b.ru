<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php'
//    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'app-cabinet',
    'name' => 'Банкетный Батл',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'controllerNamespace' => 'app\user\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-cabinet',
            'cookieValidationKey' => 'jds87y843hiuh7876R^HIOUhf5r5$#^&*(JDtdkj'
        ],
        'user' => [
            'identityClass' => \app\common\models\MobileUser::class,
            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-cabinet', 'httpOnly' => true],
        ],
        'session' => [
            'class' => \yii\web\Session::class,
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
                '/' => 'site/about',
                'site/reset-password/<token:\S+>' => 'site/reset-password',
                'conversation/index/<proposalId:\d+>' => 'conversation/index',
                '<controller:\w+>/<action:\w+>/<id:\d+>/' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'formatter' => [
            'class' => \app\common\components\Formatter::class
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'wbraganca\dynamicform\DynamicFormAsset' => [
                    'class' => 'app\cabinet\components\DynamicFormAsset',
                ],
            ]
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    /** @see https://developers.facebook.com/apps */
                    'clientId' => 'APP_CLIENT_ID',
                    'clientSecret' => 'APP_CLIENT_SECRET',
                    'attributeNames' => ['name', 'email', 'first_name', 'last_name'],
                ],
                'vkontakte' => [
                    /** @see http://vk.com/editapp?act=create */
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => 'vkontakte_client_id',
                    'clientSecret' => 'vkontakte_client_secret',
                ],
                'google' => [
                    /**
                     * @see https://console.developers.google.com/project
                     * @see https://console.developers.google.com/apis/credentials?project=[yourProjectId].
                     */
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'twitter' => [
                    /** @see https://dev.twitter.com/apps/new */
                    'class' => 'yii\authclient\clients\Twitter',
                    'attributeParams' => [
                        'include_email' => 'true'
                    ],
                    'consumerKey' => 'twitter_consumer_key',
                    'consumerSecret' => 'twitter_consumer_secret',
                ],
                'yandex' => [
                    /** @see https://oauth.yandex.ru/client/new */
                    'class' => 'yii\authclient\clients\Yandex',
                    'clientId' => getenv('OAUTH_YANDEX_CLIENT_ID'),
                    'clientSecret' => getenv('OAUTH_YANDEX_XLIENT_SECRET'),
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
