<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\Proposal */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proposals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Proposal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'owner_id',
            'City',
            'date',
            'time',
            //'guests_count',
            //'amount',
            //'type',
            //'event_type',
            //'metro',
            //'cuisine',
            //'dance:boolean',
            //'private:boolean',
            //'own_alcohol:boolean',
            //'parking:boolean',
            //'comment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
