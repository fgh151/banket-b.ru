<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\models\MobileUser */

$this->title = 'Изменить пользователя: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи приложения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="mobile-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
