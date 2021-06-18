<?php
/**
 * @var $this View
 * @var $model Blog
 */

use app\common\models\Blog;
use yii\helpers\Html;
use yii\web\View;

$this->title = $model->seo_title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->seo_description
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->seo_keywords
]);
?>

<section class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?= $model->title ?></h1>
            </div>
        </div>
    </div>
</section>

<section class="blog-page">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="blog-item">
                    <img src="<?= $model->getImagePath() ?>" alt="<?= $model->title ?>">
                    <div class="date">
                        <?= Yii::$app->getFormatter()->asDate($model->created_at); ?>
                    </div>
                    <div class="down-content">
                        <?= $model->content ?>
                        <div class="text-button">
                            <?= Html::a('Назад', ['/blog/index']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
