<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\models\Promo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,
        'title')->textInput(['maxlength' => true])->label('Разместить текст ') ?>

    <p>Оптимальный размер изображения 255 х 130 пикселей</p>
    <?= $form->field($model,
        'file_input')->fileInput(['maxlength' => true])->label('Поставить картинку') ?>

    <?= $form->field($model,
        'link')->textInput(['maxlength' => true])->label('Разместить ссылку') ?>
    <?= $form->field($model,
        'start')->textInput(['maxlength' => true])
                ->label('Дата начала показа')
                ->widget(\yii\jui\DatePicker::class, ['dateFormat' => 'yyyy-MM-dd']) ?>
    <?= $form->field($model, 'end')
             ->textInput(['maxlength' => true])
             ->label('Дата окончания')
             ->widget(\yii\jui\DatePicker::class, ['dateFormat' => 'yyyy-MM-dd', 'containerOptions' => ['minDate' => date('Y-M-d')]]) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
