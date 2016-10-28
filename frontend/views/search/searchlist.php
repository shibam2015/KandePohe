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
                                <div class="dropdown drp-lg">
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
                                </div>
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
                                                <p><?= Yii::$app->params['noRecordsFoundInSearchList'] ?></p></div>
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
                                                    <h2 class="nameplate"><?= $SV->FullName; ?>
                                                        <span class="font-light">(<?= $SV->Registration_Number ?>
                                                            )</span> <span class="premium"></span></h2>
                                                    <?php $USER_PHONE = \common\models\User::weightedCheck(8); ?>
                                                    <p>Profile created by <?= $SV->Profile_created_for; ?> | Last
                                                        online <?= CommonHelper::DateTime($SV->LastLoginTime, 28); ?> | <span
                                                            class="pager-icon">

                              <a><?php if ($USER_PHONE) { ?>class="active"<?php } ?><i
                                      class="fa fa-mobile"></i> <span
                                      class="badge"><i
                                          class="fa fa-check"></i></span></a></p>
                                                </div>
                                                <dl class="dl-horizontal mrg-tp-20">
                                                    <dt>Personal Details</dt>
                                                    <dd><?= CommonHelper::getAge($SV->DOB); ?>
                                                        yrs,<?= CommonHelper::setInputVal($SV->height->vName, 'text'); ?>
                                                        , Capricorn
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
                                        <div class="row gray-bg">
                                            <div class="col-sm-12">
                                                <div class="profile-control-vertical">
                                                    <ul class="list-unstyled pull-right">
                                                        <li><a href="#">Shortlist <i class="fa fa-list-ul"></i></a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#sendInterest">Send
                                                                Interest <i class="fa fa-heart-o"></i></a></li>
                                                        <li><a href="#" data-toggle="modal" class="sendmail"
                                                               data-target="#sendMail">Send Email <i
                                                                    class="fa fa-envelope-o"></i></a></li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>


                                <div class="mrg-bt-10 text-center">
                                    <nav>
                                        <ul class="pagination pagination-lg">
                                            <li class="page-item first"><a class="page-link" href="#"
                                                                           aria-label="Previous"> <span
                                                        aria-hidden="true">Previous</span> <span class="sr-only">Previous</span>
                                                </a></li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                                            <li class="page-item"><a class="page-link" href="#">6</a></li>
                                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                                            <li class="page-item last"><a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">Next</span> <span
                                                        class="sr-only">Next</span> </a></li>
                                        </ul>
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
                    <h2 class="text-center">Please Wait</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mrg-tp-20">
                            <i class="fa fa-spinner fa-spin pink"></i> Loading Information...
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/slider.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/cover/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php

$this->registerJs('
$(document).on("click",".send_request",function(e){

});
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
$(document).on("click",".sendmail",function(e){
      var formData = new FormData();
      formData.append("ToUserId", $(this).data("id"));
      sendRequest("' . Url::to(['search/search-send-message']) . '",".send_message",formData);;
    });
');
?>
