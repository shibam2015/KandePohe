<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

$otherUserMails = $model['otherUserMails'];
$modelInbox = $model['modelInbox'];
$ToUserId = $model['ToUserId'];
$model = $model['model'];
?>
<div class="new_mail_compose">
    <?php
    if (count($UserEmail) == 0) { ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center">New Mail</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-8">
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="notice kp_info"><p>There are no any contact in your list.</p></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php } else {
        if (!$show) {
            $form = ActiveForm::begin([
                'id' => 'form_mail_compose',
                'action' => ['new-mail-compose'],
                'options' => ['data-pjax' => true],
                'validateOnChange' => true,
                'validateOnSubmit' => true,
                'fieldConfig' => [
                    'template' => "{label}{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-3 col-xs-3',
                        'offset' => '',
                        'wrapper' => 'col-sm-8 col-xs-8',
                        'error' => '',
                        'hint' => '',
                    ]
                ]
            ]);
            ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span></button>
                    <h2 class="text-center">New Mail</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-8">
                            <!-- <?= $form->errorSummary($modelInbox, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-8">
                            <div class="form-group">
                                <!--<label for="msg" class="mrg-bt-10">Mail To</label>-->
                                <?= $form->field($modelInbox, 'to_user_id')->dropDownList(
                                    ArrayHelper::map($otherUserMails, 'id', 'fullName'),
                                    ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Mail to']
                                ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-8">
                            <div class="form-group">
                                <!--<label for="msg" class="mrg-bt-10">Enter your message</label>-->
                                <?= $form->field($modelInbox, 'MailContent')->textArea(['rows' => '5', 'cols' => '50', 'class' => "form-control msg-b", 'id' => 'msg', 'placeholder' => 'Type Message Here...'])->label(true)->error(false) ?>
                                <!--<textarea class="form-control msg-b" rows="4" id="msg" name="message"
                                          placeholder="Type message here..."></textarea>-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4  col-md-4 col-md-offset-1">
                            <?= Html::submitButton('Send message', ['class' => 'btn btn-primary ', 'name' => 'Action', 'value' => 'NEW_MAIL_COMPOSE']) ?>
                        </div>
                        <div class="col-sm-4  col-md-4 ">
                            <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => '', 'name' => 'cancel', "data-dismiss" => "modal"]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end();
            $this->registerJs('
          selectboxClassWise("clspreferences");
         ');
        } else {
            if ($popup) {
                if ($flag) {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'SEND_MESSAGE');
                } else {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'SEND_MESSAGE');
                }
                $this->registerJs('
             $(window).trigger("hashchange");
             showNotification("' . $STATUS . '", "' . $MESSAGE . '" );
                setTimeout(function () {
                    location.reload();
                },1500);
            ');
            }
        }
    }

    ?>
</div>