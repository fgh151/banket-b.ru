<?php
/**
 * @var \yii\web\View $this
 * @var \app\common\models\Proposal $proposal
 * @var \app\common\models\Message[] $answers
 */

use app\api\models\Organization;
use app\common\models\Message;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

$this->title = 'Ответы на заявку №: ' . $proposal->id;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $proposal->id, 'url' => ['view', 'id' => $proposal->id]];
$this->params['breadcrumbs'][] = 'Ответы';
?>

<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $answers,
    ]),
    'columns' => [
        [
            'attribute' => 'organization_id',
            'value' => function (Message $model) {
                return Organization::findOne($model->organization_id)->name;
            }
        ],
        'message',
        'created_at:datetime'
    ]
]);
