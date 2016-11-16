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
                            <h3>Verify mobile and email <span class="font-light">(Verify your mobile number and email address to activate your profile.)</span>
                                <a href="<?= Yii::$app->homeUrl ?>user/dashboard" class="pull-right"><span
                                        class="link_small">( I will do this later )</span> </a>
                            </h3>
                            <?php Pjax::begin(['id' => 'my_index_phone', 'enablePushState' => false]); ?>
                            <div id="phone_verification">
                                Phone Verification Information Loading...
                            </div>
                            <?php Pjax::end(); ?>
                            <p class="font20 mrg-tp-30"><strong>OR</strong></p>
                            <?php Pjax::begin(['id' => 'my_index_email', 'enablePushState' => false]); ?>
                            <div class="mrg-tp-30 mrg-bt-10" id="email_verification">
                                Email Verification Information Loading...
                            </div>
                            <?php Pjax::end(); ?>
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
#Phone PIN & Email PIN
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
                loaderStart();
        getInlineDetail("' . Url::to(['user/phone-pin-resend']) . '","#phone_verification","10");
    });    
    
    getInlineDetail("' . Url::to(['user/email-verification']) . '","#email_verification","1");
    $(document).on("click","#cancel_change_email",function(e){
                Pace.restart();
        getInlineDetail("' . Url::to(['user/email-verification']) . '","#email_verification","1");
    });
    $(document).on("click",".email_verification",function(e){
        Pace.restart();
        loaderStart();
        getInlineDetail("' . Url::to(['user/email-pin-resend']) . '","#email_verification","10");
        
    });    
    
');
?>
