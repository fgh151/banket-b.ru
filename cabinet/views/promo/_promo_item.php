<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\api\models\Promo
 */

use yii\helpers\Html;

?>

<a href="<?= \yii\helpers\Url::to(['promo/update', 'id' => $model->id]) ?>" class="proposal-item">
    <div class="row">
        <div class="col-xs-12 col-md-2">
            <?= $model->title ?>
        </div>
        <div class="col-xs-12 col-md-2">
            <?= Html::img('/' . \Yii::$app->imageresize->getUrl('@app/web/' . $model->image, 200, 200), ['class' => 'img-responsive']); ?>
        </div>
        <div class="col-xs-12 col-md-4">
            <?= $model->link ?>
        </div>
        <div class="col-xs-12 col-md-2">
            <span class="hidden-sm hidden-md hidden-lg">Просмотры </span><?= $model->browsingCount ?>
        </div>
        <div class="col-xs-12 col-md-2">
            <span class="hidden-sm hidden-md hidden-lg">Переходы  </span><?= $model->redirectCount; ?>
        </div>
    </div>
</a>