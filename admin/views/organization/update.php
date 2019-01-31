<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 *
 * @var $model app\common\models\Organization
 * @var $metro \app\common\models\OrganizationLinkMetro[]
 * @var $districts array
 * @var $metros \app\common\models\OrganizationLinkMetro[]
 * @var $halls \app\common\models\RestaurantHall[]
 */

$this->title = 'Изменить организацию: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="organization-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'metro' => $metro,
        'districts' => $districts,
        'metros' => $metros,
        'params' => $params,
        'halls' => $halls
    ]) ?>

</div>
