<?php
/**
 * @var $this yii\web\View
 * @var $messages \app\common\models\Message[]
 */
?>
<?php if (!empty($messages)) : ?>
<?php foreach ($messages as $message): ?>
        <?= $this->render('_message', ['message' => $message]); ?>
<?php endforeach; ?>
<?php endif; ?>
