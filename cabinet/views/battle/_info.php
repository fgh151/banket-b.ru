<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 09.08.2018
 * Time: 12:19
 * @var $key \app\common\models\Proposal
 */

use app\common\models\Proposal;
use yii\bootstrap\Modal;

?>



<?php
Modal::begin([
'header' => '<h2>Заявка № '.$key->id.'</h2>',
'toggleButton' => ['label' => 'Подробнее', 'class' => 'btn btn-success'],
]);

//var_dump($model, $key, $index);

$columns = [
    'City', 'date', 'time', 'guests_count',
    'amount',
    [
        'attribute' => 'type',
        'value' => function (Proposal $model) {
            return Proposal::types()[$model->type];
        }
    ],
    'eventType',
    'cuisineString',
    'dance:boolean',
    'private:boolean',
    'own_alcohol:boolean',
    'parking:boolean',
    [
        'attribute' => 'comment',
        'value' => function (Proposal $model) {
            return Yii::$app->getUser()->getId() === 1 ? $model->comment : str_replace('бб', '', $model->comment);
        }
    ],
    'floristics:boolean',
    'hall:boolean',
    'photo:boolean',
    'stylists:boolean',
    'entertainment:boolean',
    'cake:boolean',
    'transport:boolean',
    'present:boolean'
];

if ($key->owner_id === Yii::$app->params['restorateUserId']) {
    array_unshift($columns, [
        [
            'attribute' => null,
            'label' => 'Заявка пришда через Ресторанный рейтинг',
            'value' => null
        ],
    ]);
}

echo \yii\widgets\DetailView::widget([
    'model' => $key,
    'attributes' => $columns
]);


Modal::end();
