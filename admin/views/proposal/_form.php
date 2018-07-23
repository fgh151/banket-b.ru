<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\models\Proposal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proposal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'owner_id')->textInput() ?>

    <?= $form->field($model, 'City')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'guests_count')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'event_type')->textInput() ?>

    <?= $form->field($model, 'metro')->textInput() ?>

    <?= $form->field($model, 'cuisine')->textInput() ?>

    <?= $form->field($model, 'dance')->checkbox() ?>

    <?= $form->field($model, 'private')->checkbox() ?>

    <?= $form->field($model, 'own_alcohol')->checkbox() ?>

    <?= $form->field($model, 'parking')->checkbox() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
