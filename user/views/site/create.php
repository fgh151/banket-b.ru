<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\user\models\ProposalForm
 */
?>

<?= yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['site/auth'],
    'popupMode' => false,
]) ?>
