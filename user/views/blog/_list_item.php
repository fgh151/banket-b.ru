<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\common\models\Blog
 */

use yii\helpers\Html;

?>

<div class="blog-item">
    <img src="<?= $model->getImagePath() ?>" alt="<?= $model->title ?>">
    <div class="date">
        <?= Yii::$app->getFormatter()->asDate($model->created_at); ?>
    </div>
    <div class="down-content">
        <h4><?= $model->title ?></h4>
        <?= $model->preview_text ?>
        <div class="text-button">
            <?= Html::a('Далее', ['/blog/view', 'alias' => $model->alias]); ?>
        </div>
    </div>
</div>
