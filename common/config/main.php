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
        'mailqueue' => [
            'class' => 'nterms\mailqueue\MailQueue',
            'table' => '{{%mail_queue}}',
            'mailsPerRound' => 10,
            'maxAttempts' => 3,
        ],
    ],
    'modules'    => [
        'smsGate' => [
            'class' => 'fgh151\modules\epochta\Module',
            'sms_key_private' => 'ac2ea781ced8dd8a479849addcd758a6',
            'sms_key_public' => '0012c0439ade32a5c19974d4053b22f8',
            'testMode' => false, //Включение тестового режима
        ],
    ],
];
