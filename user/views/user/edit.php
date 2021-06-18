<?php
/**
 * @var $this View
 * @var MobileUser $model
 */

use app\common\models\MobileUser;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


?>
<div class="profile-edit">
    <?php $form = ActiveForm::begin(['id' => 'update']); ?>

    <?= $form->field($model, 'email')->input('email'); ?>
    <?= $form->field($model, 'phone')->input('tel'); ?>
    <?= $form->field($model, 'name'); ?>


    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>

    <?php ActiveForm::end() ?>
</div>

