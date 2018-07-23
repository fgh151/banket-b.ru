<?php
/**
 * @var $this yii\web\View
 * @var $model \app\common\models\Proposal
 */
?>

<div class="col-md-3">
    <?= \yii\helpers\Html::a('Заявка № ' . $model->id, ['conversation/index', 'proposalId' => $model->id]); ?>
    <?= $model->comment ?>
</div>