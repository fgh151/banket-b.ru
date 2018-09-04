<?php
/**
 * @var $this \yii\web\View
 * @var $datProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
use app\common\models\Promo;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-xs-12">
        <div class="panel">

            <?= \yii\helpers\Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns'      => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'title',
                        'value'     => function (Promo $model) {
                            return Html::a($model->title,
                                ['promo/update', 'id' => $model->id]);
                        },
                        'format'    => 'raw'
                    ],
                    [
                        'attribute' => 'image',
                        'value'     => function (Promo $model) {
                            return '/' . \Yii::$app->imageresize->getUrl('@app/web/' . $model->image,
                                    200, 200);
                        },
                        'format'    => 'image'
                    ],
                    'link:url',
//            'browsingCount:integer:Просмотры',
//            ['class' => 'yii\grid\ActionColumn'],
                ]
            ]); ?>
        </div>
    </div>

</div>
