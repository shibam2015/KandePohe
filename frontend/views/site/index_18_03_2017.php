<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
Use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
use yii\captcha\Captcha;
use frontend\models\PasswordResetRequestForm;

$forgot = new PasswordResetRequestForm();
/*$religion_data = CommonHelper::getReligion();
$community_data = CommonHelper::getCommunity();*/

// var_dump($id = Yii::$app->user->identity->id);
$id = 0;
if (!Yii::$app->user->isGuest) {
#$id = base64_decode($id);
    $id = Yii::$app->user->identity->id;
}
//die();
use yii\jui\DatePicker;

?>
<div class="video">
    <div class="drop-effect"></div>
    <video autoplay data-preload="auto" poster="images/poster.jpg" id="bgvid" loop>
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
                        <div class="logo"><a href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>" title="logo">
                                <img
                                    src="images/logo1.png" width="250" height="88" alt="logo" class="img1"
                                    title="Kande Pohe"> </a>
                            <a href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>" title="logo"> <img
                                    src="images/logo2.png"
                                    width="214" height="78"
                                    alt="logo" class="img2"
                                    title="Kande Pohe"> </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="menu pull-right">

                            <ul class="list-inline">
                                <?php if ($id) { ?>
                                    <li><?= html::a('<i class="ti-power-off m-r-5"></i> Logout</a>', ['site/logout'], ['data-method' => 'post']) ?></li>
                                    <li><a href="user/my-profile" title="Profile">Profile</a></li>
                                <?php } else { ?>
                                    <li><a href="#" title="Login" data-toggle="modal" data-target="#login"
                                           class="login_button">Login</a>
                                    </li>
                                    <li><a href="#" title="Sign up Free" data-toggle="modal"
                                           data-target="#myModalNorm"
                                           id="suf">Sign up
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
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'form-search',
                        'action' => ['search/basic-search'],
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => true,
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ]);
                    ?>

                    <div class="col-sm-4 col-md-2">
                        <?= $form->field($model, 'Profile_for')->dropDownList(
                            ['FEMALE' => 'BRIDE', 'MALE' => 'GROOM'],
                            ['class' => 'demo-default select-beast',
                                'prompt' => 'Looking For'
                            ]
                        )->label(false); ?>
                    </div>
                    <div class="col-sm-4 col-md-2">

                        <?= $form->field($model, 'iCommunity_ID')->dropDownList(
                            ArrayHelper::map(CommonHelper::getCommunity(), 'iCommunity_ID', 'vName'),
                            ['class' => 'demo-default select-beast',
                                'prompt' => 'Community'
                            ]

                        )->label(false)->error(false); ?>

                    </div>
                    <div class="col-sm-4 col-md-2">
                        <?= $form->field($model, 'iSubCommunity_ID')->dropDownList(
                            ArrayHelper::map(CommonHelper::getSubCommunity(), 'iSubCommunity_ID', 'vName'),
                            ['class' => 'demo-default select-beast',
                                'prompt' => 'Sub Caste'
                            ]

                        )->label(false)->error(false); ?>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <?php
                        $range = range(18, 100);
                        ?>
                        <?= $form->field($model, 'Agerange')->dropDownList(
                        //array_combine($range, $range),
                            ['18-21' => '18 To 21', '22-28' => '22 To 28', '29-35' => '29 To 35', '36-45' => '36 To 45', '46-60' => '46 To 60', '61-80' => '61 To 80', '81-100' => '81 To 100'],
                            ['prompt' => 'Age Group',
                                'class' => 'demo-default select-beast']
                        )->label(false)->error(false); ?>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <?= $form->field($model, 'iHeightID')->dropDownList(
                            ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
                            ['class' => 'demo-default select-beast',
                                'prompt' => 'Height'
                            ]
                        )->label(false)->error(false); ?>
                    </div>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <div class="col-sm-4 col-md-2">
                            <?= Html::submitButton('SEARCH', ['class' => 'btn btn-primary mrg-tp-10 ', 'name' => 'button']) ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-sm-4 col-md-2">
                            <a href="#" title="Login" data-toggle="modal" data-target="#login"
                               class="btn btn-primary mrg-tp-10 login_button"
                               id="">Seach</a>
                        </div>
                    <?php } ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</header>
<!--featured-member-->
<?php if (count($FeaturedMembers) > 0) {
    ?>
    <section class="featured-member">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 class="heading-md">Featured Members</h2>

                    <p class="tagline">Find the one made for you among thousands of eligible matches</p>
                </div>
            </div>

            <div class="row">
                <?php
                foreach ($FeaturedMembers as $FK => $FV) {
                    ?>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?= $FV->Registration_Number ?></h4>

                                <div class="details">
                                    <p>Age:  <?= CommonHelper::getAge($FV->DOB); ?> years</p>

                                    <p>Height:  <?= CommonHelper::setInputVal($FV->height->vName, 'text'); ?></p>

                                    <p>
                                        Education: <?= CommonHelper::setInputVal($FV->educationLevelName->vEducationLevelName, 'text') ?></p>

                                    <p>
                                        Occupation: <?= CommonHelper::setInputVal($FV->workingAsName->vWorkingAsName, 'text') ?></p>

                                    <p>Caste: <?= $FV->communityName->vName; ?></p>

                                    <p>Native: <?= CommonHelper::setInputVal($FV->vNativePlaceCA, 'text') ?></p>

                                    <p>Current
                                        City: <?= CommonHelper::setInputVal($FV->cityName->vCityName, 'text') . ', ' . CommonHelper::setInputVal($FV->countryName->vCountryName, 'text') ?></p>
                                </div>
                            </div>
                            <?= Html::img(CommonHelper::getPhotos('USER', $FV->id, '260' . $FV->propic, 260, '', 'Yes'), ['alt' => $FV->FullName]); ?>
                        </div>
                        <figcaption>
                            <a href="<?= CommonHelper::getUserUrl($FV->Registration_Number) ?>&source=recently_joined">
                                <small><?= $FV->FullName ?></small>
                            </a>

                            <div class="inter">
                                <div class="int-ico pull-left">
                                    <input id="<?= $FV->Registration_Number ?>" type="checkbox" name="Remember"
                                           value="check1">
                                    <label for="<?= $FV->Registration_Number ?>" class="control-label">
                                        <a <?php
                                        if (!Yii::$app->user->isGuest) { ?>
                                            href="<?= CommonHelper::getUserUrl($FV->Registration_Number) ?>&source=recently_joined"
                                        <?php } else { ?>
                                            href="#" title="Login" data-toggle="modal" data-target="#login" id="login_button"
                                        <?php } ?>
                                            >Show Interest</a>
                                    </label>
                                </div>
                            </div>
                        </figcaption>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php }
?>

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
                <div class="block"><img src="images/pic1.jpg" width="503" height="243" class="img-responsive">

                    <div class="black-strap">
                        <div class="name">Divya and Rajdeep Abhyankar</div>
                        <div class="inter"><i class="fa fa-map-marker"></i> Nashik</div>
                        <div class="inter"><i class="fa fa-calendar"></i> Married Since: March 2015</div>
                    </div>
                </div>
                <div class="block"><img src="images/pattern_bg.jpg" width="507" height="474" class="img-responsive">
                    <summary>
                        <p>Our meeting was planned after the families met . After my parents met Mahima they really
                            thought her to be a good match for me. Some days later when i visited India and met her
                            things worked up and finally we got engaged and married.</p>

                        <p class="aut text-danger font20 mrg-tp-10"><strong>Rani and Swapnil Samant</strong>
                            (Ahmedabad)
                        </p>
                    </summary>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="block"><img src="images/pic5.jpg" width="510" height="494" class="img-responsive">

                    <div class="black-strap">
                        <div class="name">Divya and Rajdeep Abhyankar</div>
                        <div class="inter"><i class="fa fa-map-marker"></i> Nashik</div>
                        <div class="inter"><i class="fa fa-calendar"></i> Married Since: March 2015</div>
                    </div>
                </div>
                <div class="block"><img src="images/pic3.jpg" width="510" height="226" class="img-responsive">

                    <div class="black-strap">
                        <div class="name">Divya and Rajdeep Abhyankar</div>
                        <div class="inter"><i class="fa fa-map-marker"></i> Nashik</div>
                        <div class="inter"><i class="fa fa-calendar"></i> Married Since: March 2015</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="block"><img src="images/pic4.jpg" width="510" height="247" class="img-responsive">

                    <div class="black-strap">
                        <div class="name">Divya and Rajdeep Abhyankar</div>
                        <div class="inter"><i class="fa fa-map-marker"></i> Nashik</div>
                        <div class="inter"><i class="fa fa-calendar"></i> Married Since: March 2015</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="block"><img src="images/pattern_yellow.jpg" width="510" height="251"
                                        class="img-responsive">
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
                    <figure><img src="images/vector_icon1.png" width="119" height="102" alt="Safe and Secure">
                    </figure>
                    <figcaption>
                        <h3>Safe and Secure</h3>

                        <p>sed tincidunt mi rhoncus. Nam eget nulla risus. Etiam aliqttricies maximus. Vivamus risus
                            velit, cursus at aliquam eu, vehicula vel risus. </p>
                    </figcaption>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="promo">
                    <figure><img src="images/vector_icon2.png" width="119" height="102" alt="Maximum Responses">
                    </figure>
                    <figcaption>
                        <h3>Maximum Responses</h3>

                        <p>sed tincidunt mi rhoncus. Nam eget nulla risus. Etiam aliqttricies maximus. Vivamus risus
                            velit, cursus at aliquam eu, vehicula vel risus. </p>
                    </figcaption>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="promo">
                    <figure><img src="images/vector_icon3.png" width="119" height="102" alt="Best Matches"></figure>
                    <figcaption>
                        <h3>Best Matches</h3>

                        <p>sed tincidunt mi rhoncus. Nam eget nulla risus. Etiam aliqttricies maximus. Vivamus risus
                            velit, cursus at aliquam eu, vehicula vel risus. </p>
                    </figcaption>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (Yii::$app->user->isGuest) { ?>
    <!-- Modal Signup -->
    <div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-30">
                <?= Html::img('@web/images/logo.png', ['width' => '157', 'height' => 61, 'alt' => 'logo']); ?>
            </p>

            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span>
                    </button>
                    <h2 class="text-center">Signup Free</h2>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'form-signup',
                        //'action' => 'javascript:void(0)',
                        'action' => ['/site/register'],
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'validateOnChange' => true,

                    ]);
                    ?>
                    <button type="button" class="btn btn-primary mrg-tp-10 col-xs-12" data-toggle="modal"
                            id="signup_model_btn"
                            data-target="#signup_model" style="display: none"></button>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="form-cont">
                                <?= $form->field($model, 'email', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Email</span> </label></span>{error}'])->input('email', ['class' => 'input__field input__field--akira form-control']) ?>
                            </div>
                            <div class="form-cont">
                                <?= $form->field($model, 'password_hash', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Password</span> </label></span>{error}'])->input('password', ['class' => 'input__field input__field--akira form-control']) ?>
                            </div>
                            <div class="form-cont">
                                <?= $form->field($model, 'repeat_password', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Retype Password</span> </label></span>{error}'])->input('password', ['class' => 'input__field input__field--akira form-control']) ?>
                            </div>
                            <div class="form-cont">
                                <?= $form->field($model, 'Profile_created_for')->dropDownList(
                                    ['' => 'Profile for', 'Self' => 'Self', 'Son' => 'Son', 'Daughter' => 'Daughter', 'Brother' => 'Brother', 'Sister' => 'Sister', 'Friend' => 'Friend'],
                                    ['class' => 'demo-default select-beast']
                                )->label(false); ?>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="form-cont col-xs-6">
                                        <?= $form->field($model, 'First_Name', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">First Name</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control']) ?>
                                    </div>
                                    <div class="form-cont col-xs-6">
                                        <?= $form->field($model, 'Last_Name', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Last Name</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-cont">
                                <div class="radio radio-new" id="IVA">

                                    <?= $form->field($model, 'Gender')->RadioList(
                                        ['MALE' => 'MALE', 'FEMALE' => 'FEMALE'],
                                        [
                                            'item' => function ($index, $label, $name, $checked, $value) {

                                                $return = '<input type="radio" class="genderV" id="' . $value . '" name="' . $name . '" value="' . $value . '" >';
                                                $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                                                return $return;
                                            }
                                        ]
                                    )->label(false); ?>
                                </div>
                            </div>
                            <div class="form-cont">
                                <?= $form->field($model, 'DOB', ["template" => '<span class="input input--akira dobcl ">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Date Of Birth</span> </label></span>{error}'])->input('text')
                                    ->widget(\yii\jui\DatePicker::classname(),
                                        [
                                            'dateFormat' => 'php:Y-m-d',
                                            'options' => [
                                                'class' => 'input__field input__field--akira form-control',
                                                'id' => 'user-dob',
                                                'onchange' => ' $(".dobcl").addClass("input--filled");',
                                                'onkeyup' => ' $(".hasDatepicker").val("");',

                                            ],
                                            'clientOptions' => [
                                                'changeMonth' => true,
                                                'yearRange' => '-70:-21',
                                                'changeYear' => true,
                                                'maxDate' => date('Y-m-d', strtotime('-21 year')),
                                            ],
                                        ]);
                                ?>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="form-cont col-xs-6">
                                        <?= $form->field($model, 'county_code')->dropDownList(
                                            ['+91' => '+91'],
                                            ['class' => 'demo-default select-beast', 'prompt' => 'Country Code']
                                        )->label(false); ?>
                                    </div>
                                    <div class="form-cont col-xs-6">
                                        <?= $form->field($model, 'Mobile', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Mobile No#</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control']) ?>
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
                                                    $return .= '<label for="toc" class="control-label toccl">I agree to the <a href="#" title="[Privacy
Policy]">[Privacy
Policy]</a> and <a href="#" title="[T&C]">[T&C]</a></label>';
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
         aria-hidden="true" data-loading-text="Login..">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10"><?= Html::img('@web/images/logo.png', ['width' => '157', 'height' => 61, 'alt' => 'logo']); ?></p>

            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span>
                    </button>
                    <h2 class="text-center">Log Into Your Account</h2>
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
                        'validateOnChange' => false,
                        //'enableClientValidation' => true,
                        'validateOnSubmit' => true,
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1 text-left">
                            <?= $form->errorSummary($model, ['header' => '']); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div
                                class="form-cont"> <?= $form->field($login, 'email', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Email</span> </label></span>{error}'])->input('email', ['class' => 'input__field input__field--akira form-control', "data-toggle" => "tooltip", "data-placement" => "top", 'data-original-title' => 'Email ID is mandatory to register at Kande- Pohe.com. We never share your email address with 3rd parties.'])->error('false'); ?> </div>
                            <div class="form-cont">
                                <?= $form->field($login, 'password', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Password</span> </label></span>{error}<div class="loginerror"></div> '])->input('password', ['class' => 'input__field input__field--akira form-control', "data-toggle" => "tooltip", "data-placement" => "top", 'data-original-title' => 'Please enter a password with minimum 6 characters'])->error(false); ?>
                            </div>
                            <div class="checkbox">
                                <input id="Remember" type="checkbox" name="Remember" value="yes">

                                <label for="Remember" class="control-label">Remember me</label>
                                <a href="#" class="pull-right mrg-tp-10" title="Forgot password" data-toggle="modal"
                                   data-target="#fpswd">Forgot password?</a></div>
                            <!-- <a href="dash-board.html" class="">Login</a> -->
                            <?= Html::submitButton('Login', ['class' => 'btn btn-primary mrg-tp-10 col-xs-12 login-btn', 'id' => '#loginbtn', 'name' => 'login-button', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Login...']) ?>
                            <div class="checkbox">
                                <a href="javascript:void(0)" class="pull-right freeacc register_link" title="Register
FREE">[Register FREE]</a>

                                <span class="pull-right freeacc">Don’t have an
                    account?</span></div>
                            <div class="bar-devider"><span>OR</span></div>

                            <a class="btn btn-block btn-social btn-facebook"> <i class="fa fa-facebook"></i> Sign in
                                with Facebook
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
    <div class="modal fade" id="signup_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-30"><img src="images/logo.png" width="157" height="61" alt="logo"></p>

            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span>
                    </button>
                    <!--<h2 class="text-center">Signup free</h2>-->
                </div>
                <!-- Modal Body -->
                <div class="modal-body" id="signupMSG">

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Forgot Password -->
    <div class="modal fade" id="fpswd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <h2 class="text-center">Forgot Password ?</h2>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <!--<form>-->
                    <?php $form = ActiveForm::begin([
                        'id' => 'forget-password',
                        'action' => 'site/request-password-reset',
                        'enableAjaxValidation' => true,
                        'validateOnSubmit' => true
                    ]);
                    /**/ ?><!--       --><?php /*$form = ActiveForm::begin(['id' => 'request-password-reset-form']); */ ?>
                    <div class="row">
                        <!--<div class="col-sm-10 col-sm-offset-1 text-center"> <span class="error">Please enter valid email address</span> </div>-->
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1 text-center">
                            <h4 class="mrg-bt-30 text-dark">We will email you the link to reset the password</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="form-cont">
                                <?= $form->field($forgot, 'email', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Email</span> </label></span>{error}'])->input('email', ['class' => 'input__field input__field--akira form-control', "data-toggle" => "tooltip", "data-placement" => "top", 'data-original-title' => 'Email ID is mandatory.']) ?>
                            </div>
                            <?= Html::submitButton('REQUEST RESET LINK', ['class' => 'btn btn-primary mrg-tp-10 col-xs-12 reset_password', 'name' => 'reset-password-request', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Wait...']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <!--</form>-->
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer"></div>
    </div>

    <!-- Modal Password Reset Success-->
    <div class="modal fade" id="change-pswd-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                    <h2 class="text-center dark">Password Changed Sucessfully</h2>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <button type="button" class="btn btn-primary mrg-tp-10 col-xs-12" data-toggle="modal"
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


<?php } ?>

<?php if (Yii::$app->user->isGuest) { ?>
    <?php # Popup Open
    $this->registerJs('

       $(document).on("click",".register_link",function(e){
            $("#login").modal("toggle");
            setTimeout(function(){
                $("#myModalNorm").modal("toggle");
            }, 500);
        });
    ');

    if ($ref == 'login') {
        $this->registerJs('
              $("#login").modal("toggle");
    ');
    }
    if ($ref == 'signup') {
        $this->registerJs('
              $("#myModalNorm").modal("toggle");
    ');
    }
    if ($ref == 'cps') {
        $this->registerJs('
              $("#change-pswd-link").modal("toggle");
    ');
    }
    ?>
    <?php # SIGN UP
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
    $(".login_button").click(function(){
    $("#login-form")[0].reset();
    });
    $("#form-search").on("submit",function(e){
      var icommunity_id = $("#user-icommunity_id").val();
      var iSubCommunity_ID = $("#user-iSubCommunity_ID").val();
    });

  ');
    ?>
    <?php #Password RESET
    $this->registerJs('
          $("form#forget-password").on("beforeSubmit",function(e){
            var form = $(this);
            if (form.find(".has-error").length) {
              return false;
            }
            $.ajax({
              url: form.attr("action"),
              type: "POST",
              data: form.serialize()+"&vStatus=1",
              dataType: "JSON",
              success: function(res){
                if(res.status == 1) {
                  $("#fpswd").modal("toggle");
                  $("#forgot-password-id").html(res.email);
                  $("#passwordresetrequestform-email").val("");
                  $("#reset-pswd-link").modal("toggle");
                }else{
                  notificationPopup("ERROR", "Something went wrong. Please try again !");
                }
              }
            });
            return false;
          });
        ');
    ?>
    <?php # DOB
    $this->registerJs('
                $(".genderV").on("change",function(e){
                  var genderVal = $(this).val();
                  if(genderVal == "FEMALE") {
                    $("user-dob").datepicker("option","maxDate","' . date('Y-m-d', strtotime('-18 year')) . '");
                    $("user-dob").datepicker("option","yearRange","-70:-18");
                  }
                  else {
                    $("user-dob").datepicker("option","maxDate","' . date('Y-m-d', strtotime('-21 year')) . '");
                    $("user-dob").datepicker("option","yearRange","-70:-21");
                  }
                });

       $(".reset_password").on("click", function() {
        var $this = $(this);
        $this.button("loading");
        setTimeout(function() {
            $this.button("reset");
        }, 15000);
      });
              var enforceModalFocusFn = $.fn.modal.Constructor.prototype.enforceFocus;
              $.fn.modal.Constructor.prototype.enforceFocus = function() {};
              $confModal.on("hidden", function() {
                  $.fn.modal.Constructor.prototype.enforceFocus = enforceModalFocusFn;
              });
              $confModal.modal({ backdrop : false });
              ');
    ?>

<?php } ?>

<?php
$this->registerJs("
$('#user-icommunity_id').keyup(function(e){
var k = e.which;
    //if(k==13){alert('enter was pressed');}

});

$('.nice-select').bind('keyup',function(e) {
/*console.log('=> '+e.which);
var k = e.which;
var input_val = e.which;//String($(this).val());
   var sel = $('select[name=platform]');
console.log('IP => '+input_val);
    $(  this).trigger('change');*/
});


");
?>


