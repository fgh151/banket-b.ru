<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\models\Promo */

$this->title = 'Изменить промо: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Промо', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="promo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
