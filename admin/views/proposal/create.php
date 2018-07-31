<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\common\models\Proposal */

$this->title = 'Создать заявку';
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->errors): ?>
        <?php print_r($model->errors); ?>
    <?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
