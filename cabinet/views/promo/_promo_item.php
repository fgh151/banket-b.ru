<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\api\models\Promo
 */

use yii\helpers\Html;

?>

<div class="panel panel-default">
    <div class="panel-body">

        <div class="row hidden-xs">

            <div class="col-xs-12 col-md-2">
                Текст
            </div>

            <div class="col-xs-12 col-md-2">
                Изображение
            </div>

            <div class="col-xs-12 col-md-4">
                Ссылка
            </div>

            <div class="col-xs-12 col-md-2">
                Просмотры
            </div>

            <div class="col-xs-12 col-md-2">
                Переходы
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-2">
                <?= Html::a($model->title, ['promo/update', 'id' => $model->id]); ?>
            </div>
            <div class="col-xs-12 col-md-2">
                <?= Html::img('/' . \Yii::$app->imageresize->getUrl('@app/web/' . $model->image, 200, 200), ['class' => 'img-responsive']); ?>
            </div>
            <div class="col-xs-12 col-md-4">
                <?= Html::a($model->link, $model->link); ?>
            </div>
            <div class="col-xs-12 col-md-2">
                <span class="hidden-sm hidden-md hidden-lg">Просмотры </span><?= $model->browsingCount ?>
            </div>
            <div class="col-xs-12 col-md-2">
                <span class="hidden-sm hidden-md hidden-lg">Переходы  </span><?= $model->redirectCount; ?>
            </div>
        </div>
    </div>
</div>
