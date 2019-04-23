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
                        <?php ActiveForm::end(); ?>
                    </div>

                    <div class="col-xs-12">

                        <div class="col-md-2">
                            Статус
                        </div>
                        <div class="col-md-2">
                            Событие
                        </div>
                        <div class="col-md-2">
                            Гостей
                        </div>
                        <div class="col-md-2">
                            Ставок
                        </div>
                        <div class="col-md-2">
                            Лучшая ставка
                        </div>
                        <div class="col-md-2">
                            Ваша ставка
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <?= ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemView' => '_proposal_item',
                            'options' => [

                                'class' => 'row',
                            ],
                            'itemOptions' => [
                                'class' => 'col-xs-12'
                            ],
                            'afterItem' => function (Proposal $model, $key, $index, ListView $list) {
                                $nextProposal = null;
                                if (isset($list->dataProvider->getModels()[$index + 1])) {
                                    $nextProposal = $list->dataProvider->getModels()[$index + 1];
                                }

                                /** @var \yii\web\View $this */
                                return $this->render('_after_item', [
                                    'currentProposal' => $model,
                                    'nextProposal' => $nextProposal,
                                    'key' => $key,
                                    'index' => $index,
                                    'list' => $list
                                ]);
                            }
                        ]) ?>
                    </div>
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