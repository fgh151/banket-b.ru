<?php

use app\common\models\Proposal;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $organization \app\common\models\Organization
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel app\common\models\ProposalSearch
 */

$this->title = 'Заявки';

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
<div class="battle-index">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <h1>Заявки</h1>
                </div>
                <div class="col-xs-12 col-md-6">

                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'proposal-search']); ?>
                    <div class="col-xs-12 col-md-1">
                        <?= $form->field($searchModel, 'date'); ?>
                    </div>
                    <div class="col-xs-12 col-md-1">
                        <?= $form->field($searchModel, 'event_type')
                            ->dropDownList(Proposal::typeLabels(), ['prompt' => 'Выбрать'])
                            ->label('Тип'); ?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?= $form->field($searchModel, 'amount'); ?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?= $form->field($searchModel, 'guests_count'); ?>
                    </div>
                    <div class="col-xs-12 col-md-1">
                        <?= $form->field($searchModel, 'dance')->dropDownList([0 => 'Нет', 1 => 'Да'], ['prompt' => 'Выбрать']); ?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?= $form->field($searchModel, 'private')->dropDownList([0 => 'Нет', 1 => 'Да'], ['prompt' => 'Выбрать']); ?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?= $form->field($searchModel, 'own_alcohol')->dropDownList([0 => 'Нет', 1 => 'Да'], ['prompt' => 'Выбрать']); ?>
                    </div>
                    <div class="col-xs-12 col-md-1">
                        <?= $form->field($searchModel, 'parking')->dropDownList([0 => 'Нет', 1 => 'Да'], ['prompt' => 'Выбрать']); ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_proposal_item',
                        'options' => [

                            'class' => 'row',
                        ],
                        'itemOptions' => [
                            'class' => 'col-xs-12'
                        ]
                    ]) ?>
                </div>
                <?php /*
                <div class="col-xs-12">


                    <?= /** @noinspection PhpUnhandledExceptionInspection
                    \yii\grid\GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'  => $searchModel,
                        'rowOptions'   => function (Proposal $model) {
                            if ($model->status !== Constants::PROPOSAL_STATUS_CREATED) {
                                return ['class' => 'proposal-inactive'];
                            }
                            if ($model->date < date('Y-m-d')) {
                                return ['class' => 'proposal-inactive'];
                            }
                            return [];
                        },
                        'columns'      => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'id',
                                'label'     => '№'
                            ],
//                            [
//                                'attribute' => 'city_id',
//                                'filter' => ArrayHelper::map(GeoCity::find()->select([
//                                    'id',
//                                    'title'
//                                ])->asArray()->all(), 'id', 'title')
//                            ],
                            [
                                'attribute' => 'date',
                                'label'     => 'Дата',
                                'value'     => function (Proposal $model) use (
                                    $ru_month,
                                    $en_month
                                ) {
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
                                                ['battle/reject', 'id' => $key->id],
                                                ['class' => 'btn btn-danger']);
                                        }

                                        return null;
                                    },
                                    'view'   => function ($model, $key, $index) {
                                        if ($key->status === Constants::PROPOSAL_STATUS_CREATED && $key->date >= date('Y-m-d')) {
                                            return Html::a('Перейти',
                                                ['conversation/index', 'proposalId' => $key->id],
                                                ['class' => 'btn btn-primary']);
                                        }
                                    },
                                    'info'   => function ($model, $key, $index) {
                                        /** @var Proposal $model
                                        if ($key->status === Constants::PROPOSAL_STATUS_CREATED && $key->date >= date('Y-m-d')) {
                                            return $this->render('_info',
                                                ['model' => $model, 'key' => $key, 'index' => $index]);
                                        } else {
                                            return 'Заявка закрыта, стоимость заявки ' . $key->guests_count * $key->amount . ' ₽';
                                        }
                                    }
                                ]
                            ],
                        ],
                    ]) ?>
                </div> */ ?>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$("#proposal-search :input").change(function() {
  $('#proposal-search').submit();
});
JS;

$this->registerJs($js);