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
                'domain' => ".banket-b.ru",
            ],
        ],
        'user' => [
            // ...

            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'path' => '/',
                'domain' => ".banket-b.ru",
            ],
        ],
        'request' => [
            // ...
            'csrfCookie' => [
                'name' => '_csrf',
                'path' => '/',
                'domain' => ".banket-b.ru",
            ],
        ],
    ],
];