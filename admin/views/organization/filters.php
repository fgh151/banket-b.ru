<?php
/**
 * @var \yii\web\View $this
 * @var \app\common\models\ProposalSearch $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'guests_count'); ?>
<?= $form->field($model, 'amount'); ?>
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
