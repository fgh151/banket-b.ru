<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \app\cabinet\models\SignupForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use app\common\models\Activity;
use yii\helpers\ArrayHelper;
use app\common\models\geo\GeoCity;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Для регистрации заполните форму ниже:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>


            <?= $form->field($model,
                'city_id')->dropDownList(ArrayHelper::map(GeoCity::find()->select([
                'id',
                'title'
            ])->asArray()->all(), 'id', 'title')); ?>

            <?= $form->field($model, 'address')->textarea() ?>

            <?= $form->field($model, 'contact') ?>
            <?= $form->field($model, 'phone')->widget(MaskedInput::class,
                ['mask' => '+7 (999) 999-99-99']) ?>

            <?= $form->field($model,
                'activities')->dropDownList(ArrayHelper::map(Activity::find()->select([
                'id',
                'title'
            ])->asArray()->all(), 'id', 'title'), ['multiply']); ?>

            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'url') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'confirm_password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться',
                    ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
