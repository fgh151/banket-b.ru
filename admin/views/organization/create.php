<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\common\models\Organization */

$this->title = 'Create Organization';
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php var_dump($model->errors); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
