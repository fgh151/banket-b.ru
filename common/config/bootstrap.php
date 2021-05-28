<?php

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@cabinet', dirname(dirname(__DIR__)) . '/cabinet');
Yii::setAlias('@user', dirname(dirname(__DIR__)) . '/user');
Yii::setAlias('@admin', dirname(dirname(__DIR__)) . '/admin');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@bower-asset', dirname(dirname(__DIR__)) . '/vendor/bower-asset');


// В случае, если запуск происходит не из Docker, то вручную перечитываем .env файл.
if (false === getenv('DOCKER')) {
    // Загрузка переменных окружения и сообщение об ошибке, если файл отсутствует.
    $environment = parse_ini_file(__DIR__ . '/../../.env', false, INI_SCANNER_RAW);

    // Работа без файла конфигурации невозможна, так что лучше сразу сообщить о проблеме, чем разбираться с последствиями.
    if ($environment === false) {
        die('Опаньки! Отсутствует файл .env-файл. Подробности в README.md');
    }

    // Устанавливаем переменные окружения из файла, но только те, которых уже там не было.
    foreach (array_diff_key($environment, $_ENV) as $param => $value) {
        putenv("{$param}={$value}");
    }
}
