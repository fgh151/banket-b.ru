<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\common\models\Promo
 */

use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'title'); ?>
<?= $form->field($model, 'image'); ?>
<?= $form->field($model, 'link'); ?>

<?= \yii\helpers\Html::submitButton('Сохранить'); ?>

<?php ActiveForm::end() ?>
