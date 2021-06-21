<?php

use app\common\components\Constants;
use app\common\models\Proposal;
use yii\grid\ActionColumn;
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
        <?= Html::a('Добавить заявку от имени Ресторанного рейтинга', ['create-rr'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'owner.email',
            'owner.phone',
            'City',
            'date',
            'time',
            'created_at:datetime',
            [
                'attribute' => 'status',
                'value' => static function (Proposal $model) {

                    switch ($model->status) {
                        case Constants::PROPOSAL_STATUS_REJECT:
                        case Constants::PROPOSAL_STATUS_CLOSED:
                        {
                            return 'Закрыта';
                        }
                        default :
                        {
                            return 'Открыта';
                            }
                    }
                },
                'filter' => [
                    Constants::PROPOSAL_STATUS_CLOSED => 'Закрыта',
                    Constants::PROPOSAL_STATUS_CREATED => 'Открыта'
                ]
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {close}',
                'buttons' => [
                    'close' => static function ($url, $model, $key) {     // render your custom button
                        return ' ' . Html::a('<span class="glyphicon glyphicon-remove"></span>',
                                ['proposal/close', 'id' => $model->id]);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
