<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 09.08.2018
 * Time: 12:19
 * @var $key \app\common\models\Proposal
 */

use yii\bootstrap\Modal;
use app\common\models\Proposal;
?>



<?php
Modal::begin([
'header' => '<h2>Заявка № '.$key->id.'</h2>',
'toggleButton' => ['label' => 'Подробнее', 'class' => 'btn btn-success'],
]);

//var_dump($model, $key, $index);

echo \yii\widgets\DetailView::widget([
    'model' => $key,
    'attributes' => [
        'City','date', 'time','guests_count',
        'amount',
        [
            'attribute' => 'type',
            'value' => function(Proposal $model) {return  Proposal::types()[$model->type];}
        ],
        'eventType',
        'cuisineString',
        'dance:boolean',
        'private:boolean',
        'own_alcohol:boolean',
        'parking:boolean',
        'comment',
        'floristics:boolean',
        'hall:boolean',
        'photo:boolean',
        'stylists:boolean',
        'entertainment:boolean',
        'cake:boolean',
        'transport:boolean',
        'present:boolean'
    ]
]);


Modal::end();