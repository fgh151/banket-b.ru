<?php

use app\common\models\Organization;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\common\models\OrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            'name',
            'phone',
            [
                'attribute' => 'state',
                'filter' => Organization::stateLabels(),
                'value' => function (Organization $model) {
                    return Organization::stateLabels()[$model->state];
                }
            ],
            [
                'attribute' => 'state_direct',
                'filter' => Organization::stateLabels(),
                'value' => function (Organization $model) {
                    return Organization::stateLabels()[$model->state_direct];
                }
            ],
            [
                'attribute' => 'citY_id',
                'label' => 'Город',
                'value' => function (Organization $model) {
                    return $model->city->title;
                },
            ],

            'created_at:date:Дата регистрации',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {filters} {delete}',
                'buttons' => ['filters' => function (string $model, Organization $key, $index) {
                    return Html::a('<span class="glyphicon glyphicon-filter"></span>', Url::to(['organization/filters', 'id' => $key->id]));
                }
                ]
            ],
            [
                'label' => '',
                'format' => 'html',
                'value' => function (Organization $model) {
                    return Html::a('Авторизация', ['organization/auth', 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
