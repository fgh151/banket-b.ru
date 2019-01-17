<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\common\models\Proposal
 */

use yii\helpers\Html;

//var_dump($model->getAnswers());

$goBtn = 'Перейти';
$messagesCount = count($model->getOrganizationAnswers(Yii::$app->getUser()->getId())) - $model->getReadMessagesCount(Yii::$app->getUser()->getId());
//var_dump(count($model->getAnswers()));
if ($messagesCount > 0) {
    $goBtn .= ' <span class="badge">' . $messagesCount . '</span>';
}
?>

<?= Html::a('Отклонить', ['battle/reject', 'id' => $model->id], ['class' => 'btn btn-danger']); ?>
<?= Html::a($goBtn, ['conversation/index', 'proposalId' => $model->id], ['class' => 'btn btn-primary']); ?>
<?= $this->render('_info', ['key' => $model]); ?>
