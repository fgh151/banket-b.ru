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
<?= $form->field($model, 'dance')->checkbox(); ?>
<?= $form->field($model, 'private')->checkbox(); ?>
<?= $form->field($model, 'own_alcohol')->checkbox(); ?>
<?= $form->field($model, 'parking')->checkbox(); ?>

<?= Html::submitButton('Сохранить'); ?>
<?php ActiveForm::end(); ?>
