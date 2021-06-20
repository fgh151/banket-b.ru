<?php

use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel app\common\models\ProposalSearch
 */

$this->title = 'Заявки';

?>

    <div class="page-title clearfix">
        <h1><?= $this->title ?></h1>
    </div>

    <div class="panel-header hidden-xs proposal-columns">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-3">
                    Статус
                </div>
                <div class="col-sm-3">
                    Событие
                </div>
                <div class="col-sm-1">
                    Гостей
                </div>
                <div class="col-sm-1">
                    Ставок
                </div>
                <div class="col-sm-2">
                    Лучшая ставка
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= ListView::widget([
                'layout' => "{items}\n<div class='col-xs-12 text-center'>{pager}</div>",
                'dataProvider' => $dataProvider,
                'itemView' => '_proposal_item',
                'options' => [

                    'class' => 'row',
                ],
                'itemOptions' => [
                    'class' => 'col-xs-12'
                ],
            ]) ?>
        </div>
    </div>
<?php
$js = <<<JS
$("#proposal-search :input").change(function() {
  $('#proposal-search').submit();
});
JS;

$this->registerJs($js);
