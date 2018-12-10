<?php
/**
 * @var $this yii\web\View
 * @var $message \app\common\models\Message
 */

$isUserMessage = $message->author_class == \app\common\models\MobileUser::class;


?>
<div class="row" data-id="<?= $message->created_at ?>">
    <div class="message <?= $isUserMessage ? 'user-message' : 'organization-message' ?>">

        <p><?= \app\common\components\Formatter::make_links_clickable($message->message) ?></p>
</div>
</div>
