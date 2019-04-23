<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\common\models\Proposal
 */

use yii\helpers\Html;

//var_dump($model->getAnswers());

$goBtn = 'Перейти';
?>

<?= Html::a('Отклонить', ['battle/reject', 'id' => $model->id], ['class' => 'btn btn-danger']); ?>
<?= Html::a($goBtn, ['conversation/index', 'proposalId' => $model->id], ['class' => 'btn btn-primary']); ?>
<?= $this->render('_info', ['key' => $model]); ?>
