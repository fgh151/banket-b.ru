<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\common\models\ProposalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить заявку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'owner.email',
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {close}',
                'buttons' => [
                    'close' => function ($url, $model, $key) {     // render your custom button
                        return ' ' . Html::a('<span class="glyphicon glyphicon-remove"></span>', ['proposal/close', 'id' => $model->id]);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
