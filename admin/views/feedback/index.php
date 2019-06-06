<?php

use app\common\models\Feedback;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mobile-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Пользователь',
                'attribute' => 'user.name'
            ],
            [
                'label' => 'Тедефон',
                'attribute' => 'user.phone'
            ],
            [
                'label' => 'Дата обращения',
                'attribute' => 'created_at'
            ],
            [
                'attribute' => 'content',
                'value' => function (Feedback $model) {
                    return Html::decode($model->content);
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'text-wrap'],
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
