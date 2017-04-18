<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<div class="main-section">
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <?php if ($flag) { ?>
                        <div class="padd-xs mrg-tp-10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- <ul class="list-inline pull-right">
                                         <li><a href="#"><i class="fa fa-angle-left"></i> Previous Profile </a></li>
                                         <li><a href="#">Next Profile <i class="fa fa-angle-right"></i></a></li>
                                     </ul>-->
                                </div>
                            </div>
                        </div>
                        <div class="white-section border-sharp">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="prof-pic">
                                        <div class="drop-effect"></div>
                                        <div class="slider">
                                            <div id="carousel-example-generic" class="carousel slide"
                                                 data-ride="carousel">
                                                <!-- Wrapper for slides -->
                                                <div class="carousel-inner lightgallery">
                                                    <?php
                                                    $PhotoCount = count($PhotoList);
                                                    if ($PhotoCount > 0) {
                                                        foreach ($PhotoList as $K => $V) {
                                                            $SELECTED = '';
                                                            $Photo = Yii::$app->params['thumbnailPrefix'] . '200_' . $V->File_Name;
                                                            $Yes = 'No';
                                                            /*if ($V['Is_Profile_Photo'] == 'YES') {
                                                                $SELECTED = "active";
                                                                $Photo = '200_' . $model->propic;
                                                                $Yes = 'Yes';
                                                            }*/
                                                            ?>
                                                            <div
                                                                class="item <?= ($K == 0) ? 'active' : ''; ?> kp_gallery kp_pic_dis_dwn"
                                                                data-src="<?= CommonHelper::getPhotos('USER', $model->id, $V['File_Name']) ?>"
                                                                id="img_<?= $V['iPhoto_ID'] ?>">
                                                                <?= Html::img(CommonHelper::getPhotos('USER', $model->id, $Photo, 200, '', $Yes, CommonHelper::getVisiblePhoto($model->id, $V['eStatus'])), ['width' => '200', 'alt' => $model->FullName, 'class' => 'img-responsive']); ?>

                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="item active kp_pic_dis_dwn">
                                                            <?= Html::img(CommonHelper::getPhotos('USER', $model->id, 'no-photo.jpg', 140), ['width' => '205', 'height' => '205', 'alt' => 'Profile', 'class' => 'img-responsive']); ?>
                                                        </div>
                                                    <?php } ?>

                                                </div>
                                                <!-- Controls -->
                                                <?php if ($PhotoCount > 1) { ?>
                                                    <a class="left carousel-control" href="#carousel-example-generic"
                                                       data-slide="prev">
                                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                                    </a>
                                                    <a class="right carousel-control" href="#carousel-example-generic"
                                                       data-slide="next">
                                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($PhotoCount > 0) { ?>
                                        <p class="text-right">
                                            <a href="#" data-toggle="modal" data-target="#photo" class="gallery_view">View
                                                Album
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </p>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-9">
                                    <div class="name-panel">
                                        <h2 class="nameplate"><?= $model->FullName; ?>
                                            <span class="font-light">
                                                (<?= CommonHelper::setInputVal($model->Registration_Number, 'text') ?>)
                                            </span>
                                        </h2>

                                        <p>Profile created for <?= $model->Profile_created_for; ?> | Last
                                            online <?= CommonHelper::DateTime($model->LastLoginTime, 7); ?></p>
                                        <!-- TODO: Set Last login time and profile creted by -->
                                    </div>
                                    <?php Pjax::begin(['id' => 'my_index', 'enablePushState' => false]); ?>
                                    <div class="profile-control requests">
                                        <i class="fa fa-spinner fa-spin pink"></i> Loading...
                                        <!--<button type="button" class="btn active sendInterest" data-target="#sendInterest"
                                                data-toggle="modal"> Send Interest <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="btn"> Shortlist <i class="fa fa-list-ul"></i>
                                        </button>
                                        <button type="button" class="btn"> Block <i class="fa fa-ban"></i></button>-->
                                        <!--<button type="button" class="btn"> No <i class="fa fa-thumbs-o-down"></i></button>-->
                                    </div>
                                    <?php Pjax::end(); ?>
                                    <dl class="dl-horizontal mrg-tp-20">
                                        <dt>Personal Details</dt>
                                        <dd><?= CommonHelper::getAge($model->DOB); ?> years,
                                            <?= CommonHelper::setInputVal($model->height->vName, 'text'); ?>
                                            , <?= CommonHelper::setInputVal($model->raashiName->Name, 'text') ?>

                                        <dd>

                                        <dt>Marital Status</dt>
                                        <dd><?= CommonHelper::setInputVal($model->maritalStatusName->vName, 'text') ?></dd>

                                        <dt>Religion Community</dt>
                                        <!--<dd>Hindu, Brahmin</dd>-->
                                        <dd><?= CommonHelper::setInputVal($model->religionName->vName, 'text') . ',' . CommonHelper::setInputVal($model->communityName->vName, 'text') ?></dd>

                                        <dt>Education</dt>
                                        <!--<dd>Masters in Management</dd>-->
                                        <dd><?= CommonHelper::setInputVal($model->educationLevelName->vEducationLevelName, 'text') ?></dd>

                                        <dt>Profession</dt>
                                        <!--<dd>Human Resource Manage</dd>-->
                                        <dd><?= CommonHelper::setInputVal($model->workingAsName->vWorkingAsName, 'text') ?></dd>

                                        <dt>Current Location</dt>
                                        <!--<dd>Pune, India</dd>-->
                                        <dd><?= CommonHelper::setInputVal($model->cityName->vCityName, 'text') . ', ' . CommonHelper::setInputVal($model->countryName->vCountryName, 'text') ?></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="gray-bg">
                                        <ul class="list-inline">
                                            <li><a href="javascript:void(0);" class="send_email"><i class="fa">
                                                        <?= Html::img('@web/images/email.png', ['width' => '', 'height' => '', 'alt' => 'email']); ?></i>
                                                    Send Email (with Profile)</a>
                                            </li>
                                            <li>
                                                <a href="<?= Yii::$app->homeUrl ?>/payment/payment?source=profile_chatnow&uk=<?= $model->Registration_Number ?>"
                                                   target="_blank"><i class="fa">
                                                        <?= Html::img('@web/images/chat.png', ['width' => '', 'height' => '', 'alt' => 'chat']); ?></i>
                                                    Chat Now</a>
                                            </li>
                                            <li>
                                                <!-- data-toggle="modal"
                                                   data-target="#phone_number_modal" -->
                                                <a href="javascript::void(0)" class="phone_number_display">
                                                    <i class="fa">
                                                        <?= Html::img('@web/images/call.png', ['width' => '', 'height' => '', 'alt' => 'call']); ?>
                                                    </i> Call Now</a></li>
                                            <li><a href="#"><i class="fa">
                                                        <?= Html::img('@web/images/lock.png', ['width' => '', 'height' => '', 'alt' => 'lock']); ?>
                                                    </i></a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gray-tabs-block">
                            <div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Detailed
                                            Preferences</a>
                                    </li>
                                    <li role="presentation" class="active pull-right">
                                        <a href="javascript:void(0);" class="send_email"><i class="fa">
                                                <?= Html::img('@web/images/email.png', ['width' => '', 'height' => '', 'alt' => 'email']); ?>
                                            </i> Send Email
                                        </a>
                                    </li>
                                    <li class="pull-right" role="presentation">
                                        <a href="javascript:window.print();"><i class="fa fa-print"></i>
                                            Take a print
                                        </a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">
                                        <div class="inner-block">
                                            <h3><span
                                                    class="heading-icons <?= ($model->Gender == 'MALE') ? 'icon3' : 'icon1'; ?>"></span>
                                                About <?= ($model->Gender == 'MALE') ? 'Him' : 'Her'; ?></h3>

                                            <p>

                                                <?php if ($model->eStatusInOwnWord == \common\models\User::USER_PHOTO_APPROVE) { ?>
                                                <?php if ($model->tYourSelf != '') { ?>
                                                    <?= $model->tYourSelf; ?>
                                                <?php } else { ?>

                                            <div class="notice kp_info"><p>Information Not Available.</p></div>
                                            <?php } ?>
                                            <?php } else { ?>
                                                <div class="notice kp_info"><p>Under Approval.</p></div>
                                            <?php } ?>
                                            </p>
                                        </div>

                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon2"></span> Basic information</h3>
                                            <dl class="dl-horizontal">
                                                <dt>Religion</dt>
                                                <dd><?= $model->religionName->vName; ?>
                                                <dd>
                                                <dt>Community</dt>
                                                <dd><?= $model->communityName->vName; ?></dd>
                                                <dt>Sub Community</dt>
                                                <dd><?= $model->iSubCommunity_ID; ?>
                                                <dd>
                                                    <!--<dd><? /*= $model->subCommunityName->vName; */ ?><dd>-->
                                                <dt>Gotra</dt>
                                                <dd><?= $model->gotraName->vName; ?></dd>
                                                <dt>Marital Status</dt>
                                                <dd><?= $model->maritalStatusName->vName; ?></dd>
                                                <?php if ($model->noc > 0) { ?>
                                                    <dt>Number Of Children</dt>
                                                    <dd><?= $model->noc; ?></dd>
                                                <?php } ?>
                                                <dt>Current Location</dt>
                                                <dd><?= CommonHelper::setInputVal($model->cityName->vCityName, 'text') . ', ' . CommonHelper::setInputVal($model->stateName->vStateName, 'text') . ', ' . CommonHelper::setInputVal($model->countryName->vCountryName, 'text') ?></dd>
                                                <dt>Distict</dt>
                                                <dd><?= $model->districtName->vName; ?></dd>
                                                <!--<dt>Taluks</dt>
                                                    <dd><? /*= $model->talukaName->vName; */ ?></dd>-->
                                                <dt>Area Name</dt>
                                                <dd><?= $model->vAreaName ?></dd>
                                                <dt>Mother Tongue</dt>
                                                <dd><?= CommonHelper::setInputVal($model->motherTongue->Name, 'text') ?></dd>
                                                <!-- TODO: Set Spoken Languages-->
                                                <!--<dt>Language Spoken</dt>
                                                <dd>English, Hindi, Marathi &amp; Telugu</dd>-->

                                            </dl>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon6"></span> Education And Career</h3>
                                            <dl class="dl-horizontal mrg-bt-10">
                                                <dt>Education</dt>
                                                <dd><?= CommonHelper::setInputVal($model->educationLevelName->vEducationLevelName, 'text') ?></dd>
                                                <dt>Profession</dt>
                                                <dd><?= CommonHelper::setInputVal($model->workingAsName->vWorkingAsName, 'text') ?></dd>
                                                <dt>Income</dt>
                                                <dd><?= CommonHelper::setInputVal($model->annualIncome->vAnnualIncome, 'text') ?></dd>

                                            </dl>
                                            <p>To view details about <strong>College and Company</strong> working
                                                at:
                                                <span class="mrg-lt-15"><a href="#">Upgrade Now!</a></span></p>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon2"></span> Lifestyle &amp; Appearance
                                            </h3>
                                            <dl class="dl-horizontal">
                                                <dt>Looks</dt>
                                                <dd><?= CommonHelper::setInputVal($model->skinTone->Name, 'text') ?></dd>
                                                <dt>Appearance</dt>
                                                <dd><?= CommonHelper::setInputVal($model->bodyType->Name, 'text') ?></dd>
                                                <dd>
                                                <dt>Smoking Habit</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vSmoke, 'text') ?></dd>
                                                <dt>Drinking Habit</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vDrink, 'text') ?></dd>
                                                <dt>Spectacles/Lens</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vSpectaclesLens, 'text') ?></dd>
                                                <dt>Food Habbits</dt>
                                                <dd><?= CommonHelper::setInputVal($model->dietName->vName, 'text') ?>
                                                <dd>
                                                    <!--<dt>Looks &amp; Appearance</dt>
                                                    <dd><? /*= CommonHelper::setInputVal($model->skinTone->Name, 'text') . ', ' . CommonHelper::setInputVal($model->bodyType->Name, 'text') */ ?>
                                                    <dd>-->
                                                <dt>Weight</dt>
                                                <dd><?= CommonHelper::setInputVal($model->weight . " KG", 'text') ?></dd>

                                            </dl>
                                        </div>

                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon5"></span> Family Detail</h3>
                                            <dl class="dl-horizontal">

                                                <dt>Father Status</dt>
                                                <dd><?= CommonHelper::setInputVal($model->fatherStatus->vName, 'text') ?>
                                                <dd>
                                                <dt>Father Working As</dt>
                                                <dd><?= CommonHelper::setInputVal($model->fatherStatusId->vWorkingAsName, 'text') ?></dd>
                                                <dt>Mother Status</dt>
                                                <dd><?= CommonHelper::setInputVal($model->motherStatus->vName, 'text') ?>
                                                <dd>
                                                <dt>Mother Working As</dt>
                                                <dd><?= CommonHelper::setInputVal($model->motherStatusId->vWorkingAsName, 'text') ?></dd>
                                                <dt>No of Brothers</dt>
                                                <dd><?= CommonHelper::setInputVal($model->nob, 'text') ?></dd>
                                                <dt>No of Sisters</dt>
                                                <dd><?= $model->nos; ?></dd>
                                                <dt>Country</dt>
                                                <dd><?= CommonHelper::setInputVal($model->countryNameCA->vCountryName, 'text') ?></dd>
                                                <dt>State</dt>
                                                <dd><?= CommonHelper::setInputVal($model->stateNameCA->vStateName, 'text') ?></dd>
                                                <dt>City</dt>
                                                <dd><?= CommonHelper::setInputVal($model->cityNameCA->vCityName, 'text') ?></dd>
                                                <dt>Distict</dt>
                                                <dd><?= CommonHelper::setInputVal($model->districtNameCA->vName, 'text') ?></dd>
                                                <!--<dt>Taluks</dt>
                                                    <dd><? /*= CommonHelper::setInputVal($model->talukaNameCA->vName, 'text') */ ?></dd>-->
                                                <dt>Area Name</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vAreaName, 'text') ?></dd>
                                                <dt>Native Place</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vNativePlaceCA, 'text') ?></dd>
                                                <!--<dt>Parents Residing At</dt>
            <dd><? /*= CommonHelper::setInputVal($model->vParentsResiding, 'text') */ ?></dd>-->
                                                <dt>Family Affluence Level</dt>
                                                <dd><?= CommonHelper::setInputVal($model->familyAffluenceLevelName->Name, 'text') ?></dd>
                                                <dt>Family Type</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vFamilyType, 'text') ?></dd>


                                                <?php
                                                $family_property_array = ArrayHelper::map(CommonHelper::getFamilyPropertyDetail(), 'ID', 'Name');
                                                $family_propertyId_array = explode(',', $model->vFamilyProperty);
                                                $vFamilyProperty = "";
                                                foreach ($family_propertyId_array as $key => $value) {
                                                    $vFamilyProperty .= $family_property_array[$value] . ", ";
                                                }
                                                $vFamilyProperty = trim($vFamilyProperty, ", ")
                                                ?>
                                                <dt>Property Details</dt>
                                                <dd><?= CommonHelper::setInputVal($vFamilyProperty, 'text') ?></dd>
                                                <dt>Additional Information</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vDetailRelative, 'text') ?></dd>
                                            </dl>
                                        </div>

                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon7"></span>Hobbies , Interests &amp;
                                                More
                                            </h3>
                                            <dl class="dl-horizontal">
                                                <dt>Interest</dt>

                                                <?php $InterestArray = \common\models\Interests::getInterestNames(CommonHelper::removeComma($model->InterestID)); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($InterestArray, 'Name'), 'text') ?></dd>
                                                <dt>Favorite Reads</dt>
                                                <?php $ReadsArray = \common\models\FavouriteReads::getReadsNames(CommonHelper::removeComma($model->FavioriteReadID)); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($ReadsArray, 'Name'), 'text') ?></dd>
                                                <dt>Favorite Music</dt>
                                                <?php $MusicArray = \common\models\FavouriteMusic::getMusicNames(CommonHelper::removeComma($model->FaviouriteMusicID)); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($MusicArray, 'Name'), 'text') ?></dd>
                                                <dt>Favorite Cousines</dt>
                                                <?php $CousinesArray = \common\models\FavouriteCousines::getCousinesNames(CommonHelper::removeComma($model->FavouriteCousinesID)); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($CousinesArray, 'Name'), 'text') ?></dd>
                                                <dt>Sports/Fitness and Activities</dt>
                                                <?php $SportsArray = \common\models\SportsFitnActivities::getSportsNames(CommonHelper::removeComma($model->SportsFittnessID)); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($SportsArray, 'Name'), 'text') ?></dd>
                                                <dt>Preferred Dress Style</dt>
                                                <?php $DressArray = \common\models\PreferredDressStyle::getDressNames(CommonHelper::removeComma($model->PreferredDressID)); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($DressArray, 'Name'), 'text') ?></dd>
                                                <dt>Preferred Movie</dt>
                                                <?php $MovieArray = \common\models\PreferredMovies::getMovieNames(CommonHelper::removeComma($model->PreferredMovieID)); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($MovieArray, 'Name'), 'text') ?></dd>
                                            </dl>
                                        </div>


                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon3"></span> Horoscope Details</h3>
                                            <dl class="dl-horizontal">
                                                <dt>Raashi</dt>
                                                <dd><?= CommonHelper::setInputVal($model->raashiName->Name, 'text') ?>
                                                <dd>
                                                <dt>Charan</dt>
                                                <dd><?= CommonHelper::setInputVal($model->charanName->Name, 'text') ?>
                                                <dd>
                                                <dt>Nakshtra</dt>
                                                <dd><?= CommonHelper::setInputVal($model->nakshtraName->Name, 'text') ?>
                                                <dd>
                                                <dt>Nadi</dt>
                                                <dd><?= CommonHelper::setInputVal($model->nadiName->Name, 'text') ?>
                                                <dd>
                                                <dt>Gotra</dt>
                                                <dd><?= CommonHelper::setInputVal($model->gotraName->vName, 'text') ?>
                                                <dd>
                                                <dt>Mangalik</dt>
                                                <dd><?= $model->Mangalik ?></dd>
                                            </dl>
                                            <!--<figcaption class="mrg-tp-30 horo-wrap">
                                                    <div class="horo-info"> For the common interest of members, <br>
                                                        quickly enter your Astro details & unhide her info
                                                        <div class="dropdown">
                                                            <button class="btn btn-link dropdown-toggle" type="button"
                                                                    id="dropdownMenu1" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="true"> Add my
                                                                details <span class="caret"></span></button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                <li><a href="#">Action</a></li>
                                                                <li><a href="#">Another action</a></li>
                                                                <li><a href="#">Something else here</a></li>
                                                                <li role="separator" class="divider"></li>
                                                                <li><a href="#">Separated link</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <? /*= Html::img('@web/images/prof-img.jpg', ['width' => '', 'height' => '', 'alt' => 'email', 'class' => 'img-responsive']); */ ?>
                                                </figcaption>-->
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon8"></span> Match Compatibility</h3>

                                            <p>&nbsp;</p>

                                            <div>
                                                <div class="row">
                                                    <div class="col-sm-2 text-center">
                                                        <?= Html::img(CommonHelper::getPhotos('USER', $model->id, $model->propic, 140), ['class' => 'img-responsive ', 'height' => '', 'alt' => 'Photo',]); ?>
                                                        <br>

                                                        <p><?= ($model->Gender == 'MALE') ? 'His' : 'Her'; ?>
                                                            Preferences</p>
                                                    </div>
                                                    <div class="col-sm-5 text-center"> Your Match Compatibility
                                                        is<br>
                                                        <span class="matchtitle">3/10</span></div>
                                                    <div class="col-sm-2 text-center">
                                                        <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->user->identity->propic, 140), ['class' => 'img-responsive ', 'height' => '', 'alt' => 'Photo',]); ?>
                                                        <br>

                                                        <p>You Match</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="list-inline match-list mrg-tp-30">
                                                <li><span class="text-danger">Age</span><br>
                                                    28 to 32
                                                </li>
                                                <li><span class="text-danger">Height</span><br>
                                                    5' 5"(165cm) to 6' 2"(187cm)
                                                </li>
                                                <li><span class="text-danger">Marital Status </span><br>
                                                    Never Married
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile">
                                        <div class="inner-block">
                                            <h3><span
                                                    class="heading-icons icon2"></span> <?= ($model->Gender == 'MALE') ? 'Him' : 'Her'; ?>
                                                Preferences</h3>
                                            <dl class="dl-horizontal">
                                                <dt>Religion</dt>
                                                <?php $PReligionArray = \common\models\Religion::getReligionNames(CommonHelper::removeComma(implode(",", $PartenersReligionIDs))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PReligionArray, 'vName'), 'text') ?></dd>

                                                <dt>Age From</dt>
                                                <dd><?= CommonHelper::setInputVal($UPP->age_from, 'age') ?>
                                                <dd>
                                                <dt>Age To</dt>
                                                <dd><?= CommonHelper::setInputVal($UPP->age_to, 'age') ?>
                                                <dd>
                                                <dt>Height From</dt>
                                                <dd><?= CommonHelper::setInputVal($UPP->heightFrom->vName, 'text') ?>

                                                <dt>Height To</dt>
                                                <dd><?= CommonHelper::setInputVal($UPP->heightTo->vName, 'text') ?>

                                                <dt>Marital Status</dt>
                                                <?php $PMaritalStatusArray = \common\models\MasterMaritalStatus::getPartnerMaritalStatus(CommonHelper::removeComma(implode(",", $PartnersMaritalPreferences))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PMaritalStatusArray, 'vName'), 'text') ?></dd>


                                                <dt>Mothertoungue</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersMothertongue->partnersMothertongueName->Name, 'text') ?>
                                                <dt>Raashi</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersRaashi->raashiName->Name, 'text') ?>
                                                <dt>Charan</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersCharan->charanName->Name, 'text') ?>
                                                <dt>Nakshtra</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersNakshtra->nakshtraName->Name, 'text') ?>
                                                <dt>Nadi</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersNadi->nadiName->Name, 'text') ?>

                                                <dt>Gotra</dt>
                                                <?php $PGotraArray = \common\models\MasterGotra::getPartnerGotraStatus(CommonHelper::removeComma(implode(",", $PartnersGotraPreferences))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PGotraArray, 'vName'), 'text') ?></dd>

                                                <dt>Mangalik</dt>
                                                <dd><?= CommonHelper::setInputVal($UPP->manglik, 'text') ?>

                                                <dt>Community</dt>
                                                <?php $PCommunityArray = \common\models\MasterCommunity::getCommunityNames(CommonHelper::removeComma(implode(",", $PartnersCommunity))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PCommunityArray, 'vName'), 'text') ?></dd>


                                                <dt>Sub Community</dt>
                                                <?php $PSubCommunityArray = \common\models\MasterCommunitySub::getSubCommunityNames(CommonHelper::removeComma(implode(",", $PartnersSubCommunity))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PSubCommunityArray, 'vName'), 'text') ?></dd>


                                                <dt>Drink</dt>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getValuesFromArray(Yii::$app->params['drinkArray'], $PartnersDrink, 1), 'text') ?></dd>
                                                <dt>Smoke</dt>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getValuesFromArray(Yii::$app->params['smokeArray'], $PartnersSmoke, 1), 'text') ?></dd>
                                                <dt>Skin Tone</dt>
                                                <?php $PBodyTypeArray = \common\models\BodyType::getPartnerBodyType(CommonHelper::removeComma(implode(",", $PartnersBodyType))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PBodyTypeArray, 'Name'), 'text') ?></dd>
                                                <dt>Diet</dt>
                                                <?php $PDietArray = \common\models\MasterDiet::getDietNames(CommonHelper::removeComma(implode(",", $PartnersDiet))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PDietArray, 'vName'), 'text') ?></dd>
                                                <dt>Spectacles</dt>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getValuesFromArray(Yii::$app->params['eyesArray'], $PartnersSpectacles, 1), 'text') ?></dd>
                                            </dl>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon6"></span> Profession Preferences
                                            </h3>
                                            <dl class="dl-horizontal">
                                                <dt>Education Level</dt>
                                                <?php $PEducationLevelArray = \common\models\EducationLevel::getEducationLevelNames(CommonHelper::removeComma(implode(",", $PartenersEduLevelArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PEducationLevelArray, 'vEducationLevelName'), 'text') ?></dd>
                                                <dd>
                                                <dt>Education Field</dt>
                                                <?php $PEducationFieldArray = \common\models\EducationField::getEducationFieldNames(CommonHelper::removeComma(implode(",", $PartenersEduFieldArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PEducationFieldArray, 'vEducationFieldName'), 'text') ?></dd>
                                                <dd>
                                                <dt>Working As</dt>
                                                <?php $PWorkingAsArray = \common\models\WorkingAS::getWorkingAsNames(CommonHelper::removeComma(implode(",", $PartenersWorkingAsArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PWorkingAsArray, 'vWorkingAsName'), 'text') ?></dd>
                                                <dd>
                                                <dt>Working With</dt>
                                                <?php $PWorkingWithArray = \common\models\WorkingWith::getWorkingWithNames(CommonHelper::removeComma(implode(",", $PartenersWorkingWithArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PWorkingWithArray, 'vWorkingWithName'), 'text') ?></dd>
                                                <dd>
                                                <dt>Annual Income From</dt>
                                                <dd><?= CommonHelper::setInputVal($UPP->annualIncomeFrom->vAnnualIncome, 'text') ?></dd>
                                                <dt>Annual Income To</dt>
                                                <dd><?= CommonHelper::setInputVal($UPP->annualIncomeTo->vAnnualIncome, 'text') ?></dd>

                                                <dd>
                                            </dl>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon2"></span>Location Preferences</h3>
                                            <dl class="dl-horizontal">
                                                <dt>City</dt>
                                                <?php $PCityArray = \common\models\Cities::getCityName(CommonHelper::removeComma(implode(",", $PartnersCities))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PCityArray, 'vCityName'), 'text') ?></dd>


                                                <dt>State</dt>
                                                <?php $PStateArray = \common\models\States::getStateName(CommonHelper::removeComma(implode(",", $PartnersStates))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PStateArray, 'vStateName'), 'text') ?></dd>


                                                <dt>Country</dt>
                                                <?php $PCountryArray = \common\models\Countries::getCountryName(CommonHelper::removeComma(implode(",", $PartnersCountries))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PCountryArray, 'vCountryName'), 'text') ?></dd>

                                            </dl>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon5"></span>Family Preferences</h3>
                                            <dl class="dl-horizontal">
                                                <dt>Family Affluence Level</dt>
                                                <?php $PFamilyALevelArray = \common\models\FamilyAffluenceLevel::getFamilyAffluenceLevelName(CommonHelper::removeComma(implode(",", $PartnersFamilyALevel))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PFamilyALevelArray, 'Name'), 'text') ?></dd>
                                                <dt>Family Type</dt>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getValuesFromArray(Yii::$app->params['familyTypeArray'], $PartnersFamilyTypeS, 1), 'text') ?></dd>

                                            </dl>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon7"></span>Hobby/Interest Preferences
                                            </h3>
                                            <dl class="dl-horizontal">

                                                <dt>Interest</dt>
                                                <?php $PInterestArray = \common\models\Interests::getInterestNames(CommonHelper::removeComma(implode(",", $PartenersInterestArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PInterestArray, 'Name'), 'text') ?></dd>

                                                <dt>Favorite Reads</dt>
                                                <?php $PReadsArray = \common\models\FavouriteReads::getReadsNames(CommonHelper::removeComma(implode(",", $PartenersFavReadsArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PReadsArray, 'Name'), 'text') ?></dd>

                                                <dt>Favorite Music</dt>
                                                <?php $PMusicArray = \common\models\FavouriteMusic::getMusicNames(CommonHelper::removeComma(implode(",", $PartenersMusicArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PMusicArray, 'Name'), 'text') ?></dd>

                                                <dt>Favorite Cousines</dt>
                                                <?php $PCousinsArray = \common\models\FavouriteCousines::getCousinesNames(CommonHelper::removeComma(implode(",", $PartenersCousinsArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PCousinsArray, 'Name'), 'text') ?></dd>

                                                <dt>Sports/Fitness and Activities</dt>
                                                <?php $PFitnessArray = \common\models\SportsFitnActivities::getSportsNames(CommonHelper::removeComma(implode(",", $PartenersFitnessArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PFitnessArray, 'Name'), 'text') ?></dd>

                                                <dt>Preferred Dress Style</dt>
                                                <?php $PDressStyleArray = \common\models\PreferredDressStyle::getDressNames(CommonHelper::removeComma(implode(",", $PartenersDressStyleArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PDressStyleArray, 'Name'), 'text') ?></dd>

                                                <dt>Preferred Movie</dt>
                                                <?php $PMoviesArray = \common\models\PreferredMovies::getMovieNames(CommonHelper::removeComma(implode(",", $PartenersMoviesArray))); ?>
                                                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PMoviesArray, 'Name'), 'text') ?></dd>
                                            </dl>

                                        </div>

                                        <div class="inner-block">
                                            <h3>
                                                <span
                                                    class="heading-icons <?= ($model->Gender == 'MALE') ? 'icon1' : 'icon9'; ?>"></span>What
                                                I am looking for</h3>

                                            <p>
                                                <?php if ($UPP->LookingFor != '') { ?>
                                                    <?= CommonHelper::setInputVal($UPP->LookingFor, 'text') ?>
                                                <?php } else { ?>

                                            <div class="notice kp_info"><p>Information Not Available.</p></div>
                                            <?php } ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <!--Phone NUmber -->
                        <div class="modal fade" id="phone_number_modal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <p class="text-center mrg-bt-10">
                                    <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
                                </p>

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span
                                                aria-hidden="true">&times;</span> <span
                                                class="sr-only">Close</span></button>
                                        <h2 class="text-center">Contact Number</h2>
                                    </div>
                                    <div class="modal-body ">
                                        <div class="row">
                                            <div class="text-center">
                                                <div class="col-md-12 col-sm-12">
                                                    <h5 class="mrg-bt-30 mrg-tp-20 font-15 text-dark">
                                                        <strong>
                                                            <i class="fa">
                                                                <?= Html::img('@web/images/call.png', ['width' => '', 'height' => '', 'alt' => 'call']); ?>
                                                            </i> <span
                                                                id="phone_number"></span>
                                                        </strong>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Photo -->
                        <div class="modal fade" id="sendInterest" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel"
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
                                        <div class="row">
                                            <form>
                                                <div class="text-center">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="fb-profile-text mrg-bt-30 text-dark">
                                                            <h1 id="p_u_name"><?= $model->FullName; ?>
                                                                <span class="sub-text" id="p_u_rgno">
                                                                    (<?= CommonHelper::setInputVal($model->Registration_Number, 'text') ?>
                                                                    )
                                                                </span>
                                                            </h1>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <?= Html::img(CommonHelper::getPhotos('USER', $model->id, '120' . $model->propic, 120, '', 'Yes', CommonHelper::getVisiblePhoto($model->id, $model->eStatusPhotoModify)), ['width' => '', 'height' => '120', 'alt' => 'Profile', 'class' => '']); ?>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <h6 class="mrg-bt-30 mrg-tp-20 font-15 text-dark"><strong>Request
                                                                the member to add
                                                                the
                                                                following
                                                                details</strong></h6>

                                                        <div class="checkbox mrg-tp-0 profile-control">
                                                            <input id="Photo" type="checkbox" name="Photo"
                                                                   value="check1">
                                                            <label for="Photo" class="control-label">Photo</label>
                                                            <input id="Horoscope" type="checkbox" name="Horoscope"
                                                                   value="check1">
                                                            <label for="Horoscope"
                                                                   class="control-label">Horoscope</label>
                                                            <button type="button" class="btn active send_request">
                                                                Send Interest
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                    <!-- Modal Footer -->
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="operationrequest" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel"
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
                                        <h4 class="text-center">Please wait..</h4>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form>
                                            <div class="text-center">
                                                <div class="checkbox mrg-tp-0 profile-control">
                                                    <input id="Photo" type="checkbox" name="Photo" value="check1">
                                                    <label for="Photo" class="control-label">Photo</label>
                                                    <input id="Horoscope" type="checkbox" name="Horoscope"
                                                           value="check1">
                                                    <label for="Horoscope" class="control-label">Horoscope</label>
                                                    <button type="button" class="btn active send_request"> Send
                                                        Interest
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="well">
                                                <h6 class="font-15 text-dark"><strong> More Similar
                                                        Profiles</strong> <a title="View All"
                                                                             class="pull-right"
                                                                             href="#">View
                                                        All</a>
                                                </h6>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="bg-white">
                                                            <ul class="list-unstyled ad-prof user-list">
                                                                <li> <span class="imgarea">

                                                <br>
                      <input id="Photo1" type="checkbox" name="Photo" value="check1">
                      </span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">Pallavi Jadhav <br>
                                                                            KP123WERT</a>
                      <p>27yrs , 5’ 1” / 155 cms</p>
                      <div class="item"><a role="button" class="btn btn-info pull-left" href="#">Interest Send <i
                                  class="fa fa-heart"></i></a></div>
                      </span>

                                                                    <div class="clearfix"></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="bg-white">
                                                            <ul class="list-unstyled ad-prof user-list">
                                                                <li> <span
                                                                        class="imgarea"> <?= Html::img('@web/images/profile4.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?>
                                                                        <br>
                      <input id="Photo2" type="checkbox" name="Photo" value="check1">
                      </span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">Pallavi Jadhav <br>
                                                                            KP123WERT</a>
                      <p>27yrs , 5’ 1” / 155 cms</p>
                      <div class="item"><a role="button" class="btn btn-link pull-left" href="#">Interest Send <i
                                  class="fa fa-heart"></i></a></div>
                      </span>

                                                                    <div class="clearfix"></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="bg-white">
                                                            <ul class="list-unstyled ad-prof user-list">
                                                                <li> <span
                                                                        class="imgarea"> <?= Html::img('@web/images/profile4.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?>
                                                                        <br>
                      <input id="Photo1" type="checkbox" name="Photo" value="check1">
                      </span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">Pallavi Jadhav <br>
                                                                            KP123WERT</a>
                      <p>27yrs , 5’ 1” / 155 cms</p>
                      <div class="item"><a role="button" class="btn btn-info pull-left" href="#">Interest Send <i
                                  class="fa fa-heart"></i></a></div>
                      </span>

                                                                    <div class="clearfix"></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="bg-white">
                                                            <ul class="list-unstyled ad-prof user-list">
                                                                <li> <span
                                                                        class="imgarea"> <?= Html::img('@web/images/profile4.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?>
                                                                        <br>
                      <input id="Photo2" type="checkbox" name="Photo" value="check1">
                      </span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">Pallavi Jadhav <br>
                                                                            KP123WERT</a>
                      <p>27yrs , 5’ 1” / 155 cms</p>
                      <div class="item"><a role="button" class="btn btn-link pull-left" href="#">Interest Send <i
                                  class="fa fa-heart"></i></a></div>
                      </span>

                                                                    <div class="clearfix"></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="checkbox" style="margin:0">
                                                <input id="allinter" type="checkbox" name="Photo" value="check1">
                                                <label for="allinter" class="control-label"><a href="#">Send
                                                        Interest to All</a></label>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal Footer -->
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="padd-xs mrg-tp-10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <ul class="list-inline pull-right">
                                        <li><a href="<?= Yii::$app->homeUrl ?>"><i class="fa fa-angle-left"></i>
                                                Back to
                                                Home Page </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="white-section border-sharp">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="name-panel">
                                        <div class="ad-title"><h3><?= $Title ?></h3></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="notice kp_warning"><p><?= $Message ?></p></div>
                                    <ul class="list-inline pull-right">
                                        <li><a href="<?= Yii::$app->homeUrl ?>user/my-profile"><i
                                                    class="fa fa-angle-left"></i> My Profile </a></li>
                                        <li><a href="<?= Yii::$app->homeUrl ?>user/dashboard">My Dashboard <i
                                                    class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    <?php } ?>

                </div>
                <!--<div class="col-md-3 col-sm-12">
                    <div class="row">
                        <div class="bg-white aside padd-20">
                            <div class="ad-title">Similar Profiles</div>
                            <ul class="list-unstyled ad-prof">
                                <li><span
                                        class="imgarea"> <? /*= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); */ ?></span> <span
                                        class="img-desc">
                                <p class="name"><strong>Ishita J</strong></p>
                                <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                                    </span>

                                    <div class="clearfix"></div>
                                </li>
                                <li><span
                                        class="imgarea"> <? /*= Html::img('@web/images/profile2.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); */ ?></span> <span
                                        class="img-desc">
                  <p class="name"><strong>Arathi B</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>

                                    <div class="clearfix"></div>
                                </li>
                                <li><span
                                        class="imgarea"> <? /*= Html::img('@web/images/profile3.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); */ ?></span> <span
                                        class="img-desc">
                  <p class="name"><strong>Arathi B</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>

                                    <div class="clearfix"></div>
                                </li>
                            </ul>
                            <span class="pull-right"><a href="#" class="text-right">See All <i
                                        class="fa fa-angle-right"></i></a></span>

                            <div class="clearfix"></div>
                            <div class="border"></div>
                            <div class="ad-title">Success Stories</div>
                            <div class="mrg-bt-10">
                                <? /*= Html::img('@web/images/image1.jpg', ['width' => '', 'height' => '', 'alt' => 'Image', 'class' => 'img-responsive']); */ ?>
                            </div>
                            <span class="pull-right"><a href="#" class="text-right">Read All Stories <i
                                        class="fa fa-angle-right"></i></a></span>

                            <div class="clearfix"></div>
                            <div class="border"></div>
                            <div class="ad-title">Interest Accepted</div>
                            <ul class="list-unstyled ad-prof">
                                <li> <span class="imgarea">
                    <? /*= Html::img('@web/images/profile4.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); */ ?>
                  </span> <span class="img-desc">
                  <p class="name">Mrunmal Sawant</p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>

                                    <div class="clearfix"></div>
                                </li>
                                <li> <span class="imgarea">
                    <? /*= Html::img('@web/images/heart.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); */ ?>
                    </span> <span class="img-desc">
                  <td width="87%" align="left" valign="top"><p><strong>Mrunmal Sawant</strong></p>

                      <p>has accepted your interest and would like to hear from you.</p></td>
                  </span>

                                    <div class="clearfix"></div>
                                </li>
                            </ul>
                            <span class="pull-right"><a href="#" class="text-right">Get in touch with her <i
                                        class="fa fa-angle-right"></i></a></span>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>-->
                <!-- <? /*= $this->render('/layouts/parts/_rightbar.php', ['SimilarProfile' => $SimilarProfile, 'aside' => 1]) */ ?> -->
            </div>
            <?php if ($flag) { ?>
                <div class="mrg-bt-10">
                    <div class="row">
                        <div class="col-sm-9">
                            <!--<div class="pull-left"><a href="#">Back to Top</a></div>
                            <div class="pull-right"><a href="#"> <i class="fa fa-angle-left"></i> Previous Profile</a>
                                &nbsp; &nbsp; &nbsp; &nbsp; <a href="#">Next Profile <i class="fa fa-angle-right"></i>
                                </a></div>-->
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</div>


<script language="javascript" type="text/javascript">
    var userid = "<?=base64_encode(Yii::$app->user->identity->id)?>";
</script>


<?php
$this->registerJs('
    $(".gallery_view").click(function(){
        $(".kp_gallery").click();
        setTimeout(function(){ gallery_disable_right(); }, 500);
    });
var formData = new FormData();
    formData.append("ToUserId", "' . $model->id . '");
    formData.append("UserId", ' . $model->id . ');
$(document).on("click",".send_email",function(e){
        loaderStart();
         $.ajax({
                        url: "send-email-profile",
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
        loaderStart();
        formData.append("Action", "SEND_INTEREST");
        sendRequest("' . Url::to(['user/user-request']) . '",".requests",formData);
    });
    $(document).on("click",".shortlistUser",function(e){
        loaderStart();
        formData.append("Action", "SHORTLIST_USER");
        formData.append("Page",  "PROFILE");
        formData.append("Name", $(this).data("name"));
        sendRequest("' . Url::to(['user/user-request']) . '",".requests",formData);
    });
    $(document).on("click",".a_b_d",function(e){
      Pace.restart();
      loaderStart();
      var formData = new FormData();
      formData.append("ToUserId", $(this).data("id"));
      formData.append("Name", $(".to_name").text());
      formData.append("RGNumber", $(".to_rg_number").text());
      formData.append("Action",  $(this).data("type"));
      formData.append("Page",  "PROFILE");
      //sendRequestDashboard("' . Url::to(['user/user-request']) . '",".requests","R_A_D_B",$(this).data("parentid"),formData);
      sendRequest("' . Url::to(['user/user-request']) . '",".requests",formData);
    });
    sendRequest("' . Url::to(['user/user-request']) . '",".requests",formData);



    $(document).on("click",".phone_number_display",function(e){
          $("#phone_number").html("");
         $.ajax({
                        url: "phone-number-display",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                           // loaderStop();
                            var DataObject = JSON.parse(data);
                            if(DataObject.STATUS == "S"){
                                    var NUMBER = DataObject.NUMBER;
                                    $("#phone_number_modal").modal();
                                    $("#phone_number").html(NUMBER);
                            }else{
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                            }

                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                                notificationPopup(\'ERROR\', \'Something went wrong. Please try again !\', \'Error\');
                        }
         });

    });
');
?>


<?php require_once __DIR__ . '/_useroperation.php'; ?>


<link href='<?= Yii::$app->request->baseUrl ?>/plugings/gallery/css/lightgallery.css' rel='stylesheet' type='text/css'>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/gallery/js/lightgallery.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/gallery/js/lg-fullscreen.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/gallery/js/lg-thumbnail.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/gallery/js/lg-video.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/gallery/js/lg-autoplay.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/gallery/js/lg-zoom.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/gallery/js/lg-hash.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/gallery/js/lg-pager.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
