<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\cabinet\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
$this->title = 'Банкетный Баттл';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#0a2adb">
    <meta name="msapplication-TileColor" content="#0a2adb">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<?php $this->beginBody() ?>

    <div class="container">
        <?= $content ?>
    </div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Банкет Батл <?= date('Y') ?></p>

        <p class="pull-right">
            Свидетельство о регистрации программного обеспечения 2016617962 от 19.07.2016<br>
            Патент 2641237 от 16.01.2018<br>
            <a href="https://www.restorate.ru/about/?ELEMENT_ID=12672" target="_blank">Заявление о соблюдении
                конфиденциальности</a>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
