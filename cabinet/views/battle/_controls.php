<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\common\models\Proposal
 */

use yii\helpers\Html;

$goBtn = 'Перейти';
$messagesCount = count($model->getAnswers()) - $model->getReadMessagesCount(Yii::$app->getUser()->getId());
if ($messagesCount > 0) {
    $goBtn .= ' <span class="badge">' . $messagesCount . '</span>';
}
?>

<?= Html::a('Отклонить', ['battle/reject', 'id' => $model->id], ['class' => 'btn btn-danger']); ?>
<?= Html::a($goBtn, ['conversation/index', 'proposalId' => $model->id], ['class' => 'btn btn-primary']); ?>
<?= $this->render('_info', ['key' => $model]); ?>
