<?php

use app\common\components\Constants;
use app\common\models\geo\GeoCity;
use app\common\models\Organization;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\models\Organization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,
        'city_id')->dropDownList(ArrayHelper::map(GeoCity::find()->select([
        'id',
        'title'
    ])->asArray()->all(), 'id', 'title'),
        ['id' => 'city_id', 'prompt' => 'Выбрать...']); ?>

    <?= $form->field($model, 'district_id')->widget(DepDrop::class, [
        'options' => ['id' => 'district_id'],
        'pluginOptions' => [
            'depends' => ['city_id'],
            'placeholder' => 'Выбрать...',
            'url' => Url::to(['/site/district'])
        ],
        'pluginEvents' => [
            "depdrop:afterChange" => "function(event, id, value) { changeMetroSelector(); }",
        ]
    ]); ?>


    <?= $form->field($model, 'status')->dropDownList([
        Constants::USER_STATUS_ACTIVE => 'Активный',
        Constants::USER_STATUS_DELETED => 'Удаленный'
    ]) ?>




    <?= $form->field($model, 'image_field')->fileInput()->label('Добавить картинку'); ?>


    <?= $form->field($model, 'state')->dropDownList(Organization::stateLabels()) ?>

    <?= $form->field($model, 'state_promo')->dropDownList(Organization::stateLabels()) ?>

    <?= $form->field($model, 'state_statistic')->dropDownList(Organization::stateLabels()) ?>


    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
