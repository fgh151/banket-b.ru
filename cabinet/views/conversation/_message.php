<?php
/**
 * @var $this yii\web\View
 * @var $message \app\common\models\Message
 */

$isUserMessage = $message->author_class == \app\common\models\MobileUser::class;
?>
<div class="row">
    <div class="message <?= $isUserMessage ? 'user-message' : 'organization-message' ?>"
         data-id="<?= $message->created_at ?>">
    <p><?= $message->message ?></p>
</div>
</div>
