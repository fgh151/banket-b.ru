<?php

use app\common\models\Proposal;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $organization \app\common\models\Organization
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel app\common\models\ProposalSearch
 */

use app\common\components\Constants;

$this->title = 'Аукционы';

$ru_month = [
    'Января',
    'Февраля',
    'Марта',
    'Апреля',
    'Майя',
    'Июня',
    'Июля',
    'Августа',
    'Сентября',
    'Октября',
    'Ноября',
    'Декабря'
];
$en_month = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];

/** @var \app\common\components\Formatter $formatter */
$formatter = Yii::$app->formatter;
?>
<div class="site-index">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <h1>Аукционы</h1>
                </div>
                <div class="col-xs-12 col-md-6">

                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">


                    <?= /** @noinspection PhpUnhandledExceptionInspection */
                    \yii\grid\GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'  => $searchModel,
                        'rowOptions'=>function(Proposal $model){
                            if($model->status !== Constants::PROPOSAL_STATUS_CREATED){
                                return ['class' => 'proposal-inactive'];
                            }
                            if ($model->date < date('Y-m-d')) {
                                return ['class' => 'proposal-inactive'];
                            }
                        },
                        'columns'      => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'id',
                                'label'     => '№'
                            ],
                            [
                                    'attribute' =>'date',
                                'label' => 'Дата',
                                'value' => function (Proposal $model) use ($ru_month, $en_month) {
                                    return str_replace($en_month, $ru_month,
                                        $model->getWhen()->format('d F Y в H:i'));
                                }
                            ],
                            [
                                'attribute' => 'event_type',
                                'label'     => 'Тип мероприятия',
                                'value'     => function (Proposal $model) {
                                    return Proposal::typeLabels()[$model->event_type];
                                },
                                'filter'    => Proposal::typeLabels()
                            ],
                            'guests_count',
                            [
                                'attribute' => 'amount',
                                'label'     => 'Сумма от'
                            ],
                            'dance:boolean',
                            'private:boolean',
                            'own_alcohol:boolean',
                            'parking:boolean',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {reject} {info}',
                                'buttons' => [
                                    'reject' => function ($model, $key, $index) {
                                        if ($key->status === Constants::PROPOSAL_STATUS_CREATED && $key->date >= date('Y-m-d')) {

                                            return Html::a('Отклонить',
                                                ['reject', 'id' => $key->id],
                                                ['class' => 'btn btn-danger']);
                                        }
                                        return null;
                                    },
                                    'view'   => function ($model, $key, $index) {
                                        return Html::a('Перейти',
                                            ['conversation/index', 'proposalId' => $key->id],
                                            ['class' => 'btn btn-primary']);
                                    },
                                    'info'   => function ($model, $key, $index) {
                                        return $this->render('_info',
                                            ['model' => $model, 'key' => $key, 'index' => $index]);
                                    }
                                ]
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
