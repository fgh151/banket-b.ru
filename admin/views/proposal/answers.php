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
            },
            'label' => 'Организация'
        ],
        [
            'format' => 'raw',
            'attribute' => 'message',
            'header' => 'Ответ'
        ],
        'created_at:datetime:Дата',
        [
            'header' => 'Ответить',
            'value' => function (Message $model) {
                return \yii\helpers\Html::a('Ответить', ['proposal/answer', 'userId' => $model->user_id, 'organizationId' => $model->organization_id, 'proposalId' => $model->proposal_id]);
            },
            'format' => 'html'
        ]
    ],
    'emptyText' => 'На данную заявку ответов не поступало'
]);
