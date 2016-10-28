<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\components\CommonHelper;
use common\components\MessageHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

$id = 0;
$PROFILE_COMPLETENESS = 50;

$HOME_URL = Yii::getAlias('@web') . "/";
$HOME_URL_SITE = Yii::getAlias('@web') . "/site/";
$UPLOAD_DIR = Yii::getAlias('@frontend') . '/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') . '/web/';
?>

<div class="main-section">
    <?php
    if (!Yii::$app->user->isGuest) {
        echo $this->render('/layouts/parts/_headerafterlogin');
    } else {
        echo $this->render('/layouts/parts/_headerregister.php');
    }
    ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-7">
                        <div class="sidebar1">
                            <div class="mrg-tp-20">
                                <!--<div class="dropdown drp-lg">
                                    <button class="btn gray-filter dropdown-toggle" id="filter-toggle" type="button"
                                            aria-haspopup="true" aria-expanded="true"> Filters <i
                                            class="fa indicator fa-angle-down"></i></button>
                                    <div class="open-div">
                                        <ul class="list-inline">
                                            <li>
                                                <div id="age" class="filter-show">
                                                    <label for="age">Age</label>
                                                    <select id="age" class="select">
                                                        <option value="option 1">18</option>
                                                        <option value="option 2">19</option>
                                                        <option value="option 3">20</option>
                                                        <option value="option 1">20</option>
                                                        <option value="option 2">21</option>
                                                        <option value="option 3">30</option>
                                                    </select>
                                                    <select id="ageTo" class="select">
                                                        <option value="option 1">18</option>
                                                        <option value="option 2">19</option>
                                                        <option value="option 3">20</option>
                                                        <option value="option 1">20</option>
                                                        <option value="option 2">21</option>
                                                        <option value="option 3">30</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li>
                                                <label for="Community">Community</label>
                                                <select id="Community" class="select">
                                                    <option value="option 1">Community1</option>
                                                    <option value="option 2">Community2</option>
                                                    <option value="option 3">Community3</option>
                                                </select>
                                            </li>
                                            <li>
                                                <label for="SubCommunity">Sub-Community</label>
                                                <select id="SubCommunity" class="select">
                                                    <option value="option 1">SubCommunity1</option>
                                                    <option value="option 2">SubCommunity2</option>
                                                    <option value="option 3">SubCommunity3</option>
                                                </select>
                                            </li>
                                            <li>
                                                <label for="caste">Caste</label>
                                                <select id="caste" class="select">
                                                    <option value="option 1">caste1</option>
                                                    <option value="option 2">caste2</option>
                                                    <option value="option 3">caste3</option>
                                                </select>
                                            </li>
                                            <li>
                                                <label for="Subcaste">Sub Caste</label>
                                                <select id="Subcaste" class="select">
                                                    <option value="option 1">Subcaste1</option>
                                                    <option value="option 2">Subcaste2</option>
                                                    <option value="option 3">Subcaste3</option>
                                                </select>
                                            </li>
                                            <li>
                                                <label for="height">Height</label>
                                                <input type="text" class="" placeholder="5ft 5">
                                            </li>
                                            <li>
                                                <label for="MaritalStatus">Marital Status</label>
                                                <select id="Subcaste" class="select">
                                                    <option value="option 1">Doesn't Matter</option>
                                                    <option value="option 2">Divorced</option>
                                                    <option value="option 3">Widowed</option>
                                                    <option value="option 3">Never Married</option>
                                                    <option value="option 3">Awaiting Divorce</option>
                                                    <option value="option 3">Annulled</option>
                                                </select>
                                            </li>
                                            <div>
                                                <label for="amount">Area:</label>

                                                <div id="slider-range"></div>
                                                <input type="text" id="amount" readonly>
                                            </div>
                                        </ul>
                                        <input type="button" name="button" value="search" class="btn btn-primary">
                                        <input type="reset" name="button" value="Reset" class="btn btn-primary">
                                    </div>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li><a href="#">Test 1</a></li>
                                        <li><a href="#">Test 2</a></li>
                                        <li><a href="#">Test 3</a></li>
                                    </ul>
                                </div>-->
                                <div class="gray-bg mrg-tp-5">
                                    <div class="matches pull-left padd-10"><span> Matches Found: <span
                                                class="orange-text"><?= $TotalRecords ?></span> </span></div>
                                    <div class="pull-right filter-small padd-10">
                                        <ul class="list-inline">
                                            <li><a href="#">Search By ID</a></li>
                                            <li><a href="#">Save Search</a></li>
                                            <li><a href="#">Modify Search</a></li>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <?php if ($TotalRecords == 0) { ?>
                                <div class="white-section listing border-sharp mrg-tp-10">
                                    <div class="row mrg-tp-10">
                                        <div class="col-md-12">
                                            <div class="notice kp_info">
                                                <p><?= Yii::$app->params['noRecordsFoundInSearchList'] ?></p>
                                            </div>
                                            <div class="clearfix"></div>
                                <span class="pull-right"><a href="<?= Yii::$app->homeUrl ?>" class="text-right">Back To
                                        Home Page<i class="fa fa-angle-right"></i></a></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <?php foreach ($Model as $SK => $SV) { ?>
                                    <div
                                        class="white-section <?= ($SK == 0) ? 'listing' : ''; ?> border-sharp mrg-tp-10">
                                        <div class="row mrg-bt-20">
                                            <div class="col-sm-12">
                                                <div class="featured-prof"><span class="featured-icon"></span> <span
                                                        class="thead">Featured Profile <a href="#" data-toggle="tooltip"
                                                                                          data-placement="right"
                                                                                          title=""
                                                                                          data-original-title="This is where the help text will appear when the mouse hovers over the help icon">
                                                            <?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => '21']); ?>
                                                        </a></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="prof-pic">
                                                    <div class="drop-effect"></div>
                                                    <div class="slider">
                                                        <div id="carousel-example-generic" class="carousel slide"
                                                             data-ride="carousel">
                                                            <!-- Wrapper for slides -->
                                                            <div class="carousel-inner">
                                                                <?php
                                                                if (is_array($Photos[$SV->id])) {
                                                                    foreach ($Photos[$SV->id] as $K => $V) {
                                                                        #CommonHelper::pr($V);
                                                                        #echo "<br> PHOTOT => ".CommonHelper::getPhotos('USER', $SV->id, $V['File_Name'], 140);
                                                                        $SELECTED = '';
                                                                        if ($V['Is_Profile_Photo'] == 'YES') {
                                                                            $SELECTED = "active";
                                                                        } ?>
                                                                        <div
                                                                            class="item <?= ($K == 0) ? 'active' : ''; ?>">
                                                                            <?= Html::img(CommonHelper::getPhotos('USER', $SV->id, $V['File_Name'], 140), ['width' => '205', 'height' => '205', 'alt' => 'Profile', 'class' => 'img-responsive']); ?>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                } else { ?>
                                                                    <div class="item active">
                                                                        <?= Html::img($Photos[$SV->id], ['width' => '205', 'height' => '205', 'alt' => 'Profile', 'class' => 'img-responsive item']); ?>
                                                                    </div>
                                                                <?php }
                                                                ?>
                                                            </div>
                                                            <!-- Controls -->
                                                            <a class="left carousel-control"
                                                               href="#carousel-example-generic" data-slide="prev"> <span
                                                                    class="glyphicon glyphicon-chevron-left"></span>
                                                            </a> <a class="right carousel-control"
                                                                    href="#carousel-example-generic" data-slide="next">
                                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                                            </a></div>
                                                    </div>
                                                </div>
                                                <?php if (count($SV) > 0) { ?>
                                                    <p class="text-right"><a href="#" data-toggle="modal"
                                                                             data-target="#photo">View
                                                            Album <i class="fa fa-angle-right"></i></a></p>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="name-panel">
                                                    <h2 class="nameplate">
                                                        <?php
                                                        if (!Yii::$app->user->isGuest) { ?>
                                                            <a href="<?= Yii::$app->homeUrl ?>user/profile?uk=<?= $Value->fromUserInfo->Registration_Number ?>&source=profile_viewed_by"
                                                               class="name"
                                                               title="<?= $Value->fromUserInfo->Registration_Number ?>">
                                                                <?= $SV->FullName; ?>
                                                            </a>
                                                        <?php } else { ?>
                                                            <?= $SV->FullName; ?>
                                                        <?php } ?>
                                                        <span class="font-light">(<?= $SV->Registration_Number ?>
                                                            )</span>
                                                        <?php
                                                        #$USER_FACEBOOK = \common\models\User::weightedCheck(11);
                                                        $USER_PHONE = \common\models\User::weightedCheck(8);
                                                        $USER_EMAIL = \common\models\User::weightedCheck(9);
                                                        $USER_APPROVED = \common\models\User::weightedCheck(10);
                                                        if ($USER_PHONE && $USER_EMAIL && $USER_APPROVED) {
                                                            ?>
                                                            <span class="premium"></span>
                                                        <?php } ?>
                                                    </h2>
                                                    <?php $USER_PHONE = \common\models\User::weightedCheck(8); ?>
                                                    <p>Profile created by <?= $SV->Profile_created_for; ?> | Last
                                                        online <?= CommonHelper::DateTime($SV->LastLoginTime, 28); ?> |
                                                        <span class="pager-icon">
                                                    <a href="javascript:void(0)">
                                                        <i class="fa fa-mobile"></i>
                                                      <span
                                                          class="badge <?php if ($SV->ePhoneVerifiedStatus != 'Yes') { ?>badge1<?php } ?>">
                                                          <i class="fa fa-check"></i>
                                                      </span>
                                                    </a>
                                                            </span>
                                                    </p>
                                                </div>
                                                <dl class="dl-horizontal mrg-tp-20">
                                                    <dt>Personal Details</dt>
                                                    <dd><?= CommonHelper::getAge($SV->DOB); ?>
                                                        yrs, <?= CommonHelper::setInputVal($SV->height->vName, 'text'); ?>
                                                        <?= ($SV->RaashiId > 0) ? ", " . CommonHelper::setInputVal($SV->raashiName->Name, 'text') : ''; ?>
                                                    </dd>
                                                    <dt>Marital Status</dt>
                                                    <dd><?= CommonHelper::setInputVal($SV->maritalStatusName->vName, 'text') ?></dd>
                                                    <dt>Religion Community</dt>
                                                    <dd><?= CommonHelper::setInputVal($SV->religionName->vName, 'text') . ',' . CommonHelper::setInputVal($SV->communityName->vName, 'text') ?></dd>
                                                    <dt>Education</dt>
                                                    <dd><?= CommonHelper::setInputVal($SV->educationLevelName->vEducationLevelName, 'text') ?></dd>
                                                    <dt>Profession</dt>
                                                    <dd><?= CommonHelper::setInputVal($SV->workingAsName->vWorkingAsName, 'text') ?></dd>
                                                    <dt>Current Location</dt>
                                                    <dd><?= CommonHelper::setInputVal($SV->cityName->vCityName, 'text') . ', ' . CommonHelper::setInputVal($SV->countryName->vCountryName, 'text') ?></dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <?php

                                        if (!Yii::$app->user->isGuest) {
                                            if ($SV->Gender != Yii::$app->user->identity->Gender) { ?>
                                                <div class="row gray-bg">
                                                    <div class="col-sm-12">
                                                        <div class="profile-control-vertical">
                                                            <ul class="list-unstyled pull-right">
                                                                <li><a href="#">Shortlist <i class="fa fa-list-ul"></i></a>
                                                                </li>
                                                                <li class="s__<?= $SV->id ?>">
                                                                    <?php
                                                                    $Check = \common\models\UserRequest::checkSendInterest(Yii::$app->user->identity->id, $SV->id);
                                                                    if ($Check->from_user_id == Yii::$app->user->identity->id && $Check->to_user_id == $SV->id && $Check->send_request_status == "Yes") {
                                                                        ?>
                                                                        <a href="javascript:void(0)" class="isent"
                                                                           role="button">Interest Sent <i
                                                                                class="fa fa-heart"></i></a>
                                                                    <?php } else { ?>
                                                                        <a href="javascript:void(0)"
                                                                           class="sendinterestpopup"
                                                                           role="button"
                                                                           data-target="#sendInterest"
                                                                           data-toggle="modal"
                                                                           data-id="<?= $SV->id ?>"
                                                                           data-name="<?= $SV->FullName ?>"
                                                                           data-rgnumber="<?= $SV->Registration_Number ?>">Send
                                                                            Interest
                                                                            <i class="fa fa-heart-o"></i>
                                                                        </a>
                                                                    <?php } ?>
                                                                </li>
                                                                <li><a href="#" data-toggle="modal" class="send_email"
                                                                       <?php if (Yii::$app->user->isGuest) { ?>data-target="#sendMail"<?php } else { ?> data-id="<?= $SV->id ?>" <?php } ?>>Send
                                                                        Email <i
                                                                            class="fa fa-envelope-o"></i></a></li>

                                                            </ul>
                                                        </div>
                                                </div>
                                            </div>

                                        <?php } ?>

                                        <?php } else { ?>
                                            <div class="row gray-bg">
                                                <div class="col-sm-12">
                                                    <div class="profile-control-vertical">
                                                        <ul class="list-unstyled pull-right">
                                                            <li><a href="javascript:void(0)" class="send_email"
                                                                   role="button"
                                                                   data-target="#sendMail" data-toggle="modal"
                                                                    >Shortlist <i class="fa fa-list-ul"></i></a></li>
                                                            <li class="s__<?= $SV->id ?>">
                                                                <a href="javascript:void(0)" class="send_email"
                                                                   role="button"
                                                                   data-target="#sendMail" data-toggle="modal"
                                                                    >Send
                                                                    Interest
                                                                    <i class="fa fa-heart-o"></i>
                                                                </a>

                                                            </li>
                                                            <li><a href="#" data-toggle="modal" class="send_email"
                                                                   data-target="#sendMail">Send
                                                                    Email <i
                                                                        class="fa fa-envelope-o"></i></a></li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>


                                <div class="mrg-bt-10 text-center">
                                    <nav>
                                        <?php require_once(__DIR__ . '\pagination.php'); ?>
                                    </nav>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 mrg-tp-20">
                        <div class="map">
                            <iframe width="100%" height="1000" frameborder="0" scrolling="no" marginheight="0"
                                    marginwidth="0"
                                    src="https://maps.google.co.uk/maps?f=q&source=s_q&hl=en&geocode=&q=15+Springfield+Way,+Hythe,+CT21+5SH&aq=t&sll=52.8382,-2.327815&sspn=8.047465,13.666992&ie=UTF8&hq=&hnear=15+Springfield+Way,+Hythe+CT21+5SH,+United+Kingdom&t=m&z=14&ll=51.077429,1.121722&output=embed"></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
<div class="modal fade" id="photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center"> Photo Gallery</h2>
                <!--<div class="profile-control photo-btn">
                    <button class="btn " type="button"> Upload Video or Photo</button>
                    <button class="btn active" type="button"> Choose from Photos</button>
                    <button class="btn" type="button"> Albums</button>
                </div>-->
            </div>
            <!-- Modal Body -->
            <div class="modal-body photo-gallery">
                <div class="choose-photo">
                    <div class="row" id="profile_list_popup">
                        <?php
                        if (count($PhotoList) > 0) {
                            foreach ($PhotoList as $K => $V) {
                                ?>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <?php $SELECTED = '';
                                    if ($V['Is_Profile_Photo'] == 'YES') {
                                        $SELECTED = "selected";
                                    } ?>
                                    <a href="javascript:void(0)" class="pull-left"
                                       data-id="<?= $V['iPhoto_ID'] ?>">
                                        <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name'], 140), ['class' => 'img-responsive ' . $SELECTED, 'height' => '140', 'alt' => 'Photo' . $K, 'style' => 'height:140px;']); ?>
                                    </a>
                                </div>
                            <?php }
                        } else {
                            ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                <p> No Photos Available</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sendMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>
        <?php Pjax::begin(['id' => 'my_index', 'enablePushState' => false]); ?>
        <div class="send_message">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span></button>
                    <?php
                    if (!Yii::$app->user->isGuest) { ?>
                        <h2 class="text-center">Please Wait</h2>
                    <?php } else { ?>
                        <h2 class="text-center">Information</h2>
                    <?php } ?>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mrg-tp-10 ">
                            <?php
                            if (!Yii::$app->user->isGuest) { ?>
                            <i class="fa fa-spinner fa-spin pink"></i> Loading Information...
                            <?php } else { ?>
                                <div class="notice kp_warning marg-l"><p><?= Yii::$app->params['loginFirst'] ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php if (!Yii::$app->user->isGuest) { ?>
    <div class="modal fade" id="sendInterest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10">
                <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
            </p>

            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span>
                    </button>
                    <h4 class="text-center"> Send Interest </h4>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form>
                        <div class="text-center">
                            <!--<p class="mrg-bt-10 font-15"><span class="text-success"><strong>&#10003;</strong></span> Your interest has been sent successfully to</p>-->
                            <div class="fb-profile-text mrg-bt-30 text-dark">
                                <h1 id="to_name"></h1>(<span class="sub-text mrg-tp-10" id="to_rg_number"></span>)
                            </div>
                            <!--<h6 class="mrg-bt-30 font-15 text-dark"><strong>Request the member to add the following details</strong></h6>-->

                            <div class="checkbox mrg-tp-0 profile-control">
                                <!--<input id="Photo" type="checkbox" name="Photo" value="check1">
                                <label for="Photo" class="control-label">Photo</label>
                                <input id="Horoscope" type="checkbox" name="Horoscope" value="check1">
                                <label for="Horoscope" class="control-label">Horoscope</label>-->
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <button type="button" class="btn active pull-right send_request" data-id=""
                                                data-parentid=""> Send
                                            Interest
                                        </button>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Back</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <!-- Modal Footer -->
            </div>
        </div>
    </div>
<?php } ?>
<?php
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/slider.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/cover/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php

$this->registerJs('
       jQuery(document).ready(function($) {

        $("#myCarousel").carousel({
                interval: 5000
        });

        $("#carousel-text").html($("#slide-content-0").html());

        //Handles the carousel thumbnails
       $("[id^=carousel-selector-]").click( function(){
         var id = this.id.substr(this.id.lastIndexOf("-") + 1);
         var id = parseInt(id);
         $("#myCarousel").carousel(id);
       });


        // When the carousel slides, auto update the text
        $("#myCarousel").on("slid.bs.carousel", function (e) {
          var id = $(".item.active").data("slide-number");
          $("#carousel-text").html($("#slide-content-"+id).html());
        });
});
    $(document).on("click",".send_email",function(e){
        var formData = new FormData();
        formData.append("ToUserId", $(this).data("id"));
        formData.append("UserId", ' . Yii::$app->user->identity->id . ');
        loaderStart();
         $.ajax({
                        url: "' . Yii::$app->homeUrl . 'user/send-email-profile",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            loaderStop();
                            var DataObject = JSON.parse(data);
                            notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                                notificationPopup(\'ERROR\', \'Something went wrong. Please try again !\', \'Error\');
                                loaderStop();
                        }
         });

    });
    $(document).on("click",".send_request",function(e){
      Pace.restart();
      loaderStart();
      var formData = new FormData();
      formData.append("ToUserId", $(this).data("id"));
      formData.append("Action", "SEND_INTEREST");
      sendRequestDashboard("' . Url::to(['user/send-int-dashboard']) . '",".requests","SL",$(this).data("parentid"),formData);
    });
');
?>
