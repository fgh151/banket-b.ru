<?php

use app\common\components\Constants;
use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $organization \app\common\models\Organization
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = 'Аукционы';
?>
<div class="site-index">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <h1>Аукционы</h1>
                </div>
                <div class="col-xs-12 col-md-6">

                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'emptyText' => $organization->state !== Constants::ORGANIZATION_STATE_PAID ? 'После оплаты тут будут заявки' : 'Заявок не найдено',
                        'itemView' => '_proposal'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
