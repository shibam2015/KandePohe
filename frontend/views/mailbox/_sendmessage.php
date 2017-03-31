<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

$modelInbox = $model['modelInbox'];
$ToUserId = $model['ToUserId'];
$model = $model['model'];
?>
<div class="send_message">
    <?php
    if (!$show) {
        $form = ActiveForm::begin([
            'id' => 'form',
            'action' => ['inbox-send-message'],
            'options' => ['data-pjax' => true],
            'validateOnChange' => false,
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
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center">Send <?= $model->FullName; ?>(<?= $model->Registration_Number; ?>) a
                    Personalised Message</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9 col-sm-8">
                        <!--  <?= $form->errorSummary($modelInbox, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9 col-sm-8">
                        <div class="form-group">
                            <!--<label for="msg" class="mrg-bt-10">Enter your message</label>-->
                            <?= $form->field($modelInbox, 'MailContent')->textArea(['rows' => '5', 'cols' => '50', 'class' => "form-control msg-b", 'id' => 'msg', 'placeholder' => 'Type Message Here...'])->label(true)->error(false) ?>
                            <!--<textarea class="form-control msg-b" rows="4" id="msg" name="message"
                                      placeholder="Type message here..."></textarea>-->
                        </div>
                        <input type="hidden" name="User[ToUserId]" value="<?= $ToUserId ?>">
                        <!--<div class="checkbox mrg-tp-0">
                            <input id="save" type="checkbox" name="Photo" value="check1">
                            <label for="save" class="control-label font-15">Save this as your default message for future
                                communications.</label>
                        </div>-->
                    </div>

                    <div class="col-md-3 col-sm-4 mrg-tp-20">
                        <?= Html::img(CommonHelper::getPhotos('USER', $model->id, "75" . $model->propic, 120, '', 'Yes', CommonHelper::getVisiblePhoto($model->id, $model->eStatusPhotoModify)), ['width' => '', 'height' => '120', 'alt' => 'Profile Pic', 'class' => '']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4  col-md-4 col-md-offset-1">
                        <?= Html::submitButton('Send message', ['class' => 'btn btn-primary SEND_MESSAGE_USER', 'name' => 'Action', 'value' => 'SEND_MESSAGE']) ?>
                    </div>
                    <div class="col-sm-4  col-md-4 ">
                        <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_horoscope', 'name' => 'cancel', "data-dismiss" => "modal"]) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();
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
        ?>
        <!--<div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center">Please Wait...</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mrg-tp-20">
                        Loading Information...
                    </div>
                </div>
            </div>
        </div>-->

    <?php
    }
    ?>
</div>