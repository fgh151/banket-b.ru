<?php
return [
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'queue', // The component registers its own console commands
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "{$_ENV['DATABASE_TYPE']}:host={$_ENV['DATABASE_HOSTNAME']};port={$_ENV['DATABASE_PORT']};dbname={$_ENV['DATABASE_DATABASE']}",
            'username' => $_ENV['DATABASE_USERNAME'],
            'password' => $_ENV['DATABASE_PASSWORD'], //'uoSh8iiv',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'firebase' => [
            'class' => 'grptx\Firebase\Firebase',
            'credential_file' => __DIR__ . DIRECTORY_SEPARATOR . 'banket-b-firebase-adminsdk-6k90k-61ed2acee9.json',
            // (see https://firebase.google.com/docs/admin/setup#add_firebase_to_your_app)
            'database_uri' => 'https://banket-b.firebaseio.com/',
            // (optional)
        ],
        'push' => [
            'class' => \app\common\components\Push::class
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
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => getenv('SMTP_HOST'),
                'username' => getenv('SMTP_USER'),
                'password' => getenv('SMTP_PASSWORD'),
                'port' => getenv('SMTP_PORT'),
                'encryption' => getenv('SMTP_ENCRYPTION'),
            ],
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\FileMutex::class
        ],
        'sms' => [
//            'class' => \app\common\components\Sms::class,
            'class' => \app\common\components\Smsc::class,
            'login' => getenv('SMS_LOGIN'),
            'password' => getenv('SMS_PASSWORD'),
            'sender' => getenv('SMS_SENDER')
        ],
    ],
    'modules'    => [
        'smsGate' => [
            'class' => 'fgh151\modules\epochta\Module',
            'sms_key_private' => getenv('SMS_GATE_PRIVATE_KEY'),
            'sms_key_public' => getenv('SMS_GATE_PUBLIC_KEY'),
            'testMode' => false, //Включение тестового режима
        ],
    ],
];
