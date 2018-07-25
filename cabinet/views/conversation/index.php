<?php
/**
 * @var $this yii\web\View
 * @var $model \app\common\models\Message
 * @var $messages \app\common\models\Message[]
 * @var $proposal \app\common\models\Proposal
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

    <div class="row" id="messages-area">

        <?= $this->render('_message_list', ['messages' => $messages]); ?>

    </div>

<?php $form = ActiveForm::begin([
    'id' => 'message-form',
    'action' => Url::to(['conversation/send-message', 'proposalId' => $model->proposal_id]),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['conversation/validate-message', 'proposalId' => $model->proposal_id]),
]); ?>

<?= $form->field($model, 'message'); ?>


<?= Html::submitButton('send') ?>

<?php ActiveForm::end(); ?>

<?php

$js = <<<JS
$(document).on("beforeSubmit", "#message-form", function () {
    
     var form = $(this);
    var formData = form.serialize();
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        success: function (data) {
            $('#messages-area').append(data.element);
             console.log(data);
            form[0].reset();
        },
        error: function () {
            alert("Something went wrong");
        }
    });
    
    return false; 
});

JS;

$this->registerJs($js);

$newMessagesUrl = Url::to(['conversation/new-messages']);
$proposalId = $proposal->id;
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();
$js = <<<JS

function scrollMessages() {
  var scroll = $('#messages-area');
  var height = scroll[0].scrollHeight;
  scroll.scrollTop(height);
}

function getNewMessages() {
    
    var lastMessage = $('#messages-area>div').last().data('id');
  $.ajax({
        url: '$newMessagesUrl',
        type: 'post',
        data: {proposalId: '$proposalId', lastMessage: lastMessage, '$csrfParam': '$csrfToken'},
        success: function (data) {
            $('#messages-area').append(data);
            scrollMessages();
        },
        error: function () {
            alert("Something went wrong");
        }
    });
}

setInterval(getNewMessages, 10000);
scrollMessages();

JS;


$this->registerJs($js, \yii\web\View::POS_END);
