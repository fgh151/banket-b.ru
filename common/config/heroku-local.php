<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=ec2-54-217-235-166.eu-west-1.compute.amazonaws.com;dbname=dfkodv3g2lub73',
            'username' => 'tqjyprbsozqkzp',
            'password' => '350f46a73b4a698813abce6075caf1e806d91b2fa0d3b1e6678625ea34f55b4f',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
