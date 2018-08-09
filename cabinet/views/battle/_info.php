<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 09.08.2018
 * Time: 12:19
 */

use yii\bootstrap\Modal;
?>



<?php
Modal::begin([
'header' => '<h2>Заявка № '.$key->id.'</h2>',
'toggleButton' => ['label' => 'Подробнее', 'class' => 'btn btn-success'],
]);

//var_dump($model, $key, $index);

echo \yii\widgets\DetailView::widget(['model' => $key]);


Modal::end();
