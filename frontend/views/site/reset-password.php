<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
#use frontend\components\CommonHelper;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
$HOME_URL = Yii::getAlias('@web')."/";
$HOME_URL_SITE = Yii::getAlias('@web')."/site/";
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
              <div class="logo"><a href="" title="logo">
                  <?= Html::img('@web/images/logo-inner.png', ['width' => '202', 'height' => 83, 'alt' => 'logo']); ?> </a>
              </div>
            </div>
            <div class="col-xs-4">
              <div class="help pull-right"><a href="#" title="Help">
                  <?= Html::img('@web/images/help.png', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?> </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <main>
    <div class="container-fluid">
      <div class="row no-gutter bg-dark">
        <!--<div class="col-md-3  col-sm-12">
          <div class="sidebar-nav">
            <div class="navbar navbar-default" role="navigation">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <span class="visible-xs navbar-brand">Sidebar menu</span> </div>
              <div class="navbar-collapse collapse sidebar-navbar-collapse">

              </div>
            </div>
          </div>
        </div>-->
        <div class="col-md-9 col-sm-12 col-md-offset-2">
          <div class="right-column"> <span class="welcome-note">
          <!--<p><strong>Welcome <? /*= $model->email; */ ?> !</strong> We need a few details that will use to chang password.</p>-->
          <p><strong>Choose a new password </strong></p>
          </span>

            <div class="row no-gutter">
              <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="white-section mrg-tp-20 mrg-bt-10">
                  <h3>Change Password</h3>
                  <?php
                  $form = ActiveForm::begin([
                      'id' => 'form-register1',
                      'enableClientValidation' => true,
                      'validateOnChange' => true,
                  ]);
                  ?>

                  <div class="box">
                    <div class="small-col">
                      <div class="required1"><!--<span class="text-danger">*</span>--></div>
                    </div>
                    <div class="mid-col">
                      <div class="form-cont">
                        <?= $form->field($model, 'password', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">New password</span> </label></span>{error}'])->input('password', ['class' => 'input__field input__field--akira form-control pswd']) ?>
                      </div>
                    </div>
                  </div>

                  <div class="box">
                    <div class="small-col">
                      <div class="required1"><!--<span class="text-danger">*</span>--></div>
                    </div>
                    <div class="mid-col">
                      <div class="form-cont">
                        <?= $form->field($model, 'repassword', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Retype password</span> </label></span>{error}'])->input('password', ['class' => 'input__field input__field--akira form-control repassword pswd']) ?>
                        <span class="form-control-feedback mrg-tp-10 prp"></span>
                      </div>
                    </div>
                  </div>

                  <div class="box">
                    <div class="small-col">
                      <div class="required1"><!--<span class="text-danger">*</span>--></div>
                    </div>
                    <div class="mid-col">
                      <div class="form-cont">
                        <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left change-pswd-link', 'name' => 'change_password', 'disabled' => 'disabled']) ?>
                      </div>
                    </div>
                  </div>
                  <!--<div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                      <? /*= Html::submitButton('Change Password', ['class' => 'btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left change-pswd-link', 'name' => 'change_password', 'disabled' => 'disabled']) */ ?>
                    </div>
                  </div>-->

                  <?php ActiveForm::end(); ?>
                </div>
              </div>
              <div class="col-lg-4 col-md-12 col-sm-12">
                <aside>
                  <div class="aside-header text-center">
                    <h3><span class="font-light">Try Our</span><br>
                      Premium Membership</h3>
                    <?= Html::img('@web/images/member.png', ['width' => '80', 'height' => 45, 'alt' => 'MemberShip']); ?>
                  </div>

                  <div class="aside-content">
                    <ul class="list-unstyled">
                      <li>
                        <div class="no">1</div>
                        <div class="list-cont"><strong>Promote yourself to matches</strong> Drive responses via emails,
                          chats, phones &amp; SMS
                        </div>
                      </li>
                      <li>
                        <div class="no">2</div>
                        <div class="list-cont"><strong>Get featured, get noticed!</strong> Standout even more with bold
                          listing and spotlight
                        </div>
                      </li>
                      <li>
                        <div class="no">3</div>
                        <div class="list-cont"><strong>View additional profile details</strong> view additional profile
                          details and select better matches
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="aside-footer  mrg-bt-10">
                    <input type="button" name="I want a Premium Plan" value="I want a Premium Plan"
                           class="btn btn-primary mrg-tp-20">
                  </div>
                </aside>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php
$this->registerJs('
  $(document).ready(function() {
    $(document).on("keyup",".pswd",function(e){
        var password = $("#resetpasswordform-password").val();
        var confirmPassword = $("#resetpasswordform-repassword").val();
        if (password.length >= 6 && confirmPassword.length >1 ) {
            if (password != confirmPassword) {
                //$("#resetpasswordform-password").css("background", "red");
                //$("#resetpasswordform-repassword").css("background", "red");
                $(".change-pswd-link").prop("disabled", true);
                $(".prp").html(pswd(2));
                return false;
            } else {
                //$("#resetpasswordform-password").css("background", "green");
                //$("#resetpasswordform-repassword").css("background", "green");
                $(".change-pswd-link").prop("disabled", false);
                $(".prp").html(pswd(1));
                return true;
            }
        }
        if(confirmPassword.length == 0){
          $(".prp").html(pswd(3));
        }
    });

});
');
?>