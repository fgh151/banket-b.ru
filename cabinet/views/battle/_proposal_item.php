<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 30.11.2018
 * Time: 13:53
 *
 * @var $this \yii\web\View
 * @var $model \app\common\models\Proposal
 * @var $key int
 * @var $index int
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
            <div class="col-xs-12 col-md-2">
                № <?= $model->id ?>
            </div>
            <div class="col-xs-12 col-md-2">
                <?= Proposal::typeLabels()[$model->event_type] ?>
                <?= str_replace($en_month, $ru_month, $model->getWhen()->format('d F Y в H:i')); ?>
            </div>

            <div class="col-xs-12 col-md-2">
                <?= $model->guests_count ?>
            </div>
            <div class="col-xs-12 col-md-2">
                Ставок
            </div>
            <div class="col-xs-12 col-md-2">
                Лучшая ставка
            </div>
            <div class="col-xs-12 col-md-2">
                <?php
                if (Yii::$app->getUser()->getIdentity()->state == Constants::ORGANIZATION_STATE_PAID) :
                    if ($model->isActual()) :
                        echo $this->render('_controls', ['model' => $model]);
                    else:
                        echo '<span style="color: #843534">Заявка не актуальная, стоимость заявки ' . $model->guests_count * $model->amount . ' ₽</span>';
                    endif;
                endif; ?>
            </div>
        </div>
    </div>
</div>
