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
echo " ==== " . $show;
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
                        <?= $form->errorSummary($modelInbox, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9 col-sm-8">
                        <div class="form-group">
                            <label for="msg">Enter your message</label>
                            <?= $form->field($modelInbox, 'MailContent')->textArea(['rows' => '5', 'cols' => '50', 'class' => "form-control msg-b", 'id' => 'msg', 'placeholder' => 'Type Message Here...'])->label(false)->error(false) ?>
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
                    <div class="col-md-3 col-sm-4">
                        <?= Html::img(CommonHelper::getPhotos('USER', $model->id, $model->propic, 140), ['width' => '', 'height' => '120', 'alt' => 'Profile', 'class' => '']); ?>

                    </div>
                </div>
                <p>
                    <?= Html::submitButton('Send message', ['class' => 'btn btn-primary', 'name' => 'Action', 'value' => 'SEND_MESSAGE']) ?>
                    <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_horoscope', 'name' => 'cancel', "data-dismiss" => "modal"]) ?>
                    <!--<button class="btn btn-primary">Send message</button>
                    <button class="btn btn-primary" data-dismiss="modal">cancel</button>-->
                </p>
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
            notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
            ');
        }

        ?>
        <div class="modal-content">
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
        </div>

    <?php
    }
    ?>
</div>