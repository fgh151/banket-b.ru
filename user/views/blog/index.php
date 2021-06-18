<?php
/**
 * @var $this View
 * @var $dataProvider ActiveDataProvider
 */

use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

?>

<section class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Our Blog</h1>
                <p>You can feel free to use our template for any purpose of your websites. Thank you. Template
                    re-distribution is <strong>not allowed</strong> in any download site.</p>
            </div>
        </div>
    </div>
</section>

<section class="blog-page">
    <div class="container">
        <?= ListView::widget([
            'layout' => "{items}<div class=\"col-md-8 col-md-offset-2\">{pager}</div>",
            'dataProvider' => $dataProvider,
            'itemView' => '_list_item',
            'options' => ['class' => 'row list-view'],
            'itemOptions' => ['class' => 'col-md-8 col-md-offset-2'],
            'pager' => [
                'options' => ['class' => 'page-number']
            ]
        ]); ?>
    </div>
</section>
