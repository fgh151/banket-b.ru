<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_field')->fileInput(); ?>

    <?= $form->field($model, 'preview_text')->widget(Widget::class, [
        'settings' => [
            'minHeight' => 200,
            'plugins' => [
                'fullscreen',
            ],
            'imageUpload' => Url::to(['/files/image-upload']),
            'imageDelete' => Url::to(['/files/file-delete']),
            'imageManagerJson' => Url::to(['/files/images-get']),
        ],
    ]); ?>

    <?= $form->field($model, 'content')->widget(Widget::class, [
        'settings' => [
            'minHeight' => 200,
            'plugins' => [
                'fullscreen',
            ],
            'imageUpload' => Url::to(['/files/image-upload']),
            'imageDelete' => Url::to(['/files/file-delete']),
            'imageManagerJson' => Url::to(['/files/images-get']),
        ],
    ]); ?>

    <?= $form->field($model, 'seo_description')->textarea(); ?>
    <?= $form->field($model, 'seo_keywords')->textarea(); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
