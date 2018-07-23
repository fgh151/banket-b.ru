<?php
/**
 * @var $this yii\web\View
 * @var $messages \app\common\models\Message[]
 */
?>
<?php foreach ($messages as $message): ?>
    <?= $this->render('_message', ['message' => $message]); ?>
<?php endforeach; ?>
