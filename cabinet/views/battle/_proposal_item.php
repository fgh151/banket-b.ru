<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 30.11.2018
 * Time: 13:53
 *
 * @var $this \yii\web\View
 * @var $model \app\common\models\Proposal
 */

use app\common\components\Constants;
use app\common\models\Proposal;

$ru_month = [
    'Января',
    'Февраля',
    'Марта',
    'Апреля',
    'Майя',
    'Июня',
    'Июля',
    'Августа',
    'Сентября',
    'Октября',
    'Ноября',
    'Декабря'
];
$en_month = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-md-1">№ <?= $model->id ?></div>
            <div class="col-xs-12 col-md-1">
                <?= str_replace($en_month, $ru_month, $model->getWhen()->format('d F Y в H:i')); ?>
            </div>
            <div class="col-xs-12 col-md-1">
                <?= Proposal::typeLabels()[$model->event_type] ?>
            </div>
            <div class="col-xs-12 col-md-1">
                Сумма <?= $model->amount ?>
            </div>
            <div class="col-xs-12 col-md-1">
                Количество гостей
                <?= $model->guests_count ?>
            </div>
            <div class="col-xs-12 col-md-1">
                Танцпол <?= $model->dance ? 'да' : 'нет' ?>
            </div>
            <div class="col-xs-12 col-md-1">
                Отдельный зал <?= $model->hall ? 'да' : 'нет' ?>
            </div>
            <div class="col-xs-12 col-md-1">
                Свой алкоголь <?= $model->own_alcohol ? 'да' : 'нет' ?>
            </div>
            <div class="col-xs-12 col-md-1">
                Парковка <?= $model->parking ? 'да' : 'нет' ?>
            </div>
            <div class="col-xs-12 col-md-1">
                Заявка поступила <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
            </div>
            <div class="col-xs-12 col-md-2">

                <?php
                if (Yii::$app->getUser()->getIdentity()->state == Constants::ORGANIZATION_STATE_PAID) :
                    if ($model->status === Constants::PROPOSAL_STATUS_CREATED && $model->date >= date('Y-m-d')) :
                        echo $this->render('_controls', ['model' => $model]);
                    else:
                        echo 'Заявка закрыта, стоимость заявки ' . $model->guests_count * $model->amount . ' ₽';
                    endif;
                endif; ?>
            </div>
        </div>
    </div>
</div>
