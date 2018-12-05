<?php

use app\common\models\Organization;
use yii\grid\GridView;
use yii\helpers\Html;
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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            'name',
            //'address:ntext',
            //'contact',
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
//            [
//                'label' => 'hall',
//                'value' => function (Organization $model) {
//        $res = '';
//                    if (!empty($model->halls)) {
//                        foreach ($model->halls as $hall) {
//                            $res.= ' '.$hall->size;
//                        }
//                    }
//                    return $res;
//                }
//            ],
            //'created_at',
            //'updated_at',
            [
                'attribute' => 'citY_id',
                'label' => 'Город',
                'value' => function (Organization $model) {
                    return $model->city->title;
                },
            ],

            'created_at:date:Дата регистрации',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
