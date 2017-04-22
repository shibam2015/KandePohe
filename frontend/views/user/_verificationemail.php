<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
    <div id="email_verification" class="mrg-tp-30 mrg-bt-10">
        <?php
        if ($model->eEmailVerifiedStatus == 'No') {
            $form = ActiveForm::begin([
                'id' => 'form',
                'action' => ['email-verification'],
                'options' => ['data-pjax' => true],
                #'layout' => 'horizontal',
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
            <div class="row">
                <div class="col-md-4">
                    <div class="form-cont">
                        <div class="form-cont">
                            <!-- <?= $form->errorSummary($model, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?> -->
                            <?= $form->field($model, 'email_pin', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Enter Email PIN number</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control'], ['maxlength' => 4]) ?>
                        </div>
                        <?php
                        if ($temp['StartTime'] > 0 && $temp['StartTime'] < Yii::$app->params['timePinValidate']) {
                            ?>
                            <div class="emailtime"><strong> Expires in : </strong><span
                                    id="timeoutemail"> <?= $temp['RemainingTime']; ?> </span></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-cont">
                        <div class="form-cont">
                            <!-- <?= Html::submitButton('Verify', ['class' => 'btn btn-primary email_verify_btn', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Verifying', 'name' => 'verify', 'value' => 'EMAIL_VERIFY']) ?> -->
                            <input type="hidden" name="verify" value="EMAIL_VERIFY">
                            <?= Html::submitButton('Verify', ['class' => 'btn btn-primary', 'name' => 'verify', 'value' => 'EMAIL_VERIFY']) ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="mrg-tp-20 mrg-bt-10">
                <span class="phone_status"></span>
                <p>Didn't get PIN? <a href="javascript:void(0)" class="email_verification"
                                      data-name="phone"> Resend PIN </a>to my email address
                    <strong><?= $model->email ?></strong>
                    <a href="javascript:void(0)" class="btn btn-default btn-xs edit_email"><span
                            class="glyphicon glyphicon-pencil"></span> Edit</a></p>
            </div>

            <?php

            if ($model->eEmailVerifiedStatus == 'No') {
                #if($temp['Time']>=0 && $temp['StartTIme'] <= Yii::$app->params['timePinValidate']){
                if ($temp['StartTime'] > 0 && $temp['StartTime'] < Yii::$app->params['timePinValidate']) {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_EXPIRED_FOR_EMAIL');
                    $this->registerJs('
                     var $worked = $("#timeoutemail");
                     function update() {
                        var myTime = $worked.html();
                        var ss = myTime.split(":");
                        var dt = new Date();
                        dt.setHours(15);
                        dt.setMinutes(ss[0]);
                        dt.setSeconds(ss[1]);
                        var dt2 = new Date(dt.valueOf() - 1000);
                        var temp = dt2.toTimeString().split(" ");
                        var ts = temp[0].split(":");
                        $worked.html(ts[1]+":"+ts[2]);
                        if(ts[1]=="00"){
                                if(ts[2]=="00"){
                                    $(".emailtime").remove();
                                    showNotification("W", "' . $MESSAGE . '");
                                }
                        }
                        if(ts[1]!="59"){
                            setTimeout(update, 1000);
                        }
                    }
                    //setTimeout(update, 1000);
                            ');
                }
                if ($flag) {
                    if ($popup) {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PIN_RESEND_FOR_EMAIL');
                    } else {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_RESEND_FOR_EMAIL');
                    }
                    $this->registerJs(' 
                    loaderStop();
                    notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
                ');
                } else {
                    if ($popup) {
                        if ($temp['Error']) {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_EXPIRED_FOR_EMAIL');
                        } else {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_INCORRECT_FOR_EMAIL');
                        }
                        $this->registerJs(' 
                    notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
                ');
                    }
                }
            }
        } else { ?>
            <div class="mrg-tp-20 mrg-bt-10">
                <span class="phone_status"></span>
                <p> Your <strong><?= $model->email ?></strong> email id is verified.
                    <a href="javascript:void(0)" class="btn btn-default btn-xs edit_email"><span
                            class="glyphicon glyphicon-pencil"></span> Edit</a></p>
            </div>
            <?php
            if ($model->eEmailVerifiedStatus == 'Yes' && $model->email_pin == '') {
                if ($popup) {
                    if ($model->eEmailVerifiedStatus == 'Yes' && $model->ePhoneVerifiedStatus == 'Yes') {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification("S", "VERIFICATION_COMPLETED");
                        $this->registerJs('
                            notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
                            setTimeout(function(){
                                $("#notification-model").modal("hide");
                                }, 4000);
                            ');
                    } else {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'EMAIL_VERIFICATION');
                        $this->registerJs('
                       notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
                       setTimeout(function(){
                          $("#notification-model").modal("hide");
                       }, 4000);

                    ');
                    }
                    if ($model->eEmailVerifiedStatus == 'Yes' && $model->ePhoneVerifiedStatus == 'Yes') {
                        $TempArray = explode(",", $model->completed_step);
                        $PartnerPre = 0;
                        if (in_array('-1', $TempArray)) {
                            $Redirect_URL = Yii::$app->homeUrl . Yii::$app->params['dashboard'];
                        } else {
                            $Redirect_URL = Yii::$app->homeUrl . Yii::$app->params['registrationPartnerPreferences'];
                        }

                        $this->registerJs('
                               $("#notification-model").on("hidden.bs.modal", function (e) {
                                        //window.location = "' . Yii::$app->homeUrl . '/dashboard?type=' . base64_encode("VERIFICATION-DONE") . '";
                                        window.location = "' . $Redirect_URL . '";
                                        //window.location = "' . Yii::$app->homeUrl . 'partner-preferences";
                               })
                        ');
                    } else if ($model->eEmailVerifiedStatus == 'Yes') {
                        $this->registerJs('
                               $("#notification-model").on("hidden.bs.modal", function (e) {
                                        window.location = "' . Yii::$app->homeUrl . Yii::$app->params['registrationPartnerPreferences'] . '";
                               })
                        ');
                    }

                }
            }
        } ?>

    </div>
<?php

$this->registerJs('
    function getInlineDetail(url,htmlId,type){
        $.ajax({
        url : url,
        type:"POST",
        data:{"type":type},
        success:function(res){
          $(htmlId).html(res);
        }
      });
    }
    $(".edit_email").click(function(e){
        getInlineDetail("' . Url::to(['user/email-id-change']) . '","#email_verification","0");
    });
    setDesign();
     $(".email_verify_btn").on("click", function() {
        var $this = $(this);
        $this.button("loading");
        setTimeout(function() {
            $this.button("reset");
        }, 8000);
    });
');

?>
<style>
    .btn-primary.disabled, .btn-primary.disabled.active, .btn-primary.disabled.focus, .btn-primary.disabled:active, .btn-primary.disabled:focus, .btn-primary.disabled:hover, .btn-primary[disabled], .btn-primary[disabled].active, .btn-primary[disabled].focus, .btn-primary[disabled]:active, .btn-primary[disabled]:focus, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary, fieldset[disabled] .btn-primary.active, fieldset[disabled] .btn-primary.focus, fieldset[disabled] .btn-primary:active, fieldset[disabled] .btn-primary:focus, fieldset[disabled] .btn-primary:hover {
        background-color: #ee1845;
        border-color: #ee1845;
    }
</style>