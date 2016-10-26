<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
use yii\captcha\Captcha;

/*$religion_data = CommonHelper::getReligion();
$community_data = CommonHelper::getCommunity();*/

// var_dump($id = Yii::$app->user->identity->id);
$id = 0;
if (!Yii::$app->user->isGuest) {
#$id = base64_decode($id);
  $id = Yii::$app->user->identity->id;
}
//die();
//use yii\jui\DatePicker;
?>
<div class="video">
  <div class="drop-effect"></div>
  <video autoplay data-preload="auto"  poster="images/poster.jpg" id="bgvid" loop>
    <source src="https://demosthenes.info/assets/videos/polina.webm" type="video/webm">
    <source src="https://demosthenes.info/assets/videos/polina.mp4" type="video/mp4">
  </video>
</div>
<header aria-label="video-header2" role="banner">
  <!-- Video -->
  <!-- over-header -->
  <div class="over-header">
    <div class="header">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-xs-12">
            <div class="logo"> <a href="<?=Yii::$app->getUrlManager()->getBaseUrl()?>" title="logo"> <img src="images/logo1.png" width="250" height="88" alt="logo" class="img1" title="Kande Pohe"> </a> <a href="index.html" title="logo"> <img src="images/logo2.png" width="214" height="78" alt="logo" class="img2" title="Kande Pohe"> </a> </div>
          </div>
          <div class="col-sm-6 col-xs-12">
            <div class="menu pull-right">

              <ul class="list-inline">
                <?php if($id){ ?>
                    <li><?= html::a('<i class="ti-power-off m-r-5"></i> Logout</a>', ['site/logout'], ['data-method' => 'post']) ?></li>
                    <li><a href="user/my-profile" title="Profile">Profile</a></li>
                <?php } else { ?>
                  <li><a href="#" title="Login" data-toggle="modal" data-target="#login" id="login_button">Login</a>
                  </li>
                    <li><a href="#" title="Sign up Free" data-toggle="modal" data-target="#myModalNorm" id="suf">Sign up
                            Free</a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="welcome-content">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="welcome-line">Etiam pellentesque sapien felis<br>
              <span>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,</span></h1>
            <!--<input type="button" name="button" value="button label" class="btn btn-primary mrg-tp-10">
            <p class="play visible-lg visible-md"><a href="#"><img src="images/play.png" width="48" height="48" alt="play"></a></p>-->
          </div>
        </div>
      </div>
    </div>
    <div class="search-filter">
      <div class="container">
        <div class="row filter">
          <div class="col-sm-4 col-md-2"> <span class="placeholder-text">Profile for</span>
            <select class="cs-select cs-skin-border top">
              <option value="Self" disabled selected> Self</option>
              <option value="Son">Son</option>
              <option value="Daughter">Daughter</option>
              <option value="Brother">Brother</option>
              <option value="Sister">Sister</option>
              <option value="Friend">Friend</option>
            </select>
          </div>
          <div class="col-sm-4 col-md-2">
            <select class="cs-select cs-skin-border">
              <option value="" disabled selected> Community</option>
              <option value="Community 1">Community 1</option>
              <option value="Community 2">Community 2</option>
              <option value="Community 3">Community 3</option>
            </select>
          </div>
          <div class="col-sm-4 col-md-2">
            <select class="cs-select cs-skin-border">
              <option value="" disabled selected> Sub Caste</option>
              <option value="Bride">Bride</option>
              <option value="Groom">Groom</option>
              <option value="Text3">Text3</option>
            </select>
          </div>
          <div class="col-sm-4 col-md-2">
            <select class="cs-select cs-skin-border">
              <option value="" disabled selected> Age Group</option>
              <option value="Bride">Bride</option>
              <option value="Groom">Groom</option>
              <option value="Text3">Text3</option>
            </select>
          </div>
          <div class="col-sm-4 col-md-2">
            <select class="cs-select cs-skin-border">
              <option value="" disabled selected> Height</option>
              <option value="Bride">Bride</option>
              <option value="Groom">Groom</option>
              <option value="Text3">Text3</option>
            </select>
          </div>
          <div class="col-sm-4 col-md-2">
            <input type="button" name="button" value="search" class="btn btn-primary mrg-tp-10">
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!--featured-member-->
<section class="featured-member">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h2 class="heading-md">Featured Members</h2>
        <p class="tagline">Find the one made for you among thousands of eligible matches</p>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="thumbnail">
          <div class="caption">
            <h4>SZR8953</h4>
            <div class="details">
              <p>Age:  22yrs</p>
              <p>Height:  5' 2"</p>
              <p>Education: BE.IT</p>
              <p>Occupation: Teacher</p>
              <p>Caste: 96 K</p>
              <p>Native: Ahmednagar</p>
              <p>Current City: Pune</p>
            </div>
          </div>
          <img src="images/thumb1.jpg" width="235" height="235" alt="Devansh Tambe"> </div>
        <figcaption> <a href="#"><small>Devansh Tambe</small></a>
          <div class="inter">
            <div class="int-ico pull-left">
              <input id="int1" type="checkbox" name="Remember" value="check1">
              <label for="int1" class="control-label"> <a href="#">Show Interest</a> </label>
            </div>

          </div>
        </figcaption>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="thumbnail">
          <div class="caption">
            <h4>SZR8953</h4>
            <div class="details">
              <p>Age:  22yrs</p>
              <p>Height:  5' 2"</p>
              <p>Education: BE.IT</p>
              <p>Occupation: Teacher</p>
              <p>Caste: 96 K</p>
              <p>Native: Ahmednagar</p>
              <p>Current City: Pune</p>
            </div>
          </div>
          <img src="images/thumb2.jpg" width="235" height="235" alt="Pari Jadhav"> </div>
        <figcaption> <a href="#"><small>Pari Jadhav</small></a>
          <div class="inter">
            <div class="int-ico">
              <input id="int2" type="checkbox" name="Remember" value="check1">
              <label for="int2" class="control-label"> <a href="#">Show Interest</a> </label>
            </div>
          </div>
        </figcaption>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="thumbnail">
          <div class="caption">
            <h4>SZR8953</h4>
            <div class="details">
              <p>Age:  22yrs</p>
              <p>Height:  5' 2"</p>
              <p>Education: BE.IT</p>
              <p>Occupation: Teacher</p>
              <p>Caste: 96 K</p>
              <p>Native: Ahmednagar</p>
              <p>Current City: Pune</p>
            </div>
          </div>
          <img src="images/thumb2.jpg" width="235" height="235" alt="Arjun Patil"> </div>
        <figcaption><a href="#"> <small>Arjun Patil</small></a>
          <div class="inter">
            <div class="int-ico">
              <input id="int3" type="checkbox" name="Remember" value="check1">
              <label for="int3" class="control-label"> <a href="#">Show Interest</a> </label>
            </div>
          </div>
        </figcaption>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="thumbnail">
          <div class="caption">
            <h4>SZR8953</h4>
            <div class="details">
              <p>Age:  22yrs</p>
              <p>Height:  5' 2"</p>
              <p>Education: BE.IT</p>
              <p>Occupation: Teacher</p>
              <p>Caste: 96 K</p>
              <p>Native: Ahmednagar</p>
              <p>Current City: Pune</p>
            </div>
          </div>
          <img src="images/thumb3.jpg" width="235" height="235" alt="thumb1"> </div>
        <figcaption> <a href="#"><small>Shreya Gadkari</small></a>
          <div class="inter">
            <div class="int-ico">
              <input id="int4" type="checkbox" name="Remember" value="check1">
              <label for="int4" class="control-label"> <a href="#">Show Interest</a> </label>
            </div>
          </div>
        </figcaption>
      </div>
    </div>
  </div>
</section>
<!--Success Stories-->
<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h2 class="heading-md">Success Stories</h2>
        <p class="tagline">Read the success stories of these lovely couples</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="block"> <img src="images/pic1.jpg" width="503" height="243" class="img-responsive">
          <div class="black-strap">
            <div class="name">Divya and Rajdeep Abhyankar</div>
            <div class="inter"> <i class="fa fa-map-marker"></i> Nashik </div>
            <div class="inter"> <i class="fa fa-calendar"></i> Married Since: March 2015 </div>
          </div>
        </div>
        <div class="block"> <img src="images/pattern_bg.jpg" width="507" height="474" class="img-responsive">
          <summary>
            <p>Our meeting was planned after the families met . After my parents met Mahima they really thought her to be a good match for me. Some days later when i visited India and met her things worked up and finally we got engaged and married.</p>
            <p class="aut text-danger font20 mrg-tp-10"><strong>Rani and Swapnil Samant</strong> (Ahmedabad)</p>
          </summary>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="block"> <img src="images/pic5.jpg" width="510" height="494" class="img-responsive">
          <div class="black-strap">
            <div class="name">Divya and Rajdeep Abhyankar</div>
            <div class="inter"> <i class="fa fa-map-marker"></i> Nashik </div>
            <div class="inter"> <i class="fa fa-calendar"></i> Married Since: March 2015 </div>
          </div>
        </div>
        <div class="block"> <img src="images/pic3.jpg" width="510" height="226" class="img-responsive">
          <div class="black-strap">
            <div class="name">Divya and Rajdeep Abhyankar</div>
            <div class="inter"> <i class="fa fa-map-marker"></i> Nashik </div>
            <div class="inter"> <i class="fa fa-calendar"></i> Married Since: March 2015 </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="block"> <img src="images/pic4.jpg" width="510" height="247" class="img-responsive">
          <div class="black-strap">
            <div class="name">Divya and Rajdeep Abhyankar</div>
            <div class="inter"> <i class="fa fa-map-marker"></i> Nashik </div>
            <div class="inter"> <i class="fa fa-calendar"></i> Married Since: March 2015 </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="block"> <img src="images/pattern_yellow.jpg" width="510" height="251" class="img-responsive">
          <summary>
            <p>“We have been married for almost a year now. Things are great; We are so happy. </p>
            <p class="aut font20 mrg-tp-10"><strong>Preeti and Sandeep Prabhu </strong> (Nashik))</p>
          </summary>
        </div>
      </div>
    </div>
  </div>
</section>
<!--What Sets us Apart-->
<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h2 class="heading-md">What Sets us Apart</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="promo">
          <figure> <img src="images/vector_icon1.png" width="119" height="102" alt="Safe and Secure"> </figure>
          <figcaption>
            <h3>Safe and Secure</h3>
            <p>sed tincidunt mi rhoncus. Nam eget nulla risus. Etiam aliqttricies maximus. Vivamus risus velit, cursus at aliquam eu, vehicula vel risus. </p>
          </figcaption>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="promo">
          <figure> <img src="images/vector_icon2.png" width="119" height="102" alt="Maximum Responses"> </figure>
          <figcaption>
            <h3>Maximum Responses</h3>
            <p>sed tincidunt mi rhoncus. Nam eget nulla risus. Etiam aliqttricies maximus. Vivamus risus velit, cursus at aliquam eu, vehicula vel risus. </p>
          </figcaption>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="promo">
          <figure> <img src="images/vector_icon3.png" width="119" height="102" alt="Best Matches"> </figure>
          <figcaption>
            <h3>Best Matches</h3>
            <p>sed tincidunt mi rhoncus. Nam eget nulla risus. Etiam aliqttricies maximus. Vivamus risus velit, cursus at aliquam eu, vehicula vel risus. </p>
          </figcaption>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Signup -->
<div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <p class="text-center mrg-bt-30">
      <?= Html::img('@web/images/logo.png', ['width' => '157','height' => 61,'alt' => 'logo']); ?>
    </p>
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close"
                data-dismiss="modal"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span> </button>
        <h2 class="text-center">Signup free</h2>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <?php
        $form = ActiveForm::begin([
            'id' => 'form-signup',
            //'action' => 'javascript:void(0)',
            'action' => ['/site/register'],
            'enableAjaxValidation' => true,
            'enableClientValidation' => true

        ]);
        ?>
        <button type="button" class="btn btn-primary mrg-tp-10 col-xs-12" data-toggle="modal" id="signup_model_btn" data-target="#signup_model" style="display: none"></button>
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="form-cont">
              <?= $form->field($model, 'email', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Email</span> </label></span>{error}'])->input('email',['class'=>'input__field input__field--akira form-control'])?>
            </div>
            <div class="form-cont">
              <?= $form->field($model, 'password_hash', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Password</span> </label></span>{error}'])->input('password',['class'=>'input__field input__field--akira form-control'])?>
            </div>
            <div class="form-cont">
              <?= $form->field($model, 'repeat_password', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Retype Password</span> </label></span>{error}'])->input('password',['class'=>'input__field input__field--akira form-control'])?>
            </div>
            <div class="form-cont">
              <?= $form->field($model, 'Profile_created_for')->dropDownList(
                  [''=>'Profile for','BRIDE'=>'BRIDE','GROOM'=>'GROOM','SELF'=>'SELF'],
                  ['class' => 'cs-select cs-skin-border']
              )->label(false);?>
            </div>
            <div>
              <div class="row">
                <div class="form-cont col-xs-6">
                  <?= $form->field($model, 'First_Name', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">First Name</span> </label></span>{error}'])->input('text',['class'=>'input__field input__field--akira form-control'])?>
                </div>
                <div class="form-cont col-xs-6">
                  <?= $form->field($model, 'Last_Name', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Last Name</span> </label></span>{error}'])->input('text',['class'=>'input__field input__field--akira form-control'])?>
                </div>
              </div>
            </div>
            <div class="form-cont">
              <div class="radio radio-new" id="IVA">

                <?= $form->field($model, 'Gender')->RadioList(
                    ['MALE'=>'MALE','FEMALE'=>'FEMALE'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {

                          $return = '<input type="radio" class="genderV" id="' . $value . '" name="' . $name . '" value="' . $value . '" >';
                          $return .= '<label for="'.$value.'">' . ucwords($label) . '</label>';
                          return $return;
                        }
                    ]
                )->label(false);?>
              </div>
            </div>
            <?php
            $this->registerJs('
                $(".genderV").on("change",function(e){
                  var genderVal = $(this).val();
                  if(genderVal == "FEMALE") {
                    $("#DOB").datepicker("option","maxDate","'.date('Y-m-d',strtotime('-18 year')).'");
                    $("#DOB").datepicker("option","yearRange","-70:-18");
                  }
                  else {
                    $("#DOB").datepicker("option","maxDate","'.date('Y-m-d',strtotime('-21 year')).'");
                    $("#DOB").datepicker("option","yearRange","-70:-21");
                  }
                });
              ');
            ?>
            <div class="form-cont">

              <?= $form->field($model, 'DOB', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Date Of Birth</span> </label></span>{error}'])->input('text')
                  ->widget(\yii\jui\DatePicker::classname(),
                      [
                          'dateFormat' => 'php:Y-m-d',
                          'options'=>[
                              'class'=>'input__field input__field--akira form-control',
                              'id'=>'DOB',
                          ],
                          'clientOptions' => [
                              'changeMonth' => true,
                              'yearRange' => '-70:-21',
                              'changeYear' => true,
                              'maxDate' => date('Y-m-d',strtotime('-21 year')),
                          ]

                      ]);
              ?>
            </div>
            <div>
              <div class="row">
                <div class="form-cont col-xs-6" >
                  <?= $form->field($model, 'county_code')->dropDownList(
                      ['+91'=>'+91'],
                      ['class' => 'cs-select cs-skin-border','prompt' => 'Country Code']
                  )->label(false);?>
                </div>
                <div class="form-cont col-xs-6" >
                  <?= $form->field($model, 'Mobile', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Mobile No#</span> </label></span>{error}'])->input('text',['class'=>'input__field input__field--akira form-control'])?>
                </div>
              </div>
              <!-- <div class="row">
                <div class="col-xs-12">
                  <script src="https://www.google.com/recaptcha/api.js" type="text/javascript"></script>
                  <div class="g-recaptcha" data-sitekey="6Lc2xSgTAAAAAGwyfpM9OHwcAa6GZa6-6ghDl4yY"></div>
                  <div style="color:red;" id="cerror"></div>
                </div>
              </div> -->

                <div class="row">
                  <div class="checkbox col-sm-12 checkbox-new" id="cjkbox">

                        <?= $form->field($model, 'toc')->checkboxList(
                            ['YES'],
                            [
                                'item' => function ($index, $label, $name, $checked, $value) {

                                    $return = '<input type="checkbox" id="toc" name="' . $name . '" value="YES" >';
                                    $return .= '<label for="toc" class="control-label toccl">By clicking ‘Sign Up Free’ you agree to our <a href="#" title="Terms">Terms</a></label>';
                                    return $return;
                                }
                            ]
                        )->label(false); ?>

                    </div>
                  <div class="col-sm-10">

                        <?= Html::submitButton('Sign up free', ['class' => 'btn btn-primary mrg-tp-10', 'name' => 'signup-button', 'id' => 'btnSignup']) ?>
                    </div>
              </div>
                <?php ActiveForm::end(); ?>

                <div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<!-- Modal Login -->
<div class="modal fade login login-top" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" data-loading-text="Login...">
  <div class="modal-dialog">
    <p class="text-center mrg-bt-10"><?= Html::img('@web/images/logo.png', ['width' => '157','height' => 61,'alt' => 'logo']); ?></p>
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
          <button type="button" class="close"
                  data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
          </button>
        <h2 class="text-center">Log into your account</h2>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
          <?php
          $login = new LoginForm();
          ?>
          <?php $form = ActiveForm::begin([
              'id' => 'login-form',
              'action' => 'site/login',
              'enableAjaxValidation' => true,
              'enableClientValidation' => true,
          ]);
          ?>
          <div class="row">
              <div class="col-sm-10 col-sm-offset-1 text-center">
                  <!--<span class="error">Email or Password used is incorrect</span> --></div>
          </div>
          <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <div
                      class="form-cont"> <?= $form->field($login, 'email', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Email</span> </label></span>{error}'])->input('email', ['class' => 'input__field input__field--akira form-control']) ?> </div>
                  <div class="form-cont">
              <?= $form->field($login, 'password', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Password</span> </label></span>{error}'])->input('password',['class'=>'input__field input__field--akira form-control'])?>
            </div>
                  <div class="checkbox">
                      <input id="Remember" type="checkbox" name="Remember" value="yes">

                      <label for="Remember" class="control-label">Remember me</label>
                      <a href="#" class="pull-right mrg-tp-10" title="Forgot password" data-toggle="modal"
                         data-target="#fpswd">Forgot password?</a></div>
                  <!-- <a href="dash-board.html" class="">Login</a> -->
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary mrg-tp-10 col-xs-12 login-btn', 'id' => '#loginbtn', 'name' => 'login-button', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Login...']) ?>
                  <div class="bar-devider"><span>OR</span></div>
                  <a class="btn btn-block btn-social btn-facebook"> <i class="fa fa-facebook"></i> Sign in with Facebook
                  </a>
                  <!--<a class="btn btn-block btn-social btn-google-plus"> <i class="fa fa-google-plus"></i> Sign in with Google </a>-->
          </div>
          </div>
          <?php ActiveForm::end(); ?>
      </div>
    </div>

      <!-- Modal Footer -->
  </div>
</div>

<!-- Modal Sign Up After -->
<div class="modal fade" id="signup_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <p class="text-center mrg-bt-30"><img src="images/logo.png" width="157" height="61" alt="logo" ></p>
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close"
                data-dismiss="modal"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span> </button>
        <!--<h2 class="text-center">Signup free</h2>-->
      </div>
      <!-- Modal Body -->
      <div class="modal-body" id="signupMSG">

      </div>
    </div>
  </div>
</div>

<style type="text/css">
  .ui-datepicker{
    z-index: 1200 !important;
  }

  .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
    background: #ee1845;
    color: #fff;
    border-radius: 0%;
    -moz-border-radius: 0%;
    -webkit-border-radius: 0%;
  }

  .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active {
    border: 1px solid #ee1845;
    background: #ffffff url(images/ui-bg_glass_65_ffffff_1x400.png) 50% 50% repeat-x;
    font-weight: normal;
    color: #ee1845;

  }

  .btn-primary.disabled, .btn-primary.disabled.active, .btn-primary.disabled.focus, .btn-primary.disabled:active, .btn-primary.disabled:focus, .btn-primary.disabled:hover, .btn-primary[disabled], .btn-primary[disabled].active, .btn-primary[disabled].focus, .btn-primary[disabled]:active, .btn-primary[disabled]:focus, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary, fieldset[disabled] .btn-primary.active, fieldset[disabled] .btn-primary.focus, fieldset[disabled] .btn-primary:active, fieldset[disabled] .btn-primary:focus, fieldset[disabled] .btn-primary:hover {
    background-color: #ee1845;
    border-color: #ee1845;
  }
</style>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/processing/processing.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php
$this->registerJs('
    $("body").on("submit","#form-signup",function(e){
      var form = $(this);
      if(form.find(".has-error").length) {
            return false;
      }
      if(!$("#btnSignup").is(":disabled")){
        $("#btnSignup").attr("disabled",true).html("Please Wait...");   
        return true;
      }
      else {
        return false;
      }
      return true;
    });
    $("body").on("submit","#login-form",function(e){
      var form = $(this);
      if(form.find(".has-error").length) {
            return false;
      }
      if(!$("#loginbtn").is(":disabled")){
        var $this_l = $(".login-btn");
        $this_l.button("loading");
        setTimeout(function() {
            $this_l.button("reset");
        }, 8000);

        return true;
      }
      else {
        return false;
      }
      return true;
    });

    $("#suf").click(function(){
    $("#form-signup")[0].reset();
    });
    $("#login_button").click(function(){
    $("#login-form")[0].reset();
    });
  ');
?>
