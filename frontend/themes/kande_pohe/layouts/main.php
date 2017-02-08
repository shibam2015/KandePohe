<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\ActiveForm;
#use frontend\components\CommonHelper;
use common\components\CommonHelper;

AppAsset::register($this);

#$LOGO = CommonHelper::getLogo();

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
        <meta name="viewport" content="width=device-width,  initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?= Yii::$app->homeUrl ?>images/favicon.ico">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <meta name="apple-mobile-web-app-title" content="Kande Pohe">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= Yii::$app->homeUrl ?>css/images/app-icon/wd-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120"
              href="<?= Yii::$app->homeUrl ?>css/images/app-icon/wd-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152"
              href="<?= Yii::$app->homeUrl ?>css/images/app-icon/wd-ipad-retina.png">
        <!-- Bootstrap core CSS -->
        <!-- Fonts CSS -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600' rel='stylesheet' type='text/css'>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Custom styles for this template -->
        <script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/angular.min.js"></script>
        <script>
            var masterSiteUrl = '<?= Yii::$app->homeUrl ?>';
        </script>
    </head>
    <body>

    <?php if (Yii::$app->user->identity->eEmailVerifiedStatus == 'Yes' || Yii::$app->user->identity->ePhoneVerifiedStatus == 'Yes') { ?>
        <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
    <?php } else { ?>
        <?php echo $this->render('/layouts/parts/_headerregister.php'); ?>
    <?php } ?>

    <?php if (!Yii::$app->user->isGuest) { ?>
        <?= $this->render('/user/_phone_process.php'); ?>
        <?php
        if (Yii::$app->user->identity->Mobile_Multiple_Status == 1 && Yii::$app->user->identity->multiple_profile_status == 0) {
            $this->registerJs('
            phoneExist();
            ');
        }
    } ?>

    <?php $this->beginBody() ?>
    <!--<div class="">
    <? /*= $this->render('/layouts/parts/_headerafterlogin');*/ ?>

    <main>
      <section>
        <div class="container">
          --><? /*= Alert::widget() */ ?>
    <?= $content ?>
    <!--Footer-->
    <?= $this->render('_footer'); ?>
    <div class="kp_notify">
        <div class="kp_notification"></div>
        <span class="kp_notification_close">&times;</span>
    </div>
    <!--<span class="kp_crop_close">Close</span>-->

    </div>
    </div>

    <?php if (Yii::$app->user->isGuest) { ?>
        <!-- Modal Reset Password Link -->
        <div class="modal fade" id="reset-pswd-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <p class="text-center mrg-bt-10"><img src="<?= CommonHelper::getLogo() ?>" width="157" height="61"
                                                      alt="logo">
                </p>

                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                                class="sr-only">Close</span>
                        </button>
                        <h2 class="text-center">Reset Password Link</h2>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1 text-center">
                                    <h4 class="mrg-bt-10"><span class="text-success"></span> We just emailed you a link
                                        at-</h4>
                                    <h4 class="mrg-bt-10 text-dark resetid" id="forgot-password-id"><span
                                            class="text-success"><strong>
                                                &#10003;</strong></span></h4>
                                    <h4 class="mrg-bt-10 resetsucess">Please check your email and click on the secure
                                        link.</h4>
                                    <h4 class="mrg-bt resethelp">If you don't see our email, check your spam folder.
                                        Still having trouble?
                                        Please write to us at <a href="mailto:help@kande-pohe.com" target="_top">help@kande-pohe.com.</a>
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <button type="button" class="btn btn-primary mrg-tp-10 col-xs-12"
                                            data-toggle="modal"
                                            data-target="#login">BACK TO LOGIN
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer"></div>
                </div>
            </div>

        </div>
        <!-- Modal Reset Password -->
        <div class="modal fade" id="reset-pswd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <p class="text-center mrg-bt-10"><img src="<?= CommonHelper::getLogo() ?>" width="157" height="61"
                                                      alt="logo">
                </p>

                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                                class="sr-only">Close</span>
                        </button>
                        <h2 class="text-center">Reset Password </h2>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="form-cont"> <span class="input input--akira">
                <input class="input__field input__field--akira" type="text" id="reset_pswd" />
                <label class="input__label input__label--akira" for="reset_pswd"> <span class="input__label-content input__label-content--akira">New Password</span> </label>
                </span> </div>
                                    <div class="form-cont"> <span class="input input--akira">
                <input class="input__field input__field--akira" type="text" id="Reset Password" />
                <label class="input__label input__label--akira" for="Reset Password"> <span class="input__label-content input__label-content--akira">Confirm Password</span> </label>
                </span> </div>
                                    <button type="button" class="btn btn-primary mrg-tp-10 col-xs-12"
                                            data-toggle="modal"
                                            data-target="#reset-pswd-success">Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        <!-- Modal Reset Password Success -->
        <div class="modal fade" id="reset-pswd-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <p class="text-center mrg-bt-10"><img src="<?= CommonHelper::getLogo() ?>" width="157" height="61"
                                                      alt="logo">
                </p>

                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                                class="sr-only">Close</span>
                        </button>
                        <h2 class="text-center">Password Reset</h2>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1 text-center">
                                    <h4 class="mrg-bt-30 text-dark">nidhi.prabhu@gmail.com</h4>
                                    <h4 class="mrg-bt-30"><span class="text-success"><strong>&#10003;</strong></span>
                                        Password has been
                                        reset successfully</h4>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer"></div>
                </div>
            </div>

        </div>
    <?php } ?>

    <!-- NOTIFICATION MODEL START -->
    <div class="modal fade notification-model" id="notification-model" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10"><img src="<?= CommonHelper::getLogo() ?>" width="157" height="61"
                                                  alt="logo">
            </p>

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span>
                    </button>
                    <h2 class="text-center" id="notification_header"> Information</h2>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h4 class="mrg-bt-30 text-dark" id="forgot-password-id"></h4>
                                <h4 class="mrg-bt-30" id="notification_msg">
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <button type="button" class="btn btn-primary mrg-tp-10 col-xs-12" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- NOTIFICATION MODEL END -->
    <!-- Bootstrap core JavaScript
        ================================================== -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
    <!-- Modernizr -->
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>