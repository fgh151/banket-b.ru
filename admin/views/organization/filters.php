<?php
/**
 * @var \yii\web\View $this
 * @var \app\common\models\ProposalSearch $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'guests_count')->label('Количество гостей от'); ?>
<?= $form->field($model, 'guests_count_to')->label('Количество гостей до'); ?>
<?= $form->field($model, 'amount')->label('Стоимость от'); ?>
<?= $form->field($model, 'amount_to')->label('Стоимость до'); ?>
<?= $form->field($model, 'danceFalse')->checkbox(); ?>
<?= $form->field($model, 'danceTrue')->checkbox(); ?>
<?= $form->field($model, 'privateFalse')->checkbox(); ?>
<?= $form->field($model, 'parkingTrue')->checkbox(); ?>
<?= $form->field($model, 'own_alcoholFalse')->checkbox(); ?>
<?= $form->field($model, 'own_alcoholTrue')->checkbox(); ?>
<?= $form->field($model, 'parkingTrue')->checkbox(); ?>
<?= $form->field($model, 'parkingFalse')->checkbox(); ?>

<?= Html::submitButton('Сохранить'); ?>
<?php ActiveForm::end(); ?>
