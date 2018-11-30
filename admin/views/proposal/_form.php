<?php

use app\common\models\geo\GeoCity;
use app\common\models\MobileUser;
use app\common\models\Proposal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\models\Proposal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proposal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'owner_id')->dropDownList(
        ArrayHelper::map(MobileUser::find()->select(['id', 'email'])->all(), 'id', 'email')
    ) ?>

    <?= $form->field($model, 'City')->dropDownList(ArrayHelper::map(GeoCity::find()->select([
        'id',
        'title'
    ])->asArray()->all(), 'id', 'title'),
        ['id' => 'city_id', 'prompt' => 'Выбрать...']); ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'time')->textInput()->widget(\yii\widgets\MaskedInput::class, ['mask' => '99:99']) ?>

    <?= $form->field($model, 'guests_count')->input('number') ?>

    <?= $form->field($model, 'amount')->input('number') ?>

    <?= $form->field($model, 'type')->dropDownList(
        Proposal::types()
    ) ?>

    <?= $form->field($model, 'event_type')->dropDownList(
        Proposal::typeLabels()
    ) ?>

    <?= $form->field($model, 'cuisine')->dropDownList(Proposal::cuisineLabels()) ?>

    <?= $form->field($model, 'dance')->checkbox() ?>

    <?= $form->field($model, 'private')->checkbox() ?>

    <?= $form->field($model, 'own_alcohol')->checkbox() ?>

    <?= $form->field($model, 'parking')->checkbox() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'floristics')->checkbox() ?>

    <?= $form->field($model, 'hall')->checkbox() ?>

    <?= $form->field($model, 'photo')->checkbox() ?>

    <?= $form->field($model, 'stylists')->checkbox() ?>

    <?= $form->field($model, 'cake')->checkbox() ?>

    <?= $form->field($model, 'entertainment')->checkbox() ?>

    <?= $form->field($model, 'transport')->checkbox() ?>

    <?= $form->field($model, 'present')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
