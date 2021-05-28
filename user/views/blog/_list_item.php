<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\common\models\Blog
 */

use yii\helpers\Html;

?>

<h2>
    <?= Html::a($model->title, ['blog/view', 'alias' => $model->alias]) ?>
</h2>
