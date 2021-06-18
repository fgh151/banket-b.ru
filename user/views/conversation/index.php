<?php
/**
 * @var $this yii\web\View
 * @var $model Cost
 * @var $proposal Proposal
 */

use app\common\components\MonthHelper;
use app\common\models\Cost;
use app\common\models\Proposal;
use app\user\assets\ConversationAsset;
use yii\helpers\Json;
use yii\helpers\Url;

ConversationAsset::register($this);
$organizationId = Yii::$app->getUser()->getId();

$this->registerJsVar('ref', 'proposal_2/u_' . $proposal->owner_id . '/p_' . $proposal->id . '/o_' . $organizationId);
$this->registerJsVar('organizationId', $organizationId);
$this->registerJsVar('phpProposal', Json::encode($proposal));
$this->registerJsVar('proposalActive', $proposal->isActual());
$this->registerJsVar('pushUrl', Url::to(['conversation/push', 'proposalId' => $proposal->id]));
$this->params['breadcrumbs'][] = ['label' => 'Все заявки', 'url' => ['battle/index']];

$this->registerJsVar('token', Yii::$app->getUser()->getIdentity()->getAuthKey())
?>

<div class="row">
    <div class="col-xs-12 proposal-info" id="chart-info">
        <div class=" dialog-element row">
            <div class="col-xs-12 col-md-2">
                <p class="proposal-item-time">
                    <?= MonthHelper::formatDateWithYear($proposal->getWhen()); ?>
                    , <?= str_replace('-', '&#8212;', $proposal->time) ?>
                </p>
                <p class="proposal-item-type">
                    <?= Proposal::typeLabels()[$proposal->event_type] ?>
                </p>
            </div>
            <div class="col-xs-12 col-md-2">
                <p>
                    <?= $proposal->guests_count ?> <?= Yii::t('app',
                        '{n, plural, one{гостя} few{гостей} other{гостей}}',
                        ['n' => $proposal->guests_count]); ?>
                </p>
                <?php if ($proposal->metroStation !== null): ?>
                    <p class="my-price-description">Желаемое метро</p>
                    <p><?= $proposal->metroStation->title ?></p>
                <?php endif; ?>
            </div>
            <div class="col-xs-12 col-md-6">
                <?php if (
                    $proposal->floristics === true ||
                    $proposal->hall === true ||
                    $proposal->photo === true ||
                    $proposal->stylists === true ||
                    $proposal->cake === true ||
                    $proposal->transport === true ||
                    $proposal->entertainment === true ||
                    $proposal->present === true ||
                    $proposal->parking === true ||
                    $proposal->private === true ||
                    $proposal->dance === true ||
                    $proposal->own_alcohol === true): ?>
                    <p class="my-price-description">Дополнительные услуги</p>
                    <div class="service-items">
                        <?php if ($proposal->floristics): ?>
                            <div class="service">
                                Флористика
                            </div>
                        <?php endif; ?>

                        <?php if ($proposal->hall): ?>
                            <div class="service">
                                Оформление зала
                            </div>
                        <?php endif; ?>

                        <?php if ($proposal->photo): ?>
                            <div class="service">
                                Фото и видео
                            </div>
                        <?php endif; ?>

                        <?php if ($proposal->stylists): ?>
                            <div class="service">
                                Стилисты
                            </div>
                        <?php endif; ?>

                        <?php if ($proposal->cake): ?>
                            <div class="service">
                                Торты
                            </div>
                        <?php endif; ?>

                        <?php if ($proposal->transport): ?>
                            <div class="service">
                                Транспорт
                            </div>
                        <?php endif; ?>

                        <?php if ($proposal->entertainment): ?>
                            <div class="service">
                                Развлекательная программа
                            </div>
                        <?php endif; ?>
                        <?php if ($proposal->present): ?>
                            <div class="service">
                                Подарки
                            </div>
                        <?php endif; ?>
                        <?php if ($proposal->parking): ?>
                            <div class="service">
                                Парковка
                            </div>
                        <?php endif; ?>
                        <?php if ($proposal->private): ?>
                            <div class="service">
                                Отдельный зал
                            </div>
                        <?php endif; ?>
                        <?php if ($proposal->dance): ?>
                            <div class="service">
                                Танцпол
                            </div>
                        <?php endif; ?>
                        <?php if ($proposal->own_alcohol): ?>
                            <div class="service">
                                Свой алкоголь
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            </div>
            <div class="col-xs-12 col-md-2">
                <p class="m-b-0">
                    <?= Yii::$app->formatter->asRubles($proposal->getMinCost() ?: $proposal->amount * $proposal->guests_count) ?>
                    Лучшая ставка
                </p>
                <p class="my-price-description">
                    <?= Yii::$app->formatter->asRubles(round($proposal->getMinCost() ? $proposal->getMinCost() / $proposal->guests_count : $proposal->amount)); ?>
                    ₽ /чел.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-xs-12 col-sm-4">
        <div id="dialogs"></div>
    </div>

    <div class="col-xs-12 col-sm-8" id="chart-aside">
        <div class="panel panel-default">
            <!--.disabled-->
            <div class="panel-heading show-mobile mobile-breadcrumbs">
                <span onclick="$('#chart-aside').toggle(); $('#chart-info').toggle();">
                    <svg width="22" height="14" viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M22 7H2" stroke="black" stroke-width="1.5"/>
<path d="M7.03656 12.0364L2 6.99988L6.96912 2.03076" stroke="black" stroke-width="1.5" stroke-linecap="square"/>
</svg>
                   &nbsp;<?= Proposal::typeLabels()[$proposal->event_type] ?> <?= MonthHelper::formatDateWithYear($proposal->getWhen()); ?>
                </span>
            </div>
            <div class="panel-heading proposal-owner clearfix">

                <div class="hidden-xs">
                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M22 44C34.1503 44 44 34.1503 44 22C44 9.84974 34.1503 0 22 0C9.84974 0 0 9.84974 0 22C0 34.1503 9.84974 44 22 44Z"
                              fill="#EEEEEE"/>
                        <path d="M22 21C24.2091 21 26 19.2091 26 17C26 14.7909 24.2091 13 22 13C19.7909 13 18 14.7909 18 17C18 19.2091 19.7909 21 22 21Z"
                              fill="black"/>
                        <path d="M30 26.1999C30.0034 25.418 29.5483 24.7066 28.837 24.3819C26.6811 23.4438 24.351 22.9728 22 22.9999C19.649 22.9728 17.3189 23.4438 15.163 24.3819C14.4517 24.7066 13.9966 25.418 14 26.1999V28.9999H30V26.1999Z"
                              fill="black"/>
                    </svg>
                </div>
                <div class="show-mobile">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 8C10.2091 8 12 6.20914 12 4C12 1.79086 10.2091 0 8 0C5.79086 0 4 1.79086 4 4C4 6.20914 5.79086 8 8 8Z"
                              fill="black"/>
                        <path d="M16 13.1999C16.0034 12.418 15.5483 11.7066 14.837 11.3819C12.6811 10.4438 10.351 9.97278 8.00002 9.99989C5.64902 9.97278 3.31892 10.4438 1.16302 11.3819C0.451701 11.7066 -0.00336782 12.418 1.87727e-05 13.1999V15.9999H16V13.1999Z"
                              fill="black"/>
                    </svg>
                </div>

                <span class="proposal-owner-name" data-id="<?= $proposal->owner_id ?>">
                    <?= $proposal->owner->name ?> <?= $proposal->owner->phone ?>
                    </span>
            </div>
            <div class="panel-body">
                <div id="dialog"></div>
            </div>
            <div class="disabled-messenger">
                <div class="vertical-wrapper">
                    <div class="vertical-content">
                        <div class="disabled-icon">
                            <?= $this->render('_chat_icon'); ?>
                        </div>
                        <div class="disabled-text p-l-30">
                            <h3>Сделайте ставку</h3>
                            <p>для начала общения с гостем</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
