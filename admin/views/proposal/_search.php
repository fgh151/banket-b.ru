<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\models\Proposal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proposal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'owner_id') ?>

    <?= $form->field($model, 'City') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'guests_count') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'event_type') ?>

    <?php // echo $form->field($model, 'metro') ?>

    <?php // echo $form->field($model, 'dance')->checkbox() ?>

    <?php // echo $form->field($model, 'private')->checkbox() ?>

    <?php // echo $form->field($model, 'own_alcohol')->checkbox() ?>

    <?php // echo $form->field($model, 'parking')->checkbox() ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
