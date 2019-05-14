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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'firebase' => [
            'class' => 'grptx\Firebase\Firebase',
            'credential_file' => __DIR__ . DIRECTORY_SEPARATOR . 'banket-b-firebase-adminsdk-6k90k-61ed2acee9.json', // (see https://firebase.google.com/docs/admin/setup#add_firebase_to_your_app)
            'database_uri' => 'https://banket-b.firebaseio.com/', // (optional)
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
                'host' => 'smtp.yandex.ru',
                'username' => 'restorateru',
                'password' => 'Oc5aecee',
                'port' => '465',
                'encryption' => 'ssl', // у яндекса SSL
//                'encryption' => 'ssl', // у яндекса SSL
            ],
        ],
        'testmailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'restorateru',
                'password' => 'Oc5aecee',
                'port' => '587',
                'encryption' => 'tls', // у яндекса SSL

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
            'class' => \app\common\components\Sms::class,
//            'class' => \app\common\components\Smsc::class
        ],
        'SMSCenter' => [
            'class' => 'integready\smsc\SMSCenter',
            'login' => 'vkarpen@yandex.ru',
            'password' => '*(Kar6#Pen*)',
            'useSSL' => false,
            'options' => [
                'sender' => 'SenderName',   // имя отправителя
            ],
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
