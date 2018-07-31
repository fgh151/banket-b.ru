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

    <div class="conversation">
        <h1>Заявка №<?= $proposal->id ?></h1>

        <?= \yii\widgets\DetailView::widget([
            'model' => $proposal,
            'attributes' => [
                'City', 'amount', 'date', 'time', 'comment',
                [
                    'attribute' => 'cuisine',
                    'value' => function ($model) {
                        return \app\common\models\Proposal::cuisineLabels()[$model->cuisine];
                    }
                ], 'guests_count'
            ]
        ]); ?>

        <div id="messages-area">

            <?= $this->render('_message_list', ['messages' => $messages]); ?>

        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'message-form',
            'action' => Url::to(['conversation/send-message', 'proposalId' => $model->proposal_id]),
            'enableAjaxValidation' => true,
            'validationUrl' => Url::to(['conversation/validate-message', 'proposalId' => $model->proposal_id]),
        ]); ?>

        <?= $form->field($model, 'message'); ?>


        <?= Html::submitButton('Отправить') ?>

        <?php ActiveForm::end(); ?>


    </div>

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

function scrollMessages(force = false) {
    
    if ($('#messages-area > div').last().offset() > 500 || force) {
    
      var scroll = $('#messages-area');
      var height = scroll[0].scrollHeight;
      scroll.scrollTop(height);
  }
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
scrollMessages(true);

JS;


$this->registerJs($js, \yii\web\View::POS_END);
