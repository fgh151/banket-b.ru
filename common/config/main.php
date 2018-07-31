<?php
return [
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'firebase' => [
            'class' => 'grptx\Firebase\Firebase',
            'credential_file' => __DIR__ . DIRECTORY_SEPARATOR . 'restorate-battle-firebase-adminsdk-43mis-e1f2d3084a.json', // (see https://firebase.google.com/docs/admin/setup#add_firebase_to_your_app)
            'database_uri' => 'https://restorate-battle.firebaseio.com/', // (optional)
        ],
        'imageresize' => [
            'class' => 'app\common\components\ImageResize',
            //path web root
            'cachePath' => '@app/web',
            //path where to store thumbs
            'cacheFolder' => 'upload/thumb',
            //use filename (seo friendly) for resized images else use a hash
            'useFilename' => true,
            //show full url (for example in case of a API)
            'absoluteUrl' => false,
        ],
    ],
];
