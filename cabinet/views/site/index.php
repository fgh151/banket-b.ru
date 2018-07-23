<?php

use app\common\components\Constants;
use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $organization \app\common\models\Organization
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => $organization->state !== Constants::ORGANIZATION_STATE_PAID ? 'После оплаты тут будут заявки' : 'Заявок не найдено',
            'itemView' => '_proposal'
        ]) ?>
    </div>

</div>
