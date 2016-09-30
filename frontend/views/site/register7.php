<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
#use frontend\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\CommonHelper;
$HOME_PAGE_URL = Yii::getAlias('@web')."/";
$UPLOAD_DIR = Yii::getAlias('@frontend') .'/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') .'/web/';
?>
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- Fonts CSS -->
<!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> -->
<link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600' rel='stylesheet' type='text/css'>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Custom styles for this template -->
<!-- <link rel="stylesheet" type="text/css" href="css/cs-select.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="css/cs-skin-border.css" /> -->
<!-- <link href="css/style.css" rel="stylesheet"> -->
<!-- <link href="css/style-responsive.css" rel="stylesheet"> -->
<header role="header">
    <!-- over-header -->
    <div class="over-header">
        <div class="header-inner">
            <div class="container">
                <div class="row">
                    <div class="col-xs-8">
                        <div class="logo"><a href="<?= $HOME_PAGE_URL ?>"
                                             title="logo"> <?= Html::img('@web/images/logo-inner.png', ['width' => '202', 'height' => 83, 'alt' => 'logo']); ?>  </a>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="help pull-right"><a href="#"
                                                        title="Help"> <?= Html::img('@web/images/help.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?>
                                <!--<img src="images/help.jpg" width="21" height="21" alt="help" title="Help">--> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<main>
    <div class="main-section">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-section">

                            <!--  'action' => 'javascript:void(0)', -->
                            <h3>Verify mobile and email <span class="font-light">(Verify your mobile number and email to unhide your profile)</span>
                            </h3>
                            <div class="mrg-tp-10 mrg-bt-10">
                                <p>We have sent a 4 digit PIN to your given <strong>mobile number</strong> via SMS/Text
                                    message</p>
                            </div>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'form-register8',
                                'action' => 'javascript:void(0)',
                                #'action' => ['/site/change-mobile-number'],
                                /*'enableAjaxValidation' => true,
                                'enableClientValidation'=> true,
                                'method'=>'post',*/
                            ]);
                            ?>
                            <div class="row">
                                <div class="col-sm-4 col-xs-6">
                                    <div class="form-cont">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'phone_pin', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Enter Mobile PIN number</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control'], ['maxlength' => 4]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <!-- <input type="button" name="Verify" value="Verify" class="btn btn-primary">-->
                                    <!--<a href="javascript:void(0)" name="Verify" class="btn btn-primary do_phone_verification">Verify</a>-->
                                    <?= Html::Button('Verify', ['class' => 'btn btn-primary do_phone_verification', 'name' => 'register8']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                            <div class="mrg-tp-20 mrg-bt-10">
                                <span class="phone_status"></span>
                                <p>Didn't get PIN? <a href="javascript:void(0)" class="phone_verification"
                                                      data-name="phone"> Resend PIN </a>to my mobile number
                                    <strong><?= $model->Mobile ?></strong>
                                    <a href="javascript:void(0)"
                                       data-target="#modelmobilenumber"
                                       data-toggle="modal" class="btn btn-default btn-xs"><span
                                            class="glyphicon glyphicon-pencil"></span> Edit</a></p>
                            </div>

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
<div class="modal fade" id="modelmobilenumber" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo"></p>
        </p>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <h2 class="text-center">Change Mobile Number</h2>
            </div>
            <!-- Modal Body -->
            <?php
            $form = ActiveForm::begin([
                'id' => 'form-register9',
                #'action' => 'javascript:void(0)',
                #'action' => ['/site/change-mobile-number'],
                'validateOnChange' => false,

            ]);
            ?>
            <div class="modal-body ">
                <div class="row">
                    <div class="form-cont col-xs-6">
                        <?= $form->field($model, 'county_code')->dropDownList(
                            ['+91' => '+91'],
                            ['class' => 'cs-select cs-skin-border', 'prompt' => 'Country Code']
                        )->label(false); ?>
                    </div>
                    <div class="form-cont col-xs-6">
                        <?= $form->field($model, 'Mobile', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Mobile No#</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control']) ?>
                    </div>
                </div>
                <p></p><br>
                <p>
                    <button class="btn btn-primary delete_account">Yes</button>
                    <?= Html::Button('Sign up free', ['class' => 'btn btn-primary mrg-tp-10', 'name' => 'signup-button', 'id' => 'btnSignup']) ?>
                    <button class="btn btn-primary" data-dismiss="modal">cancel</button>
                </p>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- Modal Footer -->
    </div>
</div>


<?php # PHONE PIN
$this->registerJs("
$(document).ready(function()
{  
    $('.phone_verification').click(function(){ 
            Pace.restart();
            var formDataPhoto = new FormData();
            //formDataPhoto.append( 'ACTION', 'RESEND-PHONE-PIN');
            $.ajax({
                        url: 'resend-phone-pin',
                        type: 'POST',
                        data: formDataPhoto,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            var DataObject = JSON.parse(data);
                            if (DataObject.STATUS == 'SUCCESS') {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                            } else {
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
                
    $('.do_phone_verification').click(function(){ 
            Pace.restart();
            var formDataPhone = new FormData($('#form-register8'));
            var phone_pin = $('#phone_pin').val();
            formDataPhone.append( 'PHONE_PIN', $('#user-phone_pin').val());
            $.ajax({
                        url: 'verification-phone-pin',
                        type: 'POST',
                        data: formDataPhone,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            var DataObject = JSON.parse(data);
                            if (DataObject.STATUS == 'SUCCESS') {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                                $('#user-phone_pin').val('');
                                $('.input--akira').removeClass('input--filled');
                            } else {
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
                            } else {
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
                            } else {
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

