<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 29.12.2018
 * Time: 13:20
 */

return [
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',
            // ...
            'cookieParams' => [
                'path' => '/',
                'domain' => '.' . $_SERVER['SERVER_NAME']// . getenv('DOMAIN'),
            ],
        ],
        'user' => [
            // ...

            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'path' => '/',
                'domain' => '.' . $_SERVER['SERVER_NAME']//  . getenv('DOMAIN'),
            ],
        ],
        'request' => [
            // ...
            'csrfCookie' => [
                'name' => '_csrf',
                'path' => '/',
                'domain' => '.' . $_SERVER['SERVER_NAME']//  . getenv('DOMAIN'),
            ],
        ],
    ],
];
