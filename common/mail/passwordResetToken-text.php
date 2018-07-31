<?php

/* @var $this yii\web\View */
/* @var $user app\common\models\Organization */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

Для восстановления пароя, перейдите по ссылке:

<?= $resetLink ?>
