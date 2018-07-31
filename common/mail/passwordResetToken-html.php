<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\common\models\Organization */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">

    <p>Для восстановления пароя, перейдите по ссылке:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
