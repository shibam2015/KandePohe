<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\components\CommonHelper;
use yii\helpers\ArrayHelper;
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
            <div class="logo"> <a href="" title="logo"> <!-- <img src="images/logo-inner.png" width="202" height="83" alt="logo" title="Kande Pohe"> --><?= Html::img('@web/images/logo-inner.png', ['width' => '202','height' => 83,'alt' => 'logo']); ?> </a> </div>
          </div>
          <div class="col-xs-4">
            <div class="help pull-right"> <a href="#" title="Help"> <!-- <img src="images/help.png" width="21" height="21" alt="help" title="Help"> --><?= Html::img('@web/images/help.png', ['width' => '21','height' => 21,'alt' => 'help']); ?> </a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<main>
  <div class="container-fluid">
    <div class="row no-gutter bg-dark">
      <div class="col-md-3  col-sm-12">
        <div class="sidebar-nav">
          <div class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
              <span class="visible-xs navbar-brand">Sidebar menu</span> </div>
            <div class="navbar-collapse collapse sidebar-navbar-collapse">
              
            </div>
            <!--/.nav-collapse -->
          </div>
        </div>
      </div>
      <div class="col-md-9 col-sm-12">
        <div class="right-column"> <span class="welcome-note">
          <!--<p><strong>Welcome <? /*= $model->email; */ ?> !</strong> We need a few details that will use to chang password.</p>-->
          <p><strong>Choose a new password </strong></p>
          </span>
          <div class="row no-gutter">
            <div class="col-lg-8 col-md-12 col-sm-12">
              <div class="white-section mrg-tp-20 mrg-bt-10">
                <h3>Change Password</h3>
                <!-- <span class="error">Oops! Please ensure all fields are valid</span> -->
                <?php
                $form = ActiveForm::begin([
                    'id' => 'form-register1',
                ]);
                ?>
                
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><!--<span class="text-danger">*</span>--></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'password', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">New password</span> </label></span>{error}'])->input('password', ['class' => 'input__field input__field--akira form-control']) ?>
                    </div>
                  </div>
                </div>

                <div class="box">
                  <div class="small-col">
                    <div class="required1"><!--<span class="text-danger">*</span>--></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'repassword', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Retype password</span> </label></span>{error}'])->input('password', ['class' => 'input__field input__field--akira form-control repassword']) ?>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-10 col-sm-offset-1">
                    <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left change-password', 'name' => 'change_password']) ?>
                    <!-- <a href="<?/*=$HOME_URL_SITE*/?>life-style" class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right">Skip</a>-->
                  </div>
                </div>

                <?php ActiveForm::end(); ?>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
              <aside>
                <div class="aside-header text-center">
                  <h3><span class="font-light">Try Our</span><br>
                    Premium Membership</h3>
                  <?= Html::img('@web/images/member.png', ['width' => '80','height' => 45,'alt' => 'MemberShip']); ?></div>

                <div class="aside-content">
                  <ul class="list-unstyled">
                    <li>
                      <div class="no">1</div>
                      <div class="list-cont"><strong>Promote yourself to matches</strong> Drive responses via emails, chats, phones &amp; SMS</div>
                    </li>
                    <li>
                      <div class="no">2</div>
                      <div class="list-cont"><strong>Get featured, get noticed!</strong> Standout even more with bold listing and spotlight</div>
                    </li>
                    <li>
                      <div class="no">3</div>
                      <div class="list-cont"><strong>View additional profile details</strong> view additional profile details and select better matches</div>
                    </li>
                  </ul>
                </div>
                <div class="aside-footer  mrg-bt-10">
                  <input type="button" name="I want a Premium Plan" value="I want a Premium Plan" class="btn btn-primary mrg-tp-20">
                </div>
              </aside>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  $(document).ready(function () {
    $(".change-password").attr("disabled", "true");
    $(".form-control").blur(function () {
      if ($(this).val() != "") {
        $(".change-password").removeAttr("disabled");
      } else {
        $(".change-password").attr("disabled", "true");
      }
    });
  });
  $(function () {
    $('input').change(function () {
      var $input = $(this),
          $flag = $input.next();

      if (!$input.val()) {
        $flag.remove();
      }

      if ($flag.length == 0 || !$flag.is('.valid')) {
        $input.after('<div class="valid"></div>');
      }
    });
  });
</script>
