<?php
# NEW
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
#use frontend\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\CommonHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

$HOME_PAGE_URL = Yii::getAlias('@web') . "/";
$UPLOAD_DIR = Yii::getAlias('@frontend') . '/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') . '/web/';
?>
<?php
echo $this->render('/layouts/parts/_headerregister.php');
?>
<main>
    <div class="main-section">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-section">
                            <h3>Verify mobile and email <span class="font-light">(Verify your mobile number and email to unhide your profile)</span>
                            </h3>
                            <?php Pjax::begin(['id' => 'my_index_phone', 'enablePushState' => false]); ?>
                            <div id="phone_verification">
                                Phone Verification Information Loading...
                            </div>
                            <?php Pjax::end(); ?>
                            <p class="font20 mrg-tp-30"><strong>OR</strong></p>
                            <div class="mrg-tp-30 mrg-bt-10">
                                <p>We have sent a 4 digit PIN to your given <strong>email address</strong></p>
                            </div>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'form-register7',
                                'action' => 'javascript:void(0)',
                            ]);
                            ?>
                            <!--<form class="mrg-tp-30" method="post">-->
                            <div class="row">
                                <div class="col-sm-4 col-xs-6">
                                    <div class="form-cont">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'email_pin', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Enter Email PIN number</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control'], ['maxlength' => 4]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <!--<input type="submit" value="Verify" name="Verify" class="btn btn-primary">-->
                                    <!-- <?= Html::submitButton('Verify', ['class' => 'btn btn-primary ', 'name' => 'register7']) ?>-->
                                    <?= Html::Button('Verify', ['class' => 'btn btn-primary do_email_verification', 'name' => 'register7']) ?>
                                    <!--<input type="button" name="Verify" value="Verify" class="btn btn-primary" onclick="window.location.href='index.php?r=site%2Fdashboard'">-->
                                </div>
                            </div>
                            <div class="mrg-tp-10 mrg-bt-10">
                                <?php if ($model->email_verification_msg != '') { ?><span
                                    class="<?= $model->error_class ?>"> <?= $model->email_verification_msg ?></span> <?php } ?>
                                <p>Didn't get PIN? <a href="javascript:void(0)" class="email_verification"
                                                      data-name="email"> Resend PIN </a>to my email address
                                    <strong><?= $model->email ?></strong>
                                    <a href="#" class="btn btn-default btn-xs"><span
                                            class="glyphicon glyphicon-pencil"></span> Edit</a></p>

                            </div>
                            <!--</form>-->
                            <?php ActiveForm::end(); ?>

                            <div class="mrg-tp-30 mrg-bt-10">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="phone-privacy">
                                            Phone Privacy
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="glyphicon glyphicon-globe"></span> <span
                                                    class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#"><span class="glyphicon glyphicon-globe"></span> <strong>Public</strong><br>
                                                        <span class="sub-title">Anyone</span></a></li>
                                                <li><a href="#"><span class="glyphicon glyphicon-certificate"></span>
                                                        <strong>Members</strong><br> <span class="sub-title">Only Premium Members</span></a>
                                                </li>
                                                <li><a href="#"><span class="glyphicon glyphicon-user"></span> <strong>Only
                                                            Me</strong><br> <span class="sub-title">Only Me</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="privacy-promo">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="promo">
                                            <figure>
                                                <?= Html::img('@web/images/icon1.jpg', ['width' => '51', 'height' => '65', 'alt' => 'Phone Privacy']); ?>
                                            </figure>
                                            <figcaption>
                                                <h4>100% Phone Privacy</h4>
                                                <p>Options Available </p>
                                            </figcaption>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="promo">
                                            <figure>
                                                <?= Html::img('@web/images/icon2.jpg', ['width' => '53', 'height' => '65', 'alt' => 'Phone Control']); ?>
                                            </figure>
                                            <figcaption>
                                                <h4>Privacy Control</h4>
                                                <p>You can control the viewership of your number </p>
                                            </figcaption>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="promo">
                                            <figure>
                                                <?= Html::img('@web/images/icon3.jpg', ['width' => '46', 'height' => '67', 'alt' => 'Sharing']); ?>
                                            </figure>
                                            <figcaption>
                                                <h4>Sharing</h4>
                                                <p>You can control the privacy of your number </p>
                                            </figcaption>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<?php
#Phone Pin
$this->registerJs('
    function getInlineDetail(url,htmlId,type){
                Pace.restart();
        $.ajax({
        url : url,
        type:"POST",
        data:{"type":type},
        success:function(res){          
          $(htmlId).html(res);
        }
      });
    }
    getInlineDetail("' . Url::to(['user/phone-verification']) . '","#phone_verification","1");
    $(document).on("click","#cancel_change_phone",function(e){
                Pace.restart();
        getInlineDetail("' . Url::to(['user/phone-verification']) . '","#phone_verification","1");
    });
    $(document).on("click",".phone_verification",function(e){
                Pace.restart();
        getInlineDetail("' . Url::to(['user/phone-pin-resend']) . '","#phone_verification","10");
    });    
    
');
?>
<?php # EMAIL PIN
$this->registerJs("
$(document).ready(function()
{  
    $('.email_verification').click(function(){
            Pace.restart();
            var formDataPhoto = new FormData();
            $.ajax({
                        url: 'resend-email-pin',
                        type: 'POST',
                        data: formDataPhoto,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            var DataObject = JSON.parse(data);
                            if (DataObject.STATUS == 'SUCCESS') {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                                
                            } else if (DataObject.STATUS == 'ERROR') {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                            }
                            setTimeout(function(){ 
                                      $('.modal').modal('hide');                                      
                                }, 4000);               
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            notificationPopup('ERROR', 'Request Failed');
                        }
            });
    })
              
    $('.do_email_verification').click(function(){ 
            Pace.restart();
            var formDataPhone = new FormData();
            var email_pin = $('#email_pin').val();
            formDataPhone.append( 'EMAIL_PIN', $('#user-email_pin').val());
            $.ajax({
                        url: 'verification-email-pin',
                        type: 'POST',
                        data: formDataPhone,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            var DataObject = JSON.parse(data);
                            if (DataObject.STATUS == 'SUCCESS') {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                                $('#user-email_pin').val('');
                                $('.input--akira').removeClass('input--filled');
                                                                
                                /*if(DataObject.REDIRECT){
                                    $(location).attr('href', 'user/dashboard')
                                }*/
                            } else if (DataObject.STATUS == 'ERROR') {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                            }
                            setTimeout(function(){ 
                                      $('.modal').modal('hide');                                      
                                }, 4000);               
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            notificationPopup('ERROR', 'Request Failed');
                        }
            });
    })
});
     ");
?>

