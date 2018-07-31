<?php
/**
 * @var                                 $this \yii\web\View
 * @var \app\common\models\Organization $model
 */

use yii\widgets\ActiveForm;

?>
<div class="panel">
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name'); ?>
<?= $form->field($model, 'address')->textarea(); ?>
<?= $form->field($model, 'contact'); ?>
<?= $form->field($model, 'phone'); ?>
<?= $form->field($model, 'email'); ?>
<?= $form->field($model, 'password'); ?>

<?= \yii\helpers\Html::submitButton('Сохранить'); ?>


<?php ActiveForm::end() ?>
</div>