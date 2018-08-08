<?php
/**
 * @var $this \yii\web\View
 * @var $datProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;

?>
<div class="row">
    <div class="col-xs-12"><div class="panel">

    <?= \yii\helpers\Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'image',
                'value' => function (\app\common\models\Promo $model) {
                    return '/' . \Yii::$app->imageresize->getUrl('@app/web/' . $model->image, 200, 200);
                },
                'format' => 'image'
            ],
            'link:url',
            'browsingCount:integer:Просмотры',
            ['class' => 'yii\grid\ActionColumn'],
        ]
]); ?>
</div>
    </div>

</div>
