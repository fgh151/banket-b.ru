<?php
define('YII_ENV_DEV', getenv('ENVIRONMENT') === 'dev');
define('YII_DEBUG', getenv('ENVIRONMENT') === 'dev');
define('YII_ENV', getenv('ENVIRONMENT'));

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/web.php',
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
