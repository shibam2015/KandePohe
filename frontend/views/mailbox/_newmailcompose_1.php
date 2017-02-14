<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;

#CommonHelper::pr($model);
$otherUserMails = $model['otherUserMails'];
?>
<?php
if (!$show) {
    $form = ActiveForm::begin([
        'id' => 'newmail',
        'action' => ['new-mail-compose'],
        'options' => ['data-pjax' => true],
        'validateOnChange' => false,
        'validateOnSubmit' => true,
        'fieldConfig' => [
            'template' => "{label}{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
            'horizontalCssClasses' => [
                #'label' => 'col-sm-3 col-xs-3',
                'offset' => '',
                @'wrapper' => 'col-sm-8 col-xs-8',
                'error' => '',
                'hint' => '',
            ]
        ]
    ]);
    ?>
    <div class="new_mail_compose">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center">New Mail</h2>
            </div>
            <div class="modal-body">
                <?php if (count($otherUserMails) > 0) { ?>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group field-mailbox-to_user_id">
                                <!--<label class="control-label col-sm-3 col-xs-3" for="mailbox-to_user_id">Mail To</label>-->
                                <div class="col-md-12 col-sm-8 col-xs-8">
                                    <select id="select-to_user_id" class="demo-default select-beast clspreferences"
                                            placeholder="Mail To" name="Mailbox[to_user_id]" size="4">
                                        <?php
                                        foreach ($otherUserMails as $K => $V) { ?>
                                            <option
                                                value="<?= $V->id ?>"><?= $V->FullName ?> <?= "(" . $V->Registration_Number . ")" ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group field-mailbox-to_user_id">
                                <!--<label class="control-label col-sm-3 col-xs-3" for="mailbox-to_user_id">Message</label>-->
                                <div class="col-md-12 col-sm-8 col-xs-8">
                                    <div class="box">
                                        <div class="mid-col maxwd100">
                                            <div class="form-cont">
                					<span class="input input--akira input--filled input-textarea mrg-tp-10"
                                          data-ng-init="multiple_profile_reason=''">
                                            <textarea class="input__field input__field--akira col-md-12" cols="50"
                                                      data-ng-model="multiple_profile_reason"
                                                      rows="5" name="User[multiple_profile_reason]"
                                                      id="multiple_profile_reason"
                                                      placeholder="<?= Yii::$app->params['customMessageTest'] ?>"></textarea>
                                                  <label class="input__label input__label--akira" for="input-22">
                                                     <span class="input__label-content input__label-content--akira">
                                                     </span>
                                                  </label>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mrg-tp-20">
                        <div class="col-md-4 col-md-offset-2">
                            <div class="form-cont">
                                <input type="hidden" name="save" value="1">
                                <?= Html::submitButton('Send message', ['class' => 'btn btn-primary ', 'name' => 'Action', 'value' => 'CUSTOM_MAIL']) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-cont">
                                <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => '', 'name' => 'cancel', "data-dismiss" => "modal"]) ?>
                            </div>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="row">
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="notice kp_warning"><p>
                                        <strong><?= Yii::$app->params['customMailNoUserList'] ?></strong></p></div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end();

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
    ?>

<?php
}
?>