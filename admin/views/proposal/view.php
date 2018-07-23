<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\common\models\Proposal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'owner_id',
            'City',
            'date',
            'time',
            'guests_count',
            'amount',
            'type',
            'event_type',
            'metro',
            'cuisine',
            'dance:boolean',
            'private:boolean',
            'own_alcohol:boolean',
            'parking:boolean',
            'comment:ntext',
        ],
    ]) ?>

</div>
