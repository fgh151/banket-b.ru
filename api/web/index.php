<?php
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');
//
//require __DIR__ . '/../../vendor/autoload.php';
//require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
//require __DIR__ . '/../../common/config/bootstrap.php';
//require __DIR__ . '/../config/bootstrap.php';
//
//$config = yii\helpers\ArrayHelper::merge(
//    require __DIR__ . '/../../common/config/main.php',
//    require __DIR__ . '/../../common/config/main-local.php',
//    require __DIR__ . '/../config/main.php',
//    require __DIR__ . '/../config/main-local.php'
//);
//
//(new yii\web\Application($config))->run();


defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/heroku-local.php',
    require __DIR__ . '/../config/main.php',
    [
        'components' => [
            'request' => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                'cookieValidationKey' => 'GK_DtXuAbQD31r07tNNZlocsZyogzC4a',
            ],
        ],
    ]
);

(new yii\web\Application($config))->run();
