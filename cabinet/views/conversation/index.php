<?php
/**
 * @var $this yii\web\View
 * @var $model \app\common\models\Message
 * @var $proposal \app\common\models\Proposal
 */

use app\common\components\Constants;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

\app\cabinet\assets\ConversationAsset::register($this);


$this->registerJsVar('ref', 'proposal_2/u_' . $model->user_id . '/p_' . $model->proposal_id . '/o_' . Yii::$app->getUser()->getId());
?>

    <div class="conversation">
        <div id="messages-area">
        </div>
        <?php if ($proposal->status === Constants::PROPOSAL_STATUS_CREATED): ?>

            <?php $form = ActiveForm::begin([
                'id'                   => 'message-form',
                'action'               => Url::to([
                    'conversation/send-message',
                    'proposalId' => $model->proposal_id
                ]),
                'enableAjaxValidation' => true,
                'validationUrl'        => Url::to([
                    'conversation/validate-message',
                    'proposalId' => $model->proposal_id
                ]),
            ]); ?>

            <?= $form->field($model, 'message'); ?>
            <?= $form->field($model, 'cost'); ?>


            <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>

            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>
<?php

$js = <<<JS
$(document).on("beforeSubmit", "#message-form", function () {
    
     const form = $(this);
    const formData = form.serialize();
    
    
    console.log(form.attr("action"));
    
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        success: function (data) {
            $('#messages-area').append(data.element);
             console.log(data);
            form[0].reset();
            scrollMessages(true);
        },
        error: function () {
            // alert("Something went wrong");
        }
    });
    
    return false; 
});

JS;

$this->registerJs($js);

