<?php
/**
 * @var $this \yii\web\View
 * @var $datProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;

?>


<?= \yii\helpers\Html::a('Добавить', ['create']) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'title:ntext',
        'image:image',
        'link:url',
        'browsingCount:integer:Просмотры',
        ['class' => 'yii\grid\ActionColumn'],
    ]
]); ?>