<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\common\models\PromoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//TODO: img path (

$this->title                   = 'Предложения от ресторанов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'organization.name:ntext:Организация',
            'title',
            [
                'attribute' => 'image',
                'value'     => function (\app\common\models\Promo $model) {
                    return 'http://f-cabinet.banket.restorate.ru/' . \Yii::$app->imageresize->getUrl('/var/www/battle/cabinet/web/' . $model->image,
                            200, 200);
                },
                'format'    => 'image'
            ],
            'link:url',
            //'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
