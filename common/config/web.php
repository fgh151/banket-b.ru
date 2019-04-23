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
            // ...
            'cookieParams' => [
                'path' => '/',
                'domain' => YII_ENV_DEV ? '.banket-b.ois' : ".banket-b.ru",
            ],
        ],
        'user' => [
            // ...

            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'path' => '/',
                'domain' => YII_ENV_DEV ? '.banket-b.ois' : ".banket-b.ru",
            ],
        ],
        'request' => [
            // ...
            'csrfCookie' => [
                'name' => '_csrf',
                'path' => '/',
                'domain' => YII_ENV_DEV ? '.banket-b.ois' : ".banket-b.ru",
            ],
        ],
    ],
];