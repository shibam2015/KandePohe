<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
    <div id="phone_verification">
        <?php
        if ($model->ePhoneVerifiedStatus == 'No') {
            $form = ActiveForm::begin([
                'id' => 'form',
                'action' =>     ['phone-verification'],
                'options' => ['data-pjax' => true],
                #'layout' => 'horizontal',
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
            <div class="row">
                <div class="col-md-4">
                    <div class="form-cont">
                        <div class="form-cont">
                            <!-- <?= $form->errorSummary($model, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?> -->
                            <?= $form->field($model, 'phone_pin', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Enter Mobile PIN number</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control'], ['maxlength' => 4]) ?>
                        </div>
                        <?php
                        #echo "<br> 1nd => ".$temp['StartTime']."<br> 3rd => ".Yii::$app->params['timePinValidate'];
                        if($temp['StartTime']>0 && $temp['StartTime'] < Yii::$app->params['timePinValidate']){
                            ?>
                            <div class="phonetime"><strong> Expires in : </strong><span
                                    id="timeoutphone"> <?= $temp['RemainingTime']; ?> </span></div>
                        <?php }?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-cont">
                        <div class="form-cont">
                            <?= Html::submitButton('Verify', ['class' => 'btn btn-primary', 'name' => 'verify', 'value' => 'PHONE_VERIFY']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 ">
                    <div class="form-cont">
                        <div class="form-cont">

                        </div>
                    </div>
                </div>

            </div>
            <?php ActiveForm::end(); ?>
            <div class="mrg-tp-20 mrg-bt-10">
                <span class="phone_status"></span>
                <p>Didn't get PIN? <a href="javascript:void(0)" class="phone_verification"
                                      data-name="phone"> Resend PIN </a>to my mobile number
                    <strong><?= $model->DisplayMobile ?></strong>
                    <a href="javascript:void(0)" class="btn btn-default btn-xs edit_phone"><span
                            class="glyphicon glyphicon-pencil"></span> Edit</a></p>
            </div>
            <?php
            if ($model->ePhoneVerifiedStatus == 'No') {
                #if($temp['Time']>=0 && $temp['StartTIme'] <= Yii::$app->params['timePinValidate']){
                if($temp['StartTime']>0 && $temp['StartTime'] < Yii::$app->params['timePinValidate']){
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_EXPIRED_FOR_PHONE');
                    $this->registerJs('
                     var $worked = $("#timeoutphone");
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
                                    $(".phonetime").remove();
                                    showNotification("W", "'.$MESSAGE.'");
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
                        if ($temp['Status'] == 'S') {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PIN_RESEND_FOR_PHONE');
                        } else {
                            $STATUS = $temp['Status'];
                            $MESSAGE = $temp['Message'];
                            $TITLE = Yii::$app->params['titleInformation'] ;
                        }
                    } else {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_RESEND_FOR_PHONE');
                    }
                    $this->registerJs('
                     loaderStop();
                    notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
                ');
                } else {
                    if ($popup) {
                        if($temp['Error']){
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_EXPIRED_FOR_PHONE');
                        }else{
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_INCORRECT_FOR_PHONE');
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
                <p> Your <strong><?= $model->DisplayMobile ?></strong> mobile number is verified.
                    <a href="javascript:void(0)" class="btn btn-default btn-xs edit_phone"><span
                            class="glyphicon glyphicon-pencil"></span> Edit</a></p>
            </div>
            <?php
            if ($model->ePhoneVerifiedStatus == 'Yes' && $model->phone_pin == '') {
                if ($popup) {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PHONE_VERIFICATION');
                    $this->registerJs(' 
                       notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
                       setTimeout(function(){ 
                           $(".modal").modal("hide");                                      
                       }, 4000);
                        
                    ');

                    if ($model->eEmailVerifiedStatus == 'Yes' && $model->ePhoneVerifiedStatus == 'Yes') {
                        $this->registerJs(' 
                               $(".modal").on("hidden.bs.modal", function (e) {
                                        window.location = "' . Yii::$app->homeUrl . 'user/dashboard?type=' . base64_encode("VERIFICATION-DONE") . '";                         
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
    $(".edit_phone").click(function(e){
        getInlineDetail("' . Url::to(['user/phone-number-change']) . '","#phone_verification","0");
    });
    setDesign();
');
?>
