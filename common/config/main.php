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
        ]
    ],
];
