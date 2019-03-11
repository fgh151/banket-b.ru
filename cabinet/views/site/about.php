<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Банкетный баттл';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/landing.css');
?>

<div class="row" style="margin-top: 50px">
    <div class="col-xs-12 col-md-6">
        <img src="/img/phone-mockup.png">
    </div>
    <div class="col-xs-12 col-md-6">



        <div class="row">
            <div class="col-xs-12">
                <h1>Банкетный Баттл</h1>
                <?php /*<p>Банкетный Баттл - уникальное решение при выборе ресторана для проведения Вашего мероприятия.</p>

                <p>Теперь именно Вы устанавливаете справедливую цену на банкет.</p>

                <p>Мучительный выбор площадки, бесконечные звонки, переплата комиссионных посредникам и т.д. в прошлом.</p>

                <p>Все что Вам нужно сделать:</p>
                <ul>
                    <li>Разместить заявку на свой банкет.</li>
                    <li> Заниматься своими делами и следить за тем как рестораны предлагают Вам лучшие условия.</li>
                    <li>Остановить аукцион, когда будете окончательно уверены в своем выборе.</li>
                </ul> */ ?>

            </div>
            <div class="col-xs-12 col-md-6 text-center">
                <?= Html::a('Регистрация для ресторатора', ['signup'], ['class' => 'btn btn-lg btn-success']) ?>
            </div>
            <div class="col-xs-12 col-md-6 text-center">
                <?= Html::a('Вход для ресторатора', ['login'], ['class' => 'btn btn-lg btn-success']) ?>
            </div>
            <!--            <div class="col-xs-12"><p> Загрузить приложение:</p></div>-->
            <?php /*<div class="col-xs-6">

                <img src="/img/ru_google-play.png" class="img-responsive" style="height: 60px">
            </div>
            <div class="col-xs-6">

                <img src="/img/ru_apple-store.svg" class="img-responsive" style="height: 60px">
            </div> */ ?>
        </div>


    </div>
</div>