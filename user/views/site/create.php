<?php
/**
 * @var $this View
 * @var $model ProposalForm
 */

use app\common\models\Proposal;
use app\user\models\ProposalForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>

<div class="col-lg-4 col-lg-offset-4">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (Yii::$app->getUser()->getIsGuest()): ?>

        <h3>
            <?= Html::a('Войдите', ['site/login']) ?> или представьтесь:
        </h3>

        <?= $form->field($model, 'name')->label('Как Вас зовут?'); ?>
        <?= $form->field($model, 'phone')->label('Укажите Ваш телефон'); ?>
        <?= $form->field($model, 'email')->label('Укажите Вашу почту'); ?>

    <?php endif; ?>

    <?php if (false === ProposalForm::hasDataInStore()): ?>
        <h3>Когда будет банкет?</h3>
        <?= $form->field($model, 'date')->input('date'); ?>
        <?= $form->field($model, 'time')->input('time'); ?>
    <?php endif; ?>

    <h3>Какой банкет Вас интересует?</h3>

    <?= $form->field($model, 'guests_count'); ?>
    <?= $form->field($model, 'amount'); ?>
    <?= $form->field($model, 'event_type')->dropDownList(
        Proposal::typeLabels()
    ) ?>

    <?= $form->field($model, 'dance')->checkbox() ?>

    <?= $form->field($model, 'private')->checkbox() ?>

    <?= $form->field($model, 'own_alcohol')->checkbox() ?>

    <?= $form->field($model, 'parking')->checkbox() ?>

    <?= $form->field($model, 'floristics')->checkbox() ?>

    <?= $form->field($model, 'hall')->checkbox() ?>

    <?= $form->field($model, 'photo')->checkbox() ?>

    <?= $form->field($model, 'stylists')->checkbox() ?>

    <?= $form->field($model, 'cake')->checkbox() ?>

    <?= $form->field($model, 'entertainment')->checkbox() ?>

    <?= $form->field($model, 'transport')->checkbox() ?>

    <?= $form->field($model, 'present')->checkbox() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6])->label('Может есть дополнительные пожелания?') ?>

    <div class="form-group">
        <?= Html::submitButton('Создать банкет', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

