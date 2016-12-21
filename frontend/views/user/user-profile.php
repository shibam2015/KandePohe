<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
use yii\captcha\Captcha;
use yii\bootstrap\Alert;   // For Alert Notification
use yii\web\View;
use kartik\editable\Editable;
use yii\widgets\Pjax;

/*$religion_data = CommonHelper::getReligion();
$community_data = CommonHelper::getCommunity();*/
$id = 0;
$PROFILE_COMPLETENESS = 0;
$PROFILE_COMPLETENESS = $this->context->profileCompleteness($model->completed_step);
$HOME_URL = Yii::getAlias('@web') . "/";
$HOME_URL_SITE = Yii::getAlias('@web') . "/site/";
$UPLOAD_DIR = Yii::getAlias('@frontend') . '/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') . '/web/';
#$ARR = array("NAME"=>"abc","EMAIL_TO"=>'abc@abc.com',"EMAIL"=>'abc1@abc.com',"ACTIVATION_LINK"=>"http://google.com");
#\common\components\MailHelper::SendMail('VERIFY_ACCOUNT',$ARR);
?>
    <link rel="stylesheet" type="text/css" href="<?= $HOME_URL ?>css/radical-progress.css"/>
    <!-- Custom styles for this template -->
    <!-- <link rel="stylesheet" type="text/css" href="css/cs-select.css" />
    <link rel="stylesheet" type="text/css" href="css/radical-progress.css" />
    <link rel="stylesheet" type="text/css" href="css/cs-skin-border.css" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet"> -->
    <!--<div class="wrapper">-->
    <div class="main-section">
        <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
        <main>
            <section>
                <div class="container">
                    <?php if ($flag == 1) { ?>
                        <div class="row">
                            <div class="col-md-9 col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pr">
                                            <div class="cover-pic" id="timelineContainer">
                                                <div id="timelineBackground">
                                                    <?php $pos = strpos($COVER_PHOTO, 'profile-bg.jpg'); ?>
                                                    <img src="<?php echo $COVER_PHOTO; ?>" class="bgImagecover"
                                                         style="margin-top: <?= (!$pos) ? $model->cover_background_position : ''; ?>;">
                                                    <!-- $model->cover_background_position -->
                                                </div>

                                                <div id="timelineNav"></div>
                                            </div>
                                            <div class="pr-inner">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="im-pc">
                                                            <div class="image">
                                                                <div class="placeholder text-center">
                                                                    <?= Html::img(CommonHelper::getPhotos('USER', $model->id, "200" . $model->propic, 200, '', 'Yes'), ['class' => 'img-responsive mainpropic', 'width' => '200', 'height' => '200', 'alt' => 'Profile Pic']); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="pic-sm">
                                                            <div class="pr-right">
                                                                <div class="fb-profile-text">
                                                                    <h1><?= $model->FullName ?> <span
                                                                            class="sub-text">(<?= $model->Registration_Number ?>
                                                                            )</span></h1>
                                                                </div>
                                                                <div class="profile-edit">
                                                                    <div class="pull-left">
                                                                        <ul class="list-inline major-control">
                                                                            <!--<li id="hideshow_a">
                                                                                <a href="javascript:void(0)"
                                                                                   data-target="#hideProfile"
                                                                                   data-toggle="modal"
                                                                                   class="hideshowmenu"
                                                                                   data-name="<? /*= $model->hide_profile */ ?>">
                                                                                    <i class="fa <? /*= ($model->hide_profile == 'Yes') ? 'fa-eye' : 'fa-eye-slash'; */ ?>"></i> <? /*= ($model->hide_profile == 'Yes') ? 'Show' : 'Hide'; */ ?>
                                                                                    Profile
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:void(0)"
                                                                                   data-target="#deleteProfile"
                                                                                   data-toggle="modal">
                                                                                    <i class="fa fa-times"></i>
                                                                                    Delete Profile
                                                                                </a>
                                                                            </li>-->
                                                                        </ul>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <ul class="list-inline minor-control">
                                                                            <?php
                                                                            $USER_FACEBOOK = \common\models\User::weightedCheck(11, $model->id);
                                                                            $USER_PHONE = \common\models\User::weightedCheck(8, $model->id);
                                                                            $USER_EMAIL = \common\models\User::weightedCheck(9, $model->id);
                                                                            $USER_APPROVED = \common\models\User::weightedCheck(10, $model->id);
                                                                            ?>
                                                                            <li><a href="javascript:void(0)"
                                                                                   <?php if ($USER_FACEBOOK){ ?>class="active"<?php } ?>><i
                                                                                        class="fa fa-facebook"></i> <span
                                                                                        class="badge"><i
                                                                                            class="fa fa-check"></i></span></a>
                                                                            </li>
                                                                            <li><a href="javascript:void(0)"
                                                                                   <?php if ($USER_PHONE){ ?>class="active"<?php } ?>><i
                                                                                        class="fa fa-mobile"></i> <span
                                                                                        class="badge"><i
                                                                                            class="fa fa-check"></i></span></a>
                                                                            </li>
                                                                            <li><a href="javascript:void(0)"
                                                                                   <?php if ($USER_EMAIL){ ?>class="active"<?php } ?>><i
                                                                                        class="fa fa-envelope-o"></i> <span
                                                                                        class="badge"><i
                                                                                            class="fa fa-check"></i></span></a>
                                                                            </li>
                                                                            <li><a href="javascript:void(0)"
                                                                                   <?php if ($USER_APPROVED){ ?>class="active"<?php } ?>><i
                                                                                        class="fa fa-user"></i> <span
                                                                                        class="badge"><i
                                                                                            class="fa fa-check"></i></span></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="bg-white">
                                            <div class="radical-progress-wrapper">
                                                <div class="panel-body">
                                                    <h3 class="heading-xs">Profile Status</h3>
                                                    <?php if ($PROFILE_COMPLETENESS < 100) { ?>
                                                        <div class="radial-progress" data-progress="0">
                                                            <div class="circle">
                                                                <div class="mask full">
                                                                    <div class="fill"></div>
                                                                </div>
                                                                <div class="mask half">
                                                                    <div class="fill"></div>
                                                                    <div class="fill fix"></div>
                                                                </div>
                                                                <div class="shadow"></div>
                                                            </div>
                                                            <div class="inset">
                                                                <div class="percentage">
                                                                    <div class="numbers">
                                                                        <span>-</span><span>0% Complete</span>
                                                                        <?php for ($i = 1; $i <= 100; $i++) { ?>
                                                                            <span><?= $i ?>% Complete</span>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="notice kp_success mrg-tp-10"><p>100% completed.</p>
                                                        </div>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="divider"></div>
                                            <div class="panel no-border padd-hr-10 panel-default panel-friends">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title text-muted mrg-bt-10">Tags</h3>
                                                </div>
                                                <div class="panel-body no-padd text-center">
                                                    <div class="bootstrap-tagsinput" id="user_tag_list">
                                                        <?php
                                                        if (count($TAG_LIST_USER) != 0) {
                                                            foreach ($TAG_LIST_USER as $TK => $TV) {
                                                                ?>
                                                                <span class="tag label label-danger">
                <?= $TV->tagName->Name ?>
            </span>
                                                            <?php }
                                                        } else { ?>
                                                            <span
                                                                class="tag label label-danger">Tag Not Available</span>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="divider"></div>
                                            <?php if (count($photo_model) > 1) { ?>
                                                <div class="panel no-border panel-default panel-friends">
                                                    <div class="panel-heading">
                                                        <h3 class="heading-xs"> Photos <span
                                                                class="text-danger">(<?= count($photo_model) ?>)</span>
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body text-center">
                                                        <ul class="friends">
                                                            <?php foreach ($photo_model as $K => $V) { ?>
                                                                <li class="<?= ($V->eStatus == 'Approve') ? 'gallery1 ' : 'img-blur' ?>">
                                                                    <a href="javascript:void(0)">
                                                                        <?= Html::img(CommonHelper::getPhotos('USER', $model->id, Yii::$app->params['thumbnailPrefix'] . "75_" . $V['File_Name'], 75), ['width' => 75, 'height' => 75, 'class' => 'img-responsive tip', 'alt' => $V['File_Name'] . $K, 'style' => 'height: 75px;']); ?>
                                                                    </a></li>
                                                            <?php } ?>
                                                        </ul>
                                                        <!--<span class="pull-right"><a href="#" data-toggle="modal"
                                                                                    data-target="#photo">View all photos</a></span>-->
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <ul class="nav nav-tabs bg-white my-profile" role="tablist">
                                            <li role="presentation" <?= ($tab == '') ? 'class="active"' : ''; ?> ><a
                                                    href="#tab1" aria-controls="home"
                                                    role="tab" data-toggle="tab">Home</a>
                                            </li>
                                            <li role="presentation" <?= ($tab == 'EP') ? 'class="active"' : ''; ?> ><a
                                                    href="#tab2" aria-controls="profile" role="tab"
                                                    data-toggle="tab">Partner Preferences</a></li>
                                            <li role="presentation"><a href="#tab3" aria-controls="profile" role="tab"
                                                                       data-toggle="tab"> Contact Details</a></li>
                                            <li role="presentation"><a href="#tab4" aria-controls="profile" role="tab"
                                                                       data-toggle="tab"> Hobby / Interest</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <?php Pjax::begin(['id' => 'refresh_index']); ?>
                                        <?= Html::a("Refresh", ['user/my-profile'], ['class' => 'btn btn-lg btn-primary hidden']) ?>
                                        <?php Pjax::end(); ?>
                                        <div class="tab-content my-profile">
                                            <div role="tabpanel" class="tab-pane <?= ($tab == '') ? 'active' : ''; ?> "
                                                 id="tab1">
                                                <div class="inner-block">
                                                    <div class="fb-profile-text padd-xs padd-tp-0">
                                                        <h1>
                                                            <span
                                                                class="heading-icons <?= ($model->Gender == 'MALE') ? 'icon9' : 'icon1'; ?>"></span>
                                                            My Information</h1>
                                                    </div>
                                                    <div class="box">
                                                        <?php if ($model->tYourSelf != '') { ?>
                                                            <div class="mid-col">
                                                                <div class="form-cont">
                                                                    <?= $model->tYourSelf ?>
                                                                </div>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="notice kp_info"><p>Information Not
                                                                    Available.</p></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="inner-block">
                                                    <h3><span class="heading-icons icon2"></span> Personal information
                                                    </h3>

                                                    <div class="div_personal_info">
                                                        <dl class="dl-horizontal">
                                                            <dt>Name</dt>
                                                            <dd><?= $model->FullName; ?>
                                                            <dd>
                                                            <dt>Profile created by</dt>
                                                            <dd><?= $model->Profile_created_for; ?></dd>
                                                            <dt>Date Of Birth</dt>
                                                            <dd><?= $model->DOB; ?>
                                                            <dd>
                                                            <dt>Age</dt>
                                                            <dd><?= CommonHelper::getAge($model->DOB); ?> years
                                                            <dd>
                                                            <dt>Gender</dt>
                                                            <dd><?= $model->Gender ?></dd>
                                                            <dt>Mobile</dt>
                                                            <dd><?= $model->county_code . " " . $model->Mobile; ?></dd>
                                                            <dt>Mother Tongue</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->motherTongue->Name, 'text') ?></dd>
                                                        </dl>
                                                    </div>

                                                </div>
                                                <div class="divider"></div>
                                                <div class="inner-block">
                                                    <h3><span class="heading-icons icon2"></span> Basic information</h3>

                                                    <div class="div_basic_info">
                                                        <dl class="dl-horizontal">
                                                            <dt>Religion</dt>
                                                            <dd><?= $model->religionName->vName; ?>
                                                            <dd>
                                                            <dt>Community</dt>
                                                            <dd><?= $model->communityName->vName; ?></dd>
                                                            <dt>Sub Community</dt>
                                                            <dd><?= $model->subCommunityName->vName; ?>
                                                            <dd>
                                                            <dt>Gotra</dt>
                                                            <dd><?= $model->gotraName->vName; ?></dd>
                                                            <dt>Marital Status</dt>
                                                            <dd><?= $model->maritalStatusName->vName; ?></dd>
                                                            <?php if ($model->noc > 0) { ?>
                                                                <dt>Number Of Children</dt>
                                                                <dd><?= $model->noc; ?></dd>
                                                            <?php } ?>
                                                            <dt>Country</dt>
                                                            <dd><?= $model->countryName->vCountryName; ?></dd>
                                                            <dt>State</dt>
                                                            <dd><?= $model->stateName->vStateName; ?></dd>
                                                            <dt>City</dt>
                                                            <dd><?= $model->cityName->vCityName; ?></dd>
                                                            <dt>Distict</dt>
                                                            <dd><?= $model->districtName->vName; ?></dd>
                                                            <dt>Taluks</dt>
                                                            <dd><?= $model->talukaName->vName; ?></dd>
                                                            <dt>Area Name</dt>
                                                            <dd><?= $model->vAreaName ?></dd>
                                                        </dl>

                                                    </div>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="inner-block">
                                                    <h3><span class="heading-icons icon2"></span> Educational &
                                                        Occupational
                                                    </h3>

                                                    <div class="div_education">
                                                        <dl class="dl-horizontal">
                                                            <dt>Education Level</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->educationLevelName->vEducationLevelName, 'text') ?>
                                                            <dd>
                                                            <dt>Education Field</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->educationFieldName->vEducationFieldName, 'text') ?></dd>
                                                            <dt>Working With</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->workingWithName->vWorkingWithName, 'text') ?></dd>
                                                            <dt>Woking As</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->workingAsName->vWorkingAsName, 'text') ?></dd>
                                                            <dt>Annual Income</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->annualIncome->vAnnualIncome, 'text') ?></dd>
                                                        </dl>

                                                    </div>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="inner-block">
                                                    <h3><span class="heading-icons icon2"></span> Lifestyle & Appearance
                                                    </h3>

                                                    <div class="div_lifestyle">
                                                        <dl class="dl-horizontal">
                                                            <dt>Height</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->height->vName, 'text') ?>
                                                            <dd>
                                                            <dt>Skin Tone</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vSkinTone, 'text') ?></dd>
                                                            <dt>Body type</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vBodyType, 'text') ?>
                                                            <dd>
                                                            <dt>Smoke</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vSmoke, 'text') ?></dd>
                                                            <dt>Drink</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vDrink, 'text') ?></dd>
                                                            <dt>Spectacles/Lens</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vSpectaclesLens, 'text') ?></dd>
                                                            <dt>Diet</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->dietName->vName, 'text') ?></dd>
                                                            <dt>Weight</dt>
                                                            <dd><?= CommonHelper::setInputVal(($model->weight != '') ? $model->weight . " KG" : $model->weight, 'text') ?></dd>
                                                        </dl>

                                                    </div>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="inner-block">
                                                    <h3><span class="heading-icons icon2"></span> Family</h3>

                                                    <div class="div_family">
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
                                                            <dt>Taluks</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->talukaNameCA->vName, 'text') ?></dd>
                                                            <dt>Area Name</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vAreaName, 'text') ?></dd>
                                                            <dt>Native Place</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vNativePlaceCA, 'text') ?></dd>
                                                            <dt>Parents Residing At</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vParentsResiding, 'text') ?></dd>
                                                            <dt>Family Affluence Level</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vFamilyAffluenceLevel, 'text') ?></dd>
                                                            <dt>Family Type</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vFamilyType, 'text') ?></dd>
                                                            <dt>Property Details</dt>
                                                            <?php
                                                            $family_property_array = ArrayHelper::map(CommonHelper::getFamilyPropertyDetail(), 'ID', 'Name');
                                                            $family_propertyId_array = explode(',', $model->vFamilyProperty);
                                                            $vFamilyProperty = "";
                                                            foreach ($family_propertyId_array as $key => $value) {
                                                                $vFamilyProperty .= $family_property_array[$value] . ", ";
                                                            }
                                                            $vFamilyProperty = trim($vFamilyProperty, ", ")
                                                            ?>
                                                            <dd><?= CommonHelper::setInputVal($vFamilyProperty, 'text') ?></dd>
                                                            <dt>You can enter your relative surnames etc</dt>
                                                            <dd><?= CommonHelper::setInputVal($model->vAreaName, 'text') ?></dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="inner-block">
                                                    <h3><span class="heading-icons icon2"></span> HOROSCOPE DETAILS</h3>

                                                    <div class="div_horoscope">
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

                                                    </div>
                                                </div>
                                            </div>


                                            <div role="tabpanel"
                                                 class="tab-pane <?= ($tab == 'EP') ? 'active' : ''; ?> "
                                                 id="tab2">

                                                <div class="inner-block">
                                                    <div class="fb-profile-text padd-xs padd-tp-0">
                                                        <h1><span class="heading-icons icon2"></span> Preferences</h1>
                                                    </div>
                                                    <div class="div_preferences">
                                                        <dl class="dl-horizontal">
                                                            <dt>Religion</dt>
                                                            <dd><?= CommonHelper::setInputVal($PartenersReligion->religionName->vName, 'text') ?>
                                                            <dd>
                                                            <dt>Age From</dt>
                                                            <dd><?= CommonHelper::setInputVal($UPP->age_from, 'age') ?>
                                                            <dd>
                                                            <dt>Age To</dt>
                                                            <dd><?= CommonHelper::setInputVal($UPP->age_to, 'age') ?>
                                                            <dd>
                                                            <dt>Height From</dt>
                                                            <dd><?= CommonHelper::setInputVal($UPP->heightFrom->vName, 'text') ?>
                                                            <dd>
                                                            <dt>Height To</dt>
                                                            <dd><?= CommonHelper::setInputVal($UPP->heightTo->vName, 'text') ?>
                                                            <dd>
                                                            <dt>Marital Status</dt>
                                                            <dd><?= CommonHelper::setInputVal($PartnersMaritalStatus->maritalStatusName->vName, 'text') ?>
                                                            <dd>
                                                            <dt>Gotra</dt>
                                                            <dd><?= CommonHelper::setInputVal($PartnersGotra->gotraName->vName, 'text') ?>
                                                            <dd>
                                                            <dt>Mothertoungue</dt>
                                                            <dd><?= CommonHelper::setInputVal($PartnersMothertongue->partnersMothertongueName->Name, 'text') ?>
                                                            <dd>
                                                            <dt>Mangalik</dt>
                                                            <dd><?= CommonHelper::setInputVal($UPP->manglik, 'text') ?>
                                                            <dd>
                                                            <dt>Community</dt>
                                                            <dd><?= CommonHelper::setInputVal($PartnersCommunity->communityName->vName, 'text') ?>
                                                            <dd>
                                                            <dt>Sub Community</dt>
                                                            <dd><?= CommonHelper::setInputVal($PartnersSubCommunity->subCommunityName->vName, 'text') ?>
                                                            <dd>
                                                            <dt>Drink</dt>
                                                            <dd><?= CommonHelper::setInputVal($UPP->drink, 'text') ?>
                                                            <dd>
                                                            <dt>Smoke</dt>
                                                            <dd><?= CommonHelper::setInputVal($UPP->smoke, 'text') ?>
                                                            <dd>
                                                        </dl>

                                                    </div>
                                                </div>

                                                <div class="inner-block">
                                                    <div class="fb-profile-text padd-xs padd-tp-0">
                                                        <h1><span class="heading-icons icon2"></span>Profession
                                                            Preferences
                                                        </h1>
                                                    </div>
                                                    <div class="div_profession">

                                                        <dl class="dl-horizontal">
                                                            <dt>Education Level</dt>
                                                            <dd><?= CommonHelper::setInputVal($PartnersEducationalLevel->educationLevelName->vEducationLevelName, 'text') ?>
                                                            <dd>
                                                            <dt>Education Field</dt>
                                                            <dd><?= CommonHelper::setInputVal($PartnersEducationField->educationFieldName->vEducationFieldName, 'text') ?>
                                                            <dd>
                                                            <dt>Working As</dt>
                                                            <dd><?= CommonHelper::setInputVal($PW->workingAsName->vWorkingAsName, 'text') ?>
                                                            <dd>
                                                            <dt>Working With</dt>
                                                            <dd><?= CommonHelper::setInputVal($WorkingW->workingWithName->vWorkingWithName, 'text') ?>
                                                            <dd>
                                                            <dt>Annual Income</dt>
                                                            <dd><?= CommonHelper::setInputVal($AI->annualIncomeName->vAnnualIncome, 'text') ?>
                                                            <dd>
                                                        </dl>

                                                    </div>
                                                </div>

                                                <div class="inner-block">
                                                    <div class="fb-profile-text padd-xs padd-tp-0">
                                                        <h1><span class="heading-icons icon2"></span> Location
                                                            Preferences
                                                        </h1>
                                                    </div>
                                                    <div class="div_location">
                                                        <dl class="dl-horizontal">
                                                            <dt>City</dt>
                                                            <dd><?= CommonHelper::setInputVal($PC->cityName->vCityName, 'text') ?>
                                                            <dd>
                                                            <dt>State</dt>
                                                            <dd><?= CommonHelper::setInputVal($PS->stateName->vStateName, 'text') ?>
                                                            <dd>
                                                            <dt>Country</dt>
                                                            <dd><?= CommonHelper::setInputVal($PCS->countryName->vCountryName, 'text') ?>
                                                            <dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="inner-block">
                                                    <div class="fb-profile-text padd-xs padd-tp-0">
                                                        <h1><span
                                                                class="heading-icons <?= ($model->Gender == 'MALE') ? 'icon1' : 'icon9'; ?>"></span>
                                                            What I am looking for
                                                        </h1>
                                                    </div>

                                                    <div class="div_looking">
                                                        <?php if ($UPP->LookingFor != '') { ?>
                                                            <div class="mid-col">
                                                            <div class="form-cont">
                                                                <?= $UPP->LookingFor ?>
                                                            </div>
                                                            </div><?php } else { ?>
                                                            <div class="notice kp_info"><p>Information Not
                                                                    Available.</p></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab3">
                                                <div class="fb-profile-text padd-xs padd-tp-0">
                                                    <h1><span class="heading-icons icon9"></span> Contact Detail</h1>
                                                </div>
                                                <dl class="dl-horizontal">
                                                    <dt>Email</dt>
                                                    <dd><?= $model->email; ?>
                                                    <dd>
                                                    <dt>Phone No.</dt>
                                                    <dd><?= $model->county_code . " " . $model->Mobile; ?></dd>
                                                    <dt>Perement Address</dt>
                                                    <dd><?= $model->permentAddress; ?>
                                                    <dd>
                                                    <dt>Current Address</dt>
                                                    <dd><?= $model->currentAddress; ?></dd>

                                                </dl>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab4">
                                                <div class="inner-block">
                                                    <div class="fb-profile-text padd-xs padd-tp-0">
                                                        <h1><span
                                                                class="heading-icons icon2"></span>
                                                            Hobby/Interest Information
                                                        </h1>
                                                    </div>
                                                    <div class="div_hobby">
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= $this->render('/layouts/parts/_rightbar.php', ['SimilarProfile' => $SimilarProfile]) ?>
                        </div>
                    <?php } else if ($flag == 2) { ?>
                        <div class="row">
                            <div class="col-md-12 mrg-tp-30">
                                <div class="dashboard-wrapper tempclass">
                                    <div class="bg-white middlebox">
                                        <div class="ad-title"><h1><?= $TITLE ?></h1></div>
                                        <div class="clearfix"></div>
                                        <div class="fb-profile-text">
                                            <div class=" ">
                                                <div class="list-group">
                                                    <div class="list-group-item">
                                                        <div class="notice kp_warning">
                                                            <p> <?= nl2br(Html::encode($MESSAGE)) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <span class="pull-right "><a href="<?= Yii::$app->homeUrl ?>"
                                                                     class="text-right">Back To
                                                Home Page<i class="fa fa-angle-right"></i></a></span>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else if ($flag == 3) { ?>
                        <div class="row">
                            <div class="col-md-12 mrg-tp-30">
                                <div class="dashboard-wrapper tempclass">
                                    <div class="bg-white middlebox">
                                        <div class="ad-title"><h1><?= $TITLE ?></h1></div>
                                        <div class="clearfix"></div>
                                        <div class="fb-profile-text">
                                            <div class=" ">
                                                <div class="list-group">
                                                    <div class="list-group-item">
                                                        <div class="notice kp_warning">
                                                            <p> <?= nl2br(Html::encode($MESSAGE)) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <span class="pull-right "><a href="<?= Yii::$app->homeUrl ?>"
                                                                     class="text-right">Back To
                                                Home Page<i class="fa fa-angle-right"></i></a></span>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-md-12 mrg-tp-30">
                                <div class="dashboard-wrapper tempclass">
                                    <div class="bg-white middlebox">
                                        <div class="ad-title"><h1><?= $TITLE ?></h1></div>
                                        <div class="clearfix"></div>
                                        <div class="fb-profile-text">
                                            <div class=" ">
                                                <div class="list-group">
                                                    <div class="list-group-item">
                                                        <div class="notice kp_warning">
                                                            <p> <?= nl2br(Html::encode($MESSAGE)) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <span class="pull-right "><a href="<?= Yii::$app->homeUrl ?>"
                                                                     class="text-right">Back To
                                                Home Page<i class="fa fa-angle-right"></i></a></span>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </section>
        </main>
    </div>

<?php if ($flag == 1) { ?>
    <script type="text/javascript">
        var PRO_COMP = <?=$PROFILE_COMPLETENESS?>;
    </script>
    <script src="<?= $HOME_URL ?>js/selectFx.js"></script>
    <?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/cover/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
    <?= $this->render('_scriptmyprofile'); ?>
<?php } ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/cover/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>