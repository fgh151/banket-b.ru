<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\common\models\Promo */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Предложения от ресторанов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
