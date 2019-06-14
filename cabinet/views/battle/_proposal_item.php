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

use app\common\components\MonthHelper;
use app\common\models\Proposal;
use yii\helpers\Url;

?>
<a href="<?= Url::to(['conversation/index', 'proposalId' => $model->id], ['class' => 'btn btn-primary']); ?>"
   class="proposal-item row<?= !$model->isActual() ? ' closed-proposals' : '' ?>">
    <div class="col-xs-12 col-md-3 proposal-mobile-header">
        <div class="row">
            <div class="col-xs-8">
                <?= $this->render('_best_cost', ['model' => $model]); ?>
            </div>
            <div class="col-xs-4 show-mobile my-price-description">
                <?= count($model->uniqueCosts) ?> <?= Yii::t('app', '{n, plural, =0{ставок} =1{ставка} other{ставки}}', ['n' => count($model->uniqueCosts)]); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 show-mobile">
        <p class="my-price-description">
            Лучшая ставка
        </p>
        <p>
            <?php if ($model->getMinCost() === null) : ?>
                <?= Yii::$app->formatter->asRubles($model->amount); ?>
                <span class="my-price-description">
                    <?= Yii::$app->formatter->asRubles(round($model->amount / $model->guests_count)); ?> ₽ /чел.
                </span>
            <?php else: ?>
                <?= Yii::$app->formatter->asRubles($model->getMinCost()); ?>
                <span class="my-price-description">
                <?= Yii::$app->formatter->asRubles(round($model->getMinCost() / $model->guests_count)); ?> ₽ /чел.
                </span>
            <?php endif; ?>
        </p>
    </div>
    <div class="col-xs-12 col-md-3">
        <p class="proposal-item-time">
            <?= MonthHelper::formatDateWithYear($model->getWhen()); ?>, <?= str_replace('-', '&#8212;', $model->time) ?>
        </p>
        <p class="proposal-item-type">
            <?= Proposal::typeLabels()[$model->event_type] ?>
        </p>
    </div>
    <div class="col-xs-12 col-md-1 p-t-5 list-guests-count">
        <?= $model->guests_count ?>
        <span class="show-mobile">
            <?= Yii::t('app', '{n, plural, one{гостя} few{гостей} other{гостей}}', ['n' => $model->guests_count]); ?>
        </span>
    </div>
    <div class="col-xs-12 col-md-1 hidden-xs">
        <?= $model->costsCount ?>
    </div>
    <div class="col-xs-12 col-md-2 hidden-xs">
        <?php if ($model->getMinCost() === null) : ?>
            <p>
                <?= Yii::$app->formatter->asRubles($model->amount * $model->guests_count); ?>
            </p>
            <p class="my-price-description hidden-xs">
                <?= Yii::$app->formatter->asRubles(round($model->amount)); ?> ₽ /чел.
            </p>
        <?php else: ?>
            <p>
                <?= Yii::$app->formatter->asRubles($model->getMinCost()); ?>
            </p>
            <p class="my-price-description hidden-xs">
                <?= Yii::$app->formatter->asRubles(round($model->getMinCost() / $model->guests_count)); ?> ₽ /чел.
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-md-2 p-t-20 cost-column ">
        <?php if ($model->getIsRestaurantBest(Yii::$app->getUser()->getId()) === null && $model->isActual()) : ?>
            <span class="cost-btn">Сделать ставку</span>
        <?php else: ?>
            <p class="my-price hidden-xs">
                <?= Yii::$app->formatter->asRubles($model->getMyMinCost()); ?> ₽
            </p>
            <p class="my-price-description hidden-xs">
                <?= Yii::$app->formatter->asRubles(round($model->getMyMinCost() / $model->guests_count)); ?> ₽ /чел.
            </p>
            <p class="show-mobile">
                <span class="my-cost"> Ваша ставка <?= Yii::$app->formatter->asRubles($model->getMyMinCost()); ?> ₽&nbsp;</span><span
                        class="cost-btn">Изменить</span>
            </p>
        <?php endif; ?>
    </div>
</a>
