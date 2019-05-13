<?php
/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="row">
    <div class="col-xs-12">
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
</div>

<div class="panel-header hidden-xs proposal-columns">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-2">
                Текст
            </div>
            <div class="col-sm-2">
                Изображение
            </div>
            <div class="col-sm-4">
                Ссылка
            </div>
            <div class="col-sm-2">
                Просмотры
            </div>
            <div class="col-sm-2">
                Переходы
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">


        <?= ListView::widget([

            'layout' => "{items}\n<div class='col-xs-12 text-center'>{pager}</div>",
            'dataProvider' => $dataProvider,

            'itemView' => '_promo_item',
            'options' => [

                'class' => 'row',
            ],
            'itemOptions' => [
                'class' => 'col-xs-12'
            ]
        ]) ?>
    </div>
</div>
