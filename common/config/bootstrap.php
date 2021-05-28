<?php

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@cabinet', dirname(__DIR__, 2) . '/cabinet');
Yii::setAlias('@user', dirname(__DIR__, 2) . '/user');
Yii::setAlias('@admin', dirname(__DIR__, 2) . '/admin');
Yii::setAlias('@console', dirname(__DIR__, 2) . '/console');
Yii::setAlias('@bower-asset', dirname(__DIR__, 2) . '/vendor/bower-asset');


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
