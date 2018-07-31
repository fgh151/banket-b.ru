<?php
/**
 * @var $this \yii\web\View
 * @var $datProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;

?>

<div class="panel">

    <?= \yii\helpers\Html::a('Добавить', ['create']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title:ntext',
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
