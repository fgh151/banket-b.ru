<?php

use app\common\models\Proposal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\common\models\Proposal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-view">

    <h1>Заявка №<?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'City', 'date', 'time', 'guests_count',
            'amount',
            [
                'attribute' => 'type',
                'value' => function (Proposal $model) {
                    return Proposal::types()[$model->type];
                }
            ],
            'eventType',
            'cuisineString',
            'dance:boolean',
            'private:boolean',
            'own_alcohol:boolean',
            'parking:boolean',
            [
                'attribute' => 'comment',
                'value' => function (Proposal $model) {
                    return Yii::$app->getUser()->getId() === 1 ? $model->comment : str_replace('бб', '', $model->comment);
                }
            ],
            'floristics:boolean',
            'hall:boolean',
            'photo:boolean',
            'stylists:boolean',
            'entertainment:boolean',
            'cake:boolean',
            'transport:boolean',
            'present:boolean'
        ]
    ]); ?>

</div>
