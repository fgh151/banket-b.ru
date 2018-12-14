<?php

use app\common\components\Constants;
use app\common\models\Proposal;
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
                'label' => 'Прямая заявка',
                'value' => function (Proposal $model) {
                    return implode('<br />', $model->getDirectOrganizations());
                },
                'format' => 'html'
            ],
            'created_at:datetime',
            [
                'label' => 'Ответы',
                'value' => function (Proposal $model) {
                    $result = [];
                    foreach ($model->getAnswers() as $org => $time) {
                        $result[] = $org . ' ' . $time;
                    }
                    return implode('<br />', $result);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'status',
                'value' => function (Proposal $model) {

                    switch ($model->status) {
                        case Constants::PROPOSAL_STATUS_CLOSED:
                            {
                                return 'Закрыта';
                                break;
                            }
                        case Constants::PROPOSAL_STATUS_REJECT :
                            {
                                return 'Закрыта';
                                break;
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
                'attribute' => null,
                'label' => 'Ответы для РР',
                'value' => function (Proposal $model) {
                    if ($model->owner_id == Yii::$app->params['restorateUserId']) {
                        return Html::a('Ответы', ['proposal/answers', 'id' => $model->id]);
                    }
                },
                'format' => 'html'
            ],
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
