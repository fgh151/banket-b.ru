<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\common\models\Proposal
 */
$isBest = $model->getIsRestaurantBest(Yii::$app->getUser()->getId());
?>
<p>
    <?php if ($isBest === null) : ?>
        <span class="waiting-cost cost-description">Ожидает Ставки</span>
    <?php elseif ($isBest === true): ?>
        <span class="best-cost cost-description">Лучшая ставка</span>
    <? else: ?>
        <span class="not-best-cost cost-description">Есть ставка лучше</span>
    <? endif; ?>
</p>
<p class="proposal-id hidden-xs">
    # <?= $model->id ?>
</p>
