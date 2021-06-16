<?php
/**
 * @var $this \yii\web\View
 */
?>

<?= yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['site/auth'],
    'popupMode' => false,
]) ?>
