<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
#use frontend\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
use yii\captcha\Captcha;
use common\components\CommonHelper;
use common\components\MessageHelper;
use yii\helpers\Url;
use common\models\user;
$Id = 0;
$PROFILE_COMPLETENESS = 0;

if (!Yii::$app->user->isGuest) {
    $Id = Yii::$app->user->identity->id;
    $PROFILE_COMPLETENESS = $this->context->profileCompleteness($model->completed_step);
}
?>
    <div class="main-section">

    <link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/radical-progress.css"/>
        <main> <!--data-ng-app="myApp" data-ng-controller="dashboardController"-->
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 col-md-3">
                            <div class="browse-photo">
                                <form action="" method="post" enctype="multipart/form-data"
                                      id="upload_form">
                                    <input name="__files[]" id="file_browse" type="file"
                                           multiple class="fileupload"/>
                                </form>
                            </div>
                            <div class="bg-white">
                                <div class="radical-progress-wrapper">
                                    <div class="panel-body">
                                        <div class="profile-header-container">
                                            <div class="profile-header-img">
                                                <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, "200" . Yii::$app->user->identity->propic, 200, '', 'Yes', CommonHelper::getVisiblePhoto(Yii::$app->user->identity->id, Yii::$app->user->identity->eStatusPhotoModify)), ['width' => '200', 'height' => '200', 'alt' => 'Profile Photo', 'class' => 'img-circle mainpropic']); ?>
                                                <!-- badge -->
                                                <div class="rank-label-container img-circle">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                                id="dropdownMenu1" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="true"><i
                                                                class="fa fa-pencil"></i></button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="javascript:void(0)" data-toggle="modal"
                                                                   class="gallery-popup"
                                                                   data-target="#photo">Choose from My Photos</a></li>
                                                            <li><a href="javascript:void(0)"
                                                                   class="file_browse_wrapper">Upload Photo</a>
                                                            </li>
                                                            <li><a href="javascript:void(0)">Reposition</a></li>
                                                            <li><a href="javascript:void(0)"
                                                                   class="_profile-photo-remove">Delete Photo</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ad-title" style="margin-bottom:0">My Dashboard</div>
                                    </div>
                                </div>
                                <div class="divider no-mrg"></div>
                                <div class="panel no-border panel-default panel-friends">
                                    <div class="panel-heading">
                                        <h3 class="heading-xs"> My Profile</h3>
                                    </div>
                                    <div class="panel-body">
                                        <ul class="reset mrg-lt-15 list-item">
                                            <li><a href="<?= Yii::$app->request->baseUrl ?>/my-profile"
                                                   title="Edit Profile">Edit
                                                    Profile</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl ?>/photos"
                                                   title="Manage Photos">Manage
                                                    Photos</a></li>
                                            <li><a href="<?= Yii::$app->request->baseUrl ?>/my-profile?tab=EP"
                                                   title="Edit Preference"> Edit Preference</a>
                                            </li>
                                            <li><?= html::a('Privacy Options', ['/setting'], ["title" => 'Privacy Option']) ?></li>
                                            <li><?= html::a('Shortlisted Profile(s)', ['search/short-list'], ["title" => 'Shortlisted Profile(s)']) ?></li>
                                        </ul>
                                        <!-- <a href="javascript:void(0)"
                     class="pull-left profile_set"
                     data-id="<?= $V['iPhoto_ID'] ?>"
                     data-target="#photodelete" data-toggle="modal">
                    Profile pic
                  </a>-->
                                    </div>
                                </div>
                                <div class="divider no-mrg"></div>
                                <div class="panel no-border padd-hr-10 panel-default panel-friends">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-muted">Unblock Trust Badges
                                            <?= Html::img('@web/images/follower-member.png', ['width' => '', 'height' => '', 'alt' => '']); ?>
                                        </h3>
                                    </div>
                                    <div class="panel-body no-padd text-center">
                                        <div class="profile-edit">
                                            <ul class="list-inline minor-control">
                                                <?php
                                                $USER_FACEBOOK = \common\models\User::weightedCheck(11);
                                                $USER_PHONE = \common\models\User::weightedCheck(8);
                                                $USER_EMAIL = \common\models\User::weightedCheck(9);
                                                $USER_APPROVED = \common\models\User::weightedCheck(10);
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
                                <div class="divider no-mrg"></div>
                                <div class="panel no-border panel-default panel-friends">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-muted">Messages</h3>
                                    </div>
                                    <div class="panel-body">
                                        <ul class="reset list-item">
                                            <li>
                                                <a href="<?= CommonHelper::getMailBoxUrl() ?>" title="Inbox">Inbox</a>
                                                <?php if ($TotalInboxCount > 0) { ?><span
                                                    class="badge"><?= $TotalInboxCount ?></span><?php } ?>
                                            </li>
                                            <!--<li>
                                                <a href="<? /*= CommonHelper::getMailBoxUrl(1.3) */ ?>" title="Accepted">Accepted Interest</a>
                                                <span class="badge">2</span>
                                            </li>
                                            <li>
                                                <a href="<? /*= CommonHelper::getMailBoxUrl() */ ?>" title="Not Replied"> Not Replied </a>
                                                <span class="badge">1</span>
                                            </li>
                                            <li>
                                                <a href="<? /*= CommonHelper::getMailBoxUrl(2) */ ?>" title="Sent"> Sent </a>
                                                <span class="badge">1</span>
                                            </li>-->
                                        </ul>
                                    </div>
                                </div>
                                <div class="divider no-mrg"></div>
                                <?php
                                if (count($PreferencesLocation) > 0 || count($PreferencesProfession) > 0 || count($PreferencesEducation) > 0 || count($PreferencesPersonal) > 0) {
                                ?>
                                <div class="panel no-border padd-hr-10 panel-default panel-friends">
                                    <div class="panel-heading">
                                        <h3 class="panel-title text-muted">My Preferences</h3>
                                    </div>
                                    <div class="refe-accord">
                                        <div class="panel-group" id="accordion" role="tablist"
                                             aria-multiselectable="true">
                                            <?php if (count($PreferencesLocation)) { ?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse"
                                                               data-parent="#accordion" href="#collapseOnes"
                                                               aria-expanded="true" aria-controls="collapseOnes">
                                                                Location
                                                                <!--<span class="blue">(669)</span>-->
                                                                <span
                                                                    class="badge"><?= count($PreferencesLocation) ?></span>
                                                                <i class="fa indicator fa-angle-up"></i>
                                                            </a>
                                                        </h4>
                                                    </div>

                                                    <div id="collapseOnes" class="panel-collapse collapse in"
                                                         role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">
                                                            <ul class="list-unstyled ad-prof">
                                                                <?php
                                                                #$LPMax = count($PreferencesLocation)  >= 2 ? 2 : 1;
                                                                for ($LP = 0; $LP < (count($PreferencesLocation) >= 2 ? 2 : 1); $LP++) { ?>
                                                                    <li> <span class="imgarea kp_pic_dis_dwn">
                                                                        <a href="#" class="name" title="KP123WERT">
                                                                            <?= Html::img(CommonHelper::getPhotos('USER', $PreferencesLocation[$LP]->id, "63" . $PreferencesLocation[$LP]->propic, 63, '', 'Yes', CommonHelper::getVisiblePhoto($PreferencesLocation[$LP]->id, $PreferencesLocation[$LP]->eStatusPhotoModify)), ['alt' => $PreferencesLocation[$LP]->FullName, 'style' => '    width: 63px !important;']); ?>
                                                                        </a></span> <span class="img-desc"> <a href="#"
                                                                                                               class="name"
                                                                                                               title="<?= $PreferencesLocation[$LP]->Registration_Number ?>"><?= ucfirst($PreferencesLocation[$LP]->First_Name) ?></a>
                              <p><?= CommonHelper::getAge($PreferencesLocation[$LP]->DOB); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesLocation[$LP]->height->vName, 'text')); ?> <?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesLocation[$LP]->religionName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesLocation[$LP]->communityName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesLocation[$LP]->workingAsName->vWorkingAsName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesLocation[$LP]->cityName->vCityName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesLocation[$LP]->countryName->vCountryName, 'text')); ?></p>
                                                                </span>

                                                                        <div class="clearfix"></div>
                                                                    </li>

                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if (count($PreferencesProfession)) { ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title"><a class="collapsed" role="button"
                                                                               data-toggle="collapse"
                                                                               data-parent="#accordion"
                                                                               href="#collapseTwo" aria-expanded="false"
                                                                               aria-controls="collapseTwo"> Profession
                                                            <!--<span class="blue">(669)</span>-->
                                                                <span
                                                                    class="badge"><?= count($PreferencesProfession) ?></span>
                                                            <i
                                                                class="fa indicator fa-angle-down"></i> </a></h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                                     aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        <ul class="list-unstyled ad-prof">
                                                            <?php
                                                            #$LPMax = count($PreferencesProfession)  >= 2 ? 2 : 1;
                                                            for ($LP = 0; $LP < (count($PreferencesProfession) >= 2 ? 2 : 1); $LP++) { ?>
                                                                <li> <span class="imgarea kp_pic_dis_dwn">
                                                                        <a href="#" class="name" title="KP123WERT">
                                                                            <?= Html::img(CommonHelper::getPhotos('USER', $PreferencesProfession[$LP]->id, "63" . $PreferencesProfession[$LP]->propic, 63, '', 'Yes', CommonHelper::getVisiblePhoto($PreferencesProfession[$LP]->id, $PreferencesProfession[$LP]->eStatusPhotoModify)), ['alt' => $PreferencesProfession[$LP]->FullName, 'style' => '    width: 63px !important;']); ?>
                                                                        </a></span> <span class="img-desc"> <a href="#"
                                                                                                               class="name"
                                                                                                               title="<?= $PreferencesProfession[$LP]->Registration_Number ?>"><?= ucfirst($PreferencesProfession[$LP]->First_Name) ?></a>
                              <p><?= CommonHelper::getAge($PreferencesProfession[$LP]->DOB); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesProfession[$LP]->height->vName, 'text')); ?> <?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesProfession[$LP]->religionName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesProfession[$LP]->communityName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesProfession[$LP]->workingAsName->vWorkingAsName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesProfession[$LP]->cityName->vCityName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesProfession[$LP]->countryName->vCountryName, 'text')); ?></p>
                                                                </span>

                                                                    <div class="clearfix"></div>
                                                                </li>

                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if (count($PreferencesEducation)) { ?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingThree">
                                                        <h4 class="panel-title"><a class="collapsed" role="button"
                                                                                   data-toggle="collapse"
                                                                                   data-parent="#accordion"
                                                                                   href="#collapseThree"
                                                                                   aria-expanded="false"
                                                                                   aria-controls="collapseThree">
                                                                Education
                                                                <!--<span class="blue">(669)</span>-->
                                                                <span
                                                                    class="badge"><?= count($PreferencesEducation) ?></span>
                                                                <i
                                                                    class="fa indicator fa-angle-down"></i> </a></h4>
                                                    </div>
                                                    <div id="collapseThree" class="panel-collapse collapse"
                                                         role="tabpanel"
                                                         aria-labelledby="headingThree">
                                                        <div class="panel-body">
                                                            <ul class="list-unstyled ad-prof">
                                                                <?php
                                                                #$LPMax = count($PreferencesEducation)  >= 2 ? 2 : 1;
                                                                for ($LP = 0; $LP < (count($PreferencesEducation) >= 2 ? 2 : 1); $LP++) { ?>
                                                                    <li> <span class="imgarea kp_pic_dis_dwn">
                                                                        <a href="#" class="name" title="KP123WERT">
                                                                            <?= Html::img(CommonHelper::getPhotos('USER', $PreferencesEducation[$LP]->id, "63" . $PreferencesEducation[$LP]->propic, 63, '', 'Yes', CommonHelper::getVisiblePhoto($PreferencesEducation[$LP]->id, $PreferencesEducation[$LP]->eStatusPhotoModify)), ['alt' => $PreferencesEducation[$LP]->FullName, 'style' => '    width: 63px !important;']); ?>
                                                                        </a></span> <span class="img-desc"> <a href="#"
                                                                                                               class="name"
                                                                                                               title="<?= $PreferencesEducation[$LP]->Registration_Number ?>"><?= ucfirst($PreferencesEducation[$LP]->First_Name) ?></a>
                              <p><?= CommonHelper::getAge($PreferencesEducation[$LP]->DOB); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesEducation[$LP]->height->vName, 'text')); ?> <?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesEducation[$LP]->religionName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesEducation[$LP]->communityName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesEducation[$LP]->workingAsName->vWorkingAsName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesEducation[$LP]->cityName->vCityName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesEducation[$LP]->countryName->vCountryName, 'text')); ?></p>
                                                                </span>

                                                                        <div class="clearfix"></div>
                                                                    </li>

                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if (count($PreferencesPersonal)) { ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingfive">
                                                    <h4 class="panel-title"><a class="collapsed" role="button"
                                                                               data-toggle="collapse"
                                                                               data-parent="#accordion"
                                                                               href="#collapsefive"
                                                                               aria-expanded="false"
                                                                               aria-controls="collapsefive"> Personal
                                                            Preferences <!--<span class="blue">(669)</span>-->
                                                                <span
                                                                    class="badge"><?= count($PreferencesPersonal) ?></span>
                                                            <i class="fa fa-angle-down"></i> </a></h4>
                                                </div>
                                                <div id="collapsefive" class="panel-collapse collapse" role="tabpanel"
                                                     aria-labelledby="headingfive">
                                                    <div class="panel-body">
                                                        <ul class="list-unstyled ad-prof">
                                                            <?php
                                                            #$LPMax = count($PreferencesPersonal)  >= 2 ? 2 : 1;
                                                            for ($LP = 0; $LP < (count($PreferencesPersonal) >= 2 ? 2 : 1); $LP++) { ?>
                                                                <li> <span class="imgarea kp_pic_dis_dwn">
                                                                        <a href="#" class="name" title="KP123WERT">
                                                                            <?= Html::img(CommonHelper::getPhotos('USER', $PreferencesPersonal[$LP]->id, "63" . $PreferencesPersonal[$LP]->propic, 63, '', 'Yes', CommonHelper::getVisiblePhoto($PreferencesPersonal[$LP]->id, $PreferencesPersonal[$LP]->eStatusPhotoModify)), ['alt' => $PreferencesPersonal[$LP]->FullName, 'style' => '    width: 63px !important;']); ?>
                                                                        </a></span> <span class="img-desc"> <a href="#"
                                                                                                               class="name"
                                                                                                               title="<?= $PreferencesPersonal[$LP]->Registration_Number ?>"><?= ucfirst($PreferencesPersonal[$LP]->First_Name) ?></a>
                              <p><?= CommonHelper::getAge($PreferencesPersonal[$LP]->DOB); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesPersonal[$LP]->height->vName, 'text')); ?> <?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesPersonal[$LP]->religionName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesPersonal[$LP]->communityName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesPersonal[$LP]->workingAsName->vWorkingAsName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesPersonal[$LP]->cityName->vCityName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($PreferencesPersonal[$LP]->countryName->vCountryName, 'text')); ?></p>
                                                                </span>

                                                                    <div class="clearfix"></div>
                                                                </li>

                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-6">
                            <div class="dashboard-wrapper">
                                <!-- profile status -->
                                <div class="bg-white">
                                    <?php if ($PROFILE_COMPLETENESS < 100) { ?>
                                        <!--<div class="radial-progress pull-right" data-progress="0">
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
                                                        <span>-</span>
                                                        <span>0% Complete</span>
                                                        <?php /*for ($i = 1; $i <= 100; $i++) { */ ?>
                                                            <span><? /*= $i */ ?>% Complete</span>
                                                        <?php /*} */ ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="fb-profile-text">
                                                <h1 class="user-name"><?= $model->First_Name . ' ' . $model->Last_Name; ?>
                                                    <span class="sub-text">
                          (<?= ($model->Registration_Number != '') ? $model->Registration_Number : '-'; ?>)
                        </span>
                                                </h1>
                                                <?php if ($PROFILE_COMPLETENESS < 100) { ?>
                                                    <h5 class="user-line mrg-tp-20">Add more details to get better
                                                        visibility</h5>
                                                    <div class="ad-title mrg-tp-10"><a
                                                            href="<?= Yii::$app->request->baseUrl ?>/my-profile">Complete
                                                            your Profile
                                                            Now!</a></div>
                                                <?php } else { ?>
                                                    <div class="notice kp_success"><p>Your Profile 100% completed.</p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="pie_progress" role="progressbar" data-goal="33">
                                                <div class="pie_progress__number">0%</div>
                                                <div class="pie_progress__label">Complete</div>
                                            </div>
                                            <!--<div class="progress-bar position" data-percent="<? /*=$PROFILE_COMPLETENESS*/ ?>" data-duration="2000" data-color="#ccc,#ff517d"></div>-->

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <!-- view by -->

                                <div class="bg-white <?= ($PROFILE_COMPLETENESS < 100) ? 'mrg-tp-10' : 'mrg-tp-10'; ?>">
                                    <!--<a href="#" title="View All" class="pull-right">View All &gt;</a>-->
                                    <h3 class="heading-xs">Your Profile Viewed By</h3>

                                    <div class="user-list">
                                        <?php if (count($ProfileViedByMembers)) { ?>
                                            <div class="row">
                                                <?php
                                                foreach ($ProfileViedByMembers as $Key => $Value) { ?>
                                                    <?php
#                                                    CommonHelper::pr($Value);
                                                    /*if ($Id == $Value->from_user_id && $Value->profile_viewed_from_to == 'Yes') {
                                                        $ViewerId = $Value->userid;
                                                    } else {
                                                        $ViewerId = $Value->userid;
                                                    }*/
                                                    $ViewerId = $Value['userid'];
                                                    $UserInfoModel = User::getUserInfroamtion($ViewerId);
                                                    #CommonHelper::pr($UserInfoModel->height->vName);
                                                    #CommonHelper::pr($UserInfoModel->countryName->vCountryName);
                                                    #CommonHelper::pr($UserInfoModel);
                                                    #echo $UserInfoModel->DOB;
                                                    ?>
                                                    <?php #CommonHelper::pr($Value);?>
                                                    <div class="col-xs-6 col-md-6 col-lg-3">
                                                        <div class="item kp_pic_dis_dwn">
                                                            <a href="<?= CommonHelper::getUserUrl($UserInfoModel->Registration_Number) ?>&source=profile_viewed_by"
                                                               class="name-img"
                                                               title="<?= $UserInfoModel->Registration_Number ?>">
                                                                <?= Html::img(CommonHelper::getPhotos('USER', $ViewerId, "120" . $UserInfoModel->propic, 120, '', 'Yes', CommonHelper::getVisiblePhoto($ViewerId, $UserInfoModel->eStatusPhotoModify)), ['width' => '120', 'height' => '', 'alt' => 'Profile', 'class' => '']); ?>
                                                            </a>
                                                            <a href="<?= CommonHelper::getUserUrl($UserInfoModel->Registration_Number) ?>&source=profile_viewed_by"
                                                               class="name"
                                                               title="<?= $UserInfoModel->Registration_Number ?>"><?= ucfirst($UserInfoModel->First_Name) ?></a>

                                                            <p><?= CommonHelper::getAge($UserInfoModel->DOB); ?> years,
                                                                <?= CommonHelper::setInputVal($UserInfoModel->height->vName, 'text'); ?></p>

                                                            <p class="s__<?= $UserInfoModel->id ?>">
                                                                <?php

                                                                if (($Id == $Value['from_user_id'] && $Value['send_request_status_from_to'] == 'No' && $Value['send_request_status_to_from'] == 'No') || ($Id == $Value['to_user_id'] && $Value['send_request_status_to_from'] == 'No' && $Value['send_request_status_from_to'] == 'No')) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-info sendinterestpopup"
                                                                       role="button"
                                                                       data-target="#sendInterest" data-toggle="modal"
                                                                       data-id="<?= $UserInfoModel->id ?>"
                                                                       data-name="<?= $UserInfoModel->fullName ?>"
                                                                       data-rgnumber="<?= $UserInfoModel->Registration_Number ?>">Send
                                                                        Interest
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                <?php } else if (($Id == $Value['from_user_id'] && $Value['send_request_status_from_to'] == 'Yes' && $Value['send_request_status_to_from'] != 'Yes') || ($Id == $Value['to_user_id'] && $Value['send_request_status_to_from'] == 'Yes' && $Value['send_request_status_from_to'] != 'Yes')) {
                                                                    ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-info ci accept_decline"
                                                                       role="button"
                                                                       data-target="#accept_decline"
                                                                       data-toggle="modal"
                                                                       data-id="<?= $UserInfoModel->id ?>"
                                                                       data-name="<?= $UserInfoModel->fullName ?>"
                                                                       data-rgnumber="<?= $UserInfoModel->Registration_Number ?>"
                                                                       data-type="Cancel Interest">
                                                                        Cancel Interest<i class="fa fa-close"></i> </a>
                                                                    <!-- <a href="javascript:void(0)" class="btn btn-link isent" role="button">Interest Sent
                                                                        <i class="fa fa-heart"></i></a> -->
                                                                <?php } else if (($Id == $Value['to_user_id'] && $Value['send_request_status_from_to'] == 'Yes' && $Value['send_request_status_to_from'] != 'Yes') || ($Id == $Value['from_user_id'] && $Value['send_request_status_to_from'] == 'Yes' && $Value['send_request_status_from_to'] != 'Yes')) {
                                                                    ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-info accept_decline adbtn"
                                                                       role="button"
                                                                       data-target="#accept_decline" data-toggle="modal"
                                                                       data-id="<?= $UserInfoModel->id ?>"
                                                                       data-name="<?= $UserInfoModel->fullName ?>"
                                                                       data-rgnumber="<?= $UserInfoModel->Registration_Number ?>"
                                                                       data-type="Accept Interest">Accept
                                                                        <i class="fa fa-check"></i> </a>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-info accept_decline adbtn"
                                                                       role="button" data-target="#accept_decline"
                                                                       data-toggle="modal"
                                                                       data-id="<?= $UserInfoModel->id ?>"
                                                                       data-name="<?= $UserInfoModel->fullName ?>"
                                                                       data-rgnumber="<?= $UserInfoModel->Registration_Number ?>"
                                                                       data-type="Decline Interest">Decline <i
                                                                            class="fa fa-close"></i> </a>
                                                                <?php } else if ($Value['send_request_status_from_to'] == 'Accepted' || $Value['send_request_status_to_from'] == 'Accepted') {
                                                                    ?>
                                                                    <a href="javascript:void(0)" class="btn btn-info "
                                                                       role="button"
                                                                       data-target="#" data-toggle="modal"
                                                                       data-id="<?= $UserInfoModel->id ?>"
                                                                       data-name="<?= $UserInfoModel->fullName ?>"
                                                                       data-rgnumber="<?= $UserInfoModel->Registration_Number ?>"
                                                                       data-type="Connected">Connected
                                                                        <i class="fa fa-heart"></i> </a>
                                                                <?php } else if ($Value['send_request_status_from_to'] == 'Rejected' || $Value['send_request_status_to_from'] == 'Rejected') {
                                                                    ?>
                                                                    <a href="javascript:void(0)" class="btn btn-info "
                                                                       role="button"
                                                                       data-target="#" data-toggle="modal"
                                                                       data-id="<?= $UserInfoModel->id ?>"
                                                                       data-name="<?= $UserInfoModel->fullName ?>"
                                                                       data-rgnumber="<?= $UserInfoModel->Registration_Number ?>"
                                                                       data-type="Connected">Rejected <i
                                                                            class="fa fa-close"></i> </a>

                                                                <?php } else { ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-link isent" role="button">Interest
                                                                        Sent
                                                                        <i class="fa fa-heart"></i></a>
                                                                <?php } ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mrg-tp-10">
                                                        <div class="notice kp_info"><p>No Records are available.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- recent member -->
                                <?php if (count($RecentlyJoinedMembers)) { ?>
                                    <div class="bg-white mrg-tp-20">
                                        <!--<a href="#" title="View All" class="pull-right">View All &gt;</a>-->
                                        <?= html::a('View All &gt;', ['search/basic-search', 'ref' => Yii::$app->params['ref']['recently_joined']], ['data-method' => 'post', 'class' => 'pull-right', 'title' => 'View All']) ?>
                                        <h3 class="heading-xs">Recently Joined Members</h3>

                                        <div class="user-list">
                                            <div class="row">
                                                <?php foreach ($RecentlyJoinedMembers as $Key => $ValueRM) { ?>
                                                    <div class="col-xs-6 col-md-6 col-lg-3">
                                                        <div class="item kp_pic_dis_dwn">
                                                            <a href="<?= Yii::$app->homeUrl ?>user/profile?uk=<?= $ValueRM->Registration_Number ?>&source=recently_joined"
                                                               class="name-img"
                                                               title="<?= $ValueRM->Registration_Number ?>">
                                                                <?= Html::img(CommonHelper::getPhotos('USER', $ValueRM->id, "120" . $ValueRM->propic, 120, '', 'Yes', CommonHelper::getVisiblePhoto($ValueRM->id, $ValueRM->eStatusPhotoModify)), ['width' => '120', 'height' => '', 'alt' => 'Profile', 'class' => '']); ?>
                                                            </a>
                                                            <a href="<?= Yii::$app->homeUrl ?>user/profile?uk=<?= $ValueRM->Registration_Number ?>&source=recently_joined"
                                                               class="name"
                                                               title="<?= $ValueRM->Registration_Number ?>"><?= ucfirst($ValueRM->First_Name) ?></a>

                                                            <p><?= CommonHelper::getAge($ValueRM->DOB); ?> years,
                                                                <?= CommonHelper::setInputVal($ValueRM->height->vName, 'text'); ?></p>
                                                            <?php $Value = \common\models\UserRequestOp::checkSendInterest(Yii::$app->user->identity->id, $ValueRM->id);
                                                            #CommonHelper::pr(\common\models\UserRequestOp::checkSendInterest(Yii::$app->user->identity->id, $ValueRM->id));
                                                            if (count($Value)) {

                                                                if ($Id == $Value->from_user_id && $Value->profile_viewed_from_to == 'Yes') {
                                                                    $ViewerId = $Value->to_user_id;
                                                                } else {
                                                                    $ViewerId = $Value->from_user_id;
                                                                }
                                                            } else {
                                                                $ViewerId = $ValueRM->id;
                                                            }
                                                            $UserInfoModel = User::getUserInfroamtion($ViewerId);
                                                            #CommonHelper::pr($UserInfoModel);
                                                            ?>
                                                            <p class="s__<?= $ValueRM->id ?>">
                                                                <?php

                                                                if (count($Value) == 0 || ($Id == $Value->from_user_id && $Value->send_request_status_from_to == 'No' && $Value->send_request_status_to_from == 'No') || ($Id == $Value->to_user_id && $Value->send_request_status_to_from == 'No' && $Value->send_request_status_from_to == 'No')) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-info sendinterestpopup"
                                                                       role="button"
                                                                       data-target="#sendInterest" data-toggle="modal"
                                                                       data-id="<?= $ValueRM->id ?>"
                                                                       data-name="<?= $ValueRM->fullName ?>"
                                                                       data-rgnumber="<?= $ValueRM->Registration_Number ?>">Send
                                                                        Interest <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                <?php } else if (($Id == $Value->from_user_id && $Value->send_request_status_from_to == 'Yes' && $Value->send_request_status_to_from != 'Yes') || ($Id == $Value->to_user_id && $Value->send_request_status_to_from == 'Yes' && $Value->send_request_status_from_to != 'Yes')) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-info ci accept_decline"
                                                                       role="button"
                                                                       data-target="#accept_decline"
                                                                       data-toggle="modal"
                                                                       data-id="<?= $ValueRM->id ?>"
                                                                       data-name="<?= $ValueRM->fullName ?>"
                                                                       data-rgnumber="<?= $ValueRM->Registration_Number ?>"
                                                                       data-type="Cancel Interest">
                                                                        Cancel Interest
                                                                        <i class="fa fa-close"></i> </a>

                                                                <?php } else if (($Id == $Value->to_user_id && $Value->send_request_status_from_to == 'Yes' && $Value->send_request_status_to_from != 'Yes') || ($Id == $Value->from_user_id && $Value->send_request_status_to_from == 'Yes' && $Value->send_request_status_from_to != 'Yes')) {
                                                                    ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-info accept_decline adbtn"
                                                                       role="button" data-target="#accept_decline"
                                                                       data-toggle="modal"
                                                                       data-id="<?= $ValueRM->id ?>"
                                                                       data-name="<?= $ValueRM->fullName ?>"
                                                                       data-rgnumber="<?= $ValueRM->Registration_Number ?>"
                                                                       data-type="Accept Interest">
                                                                        Accept
                                                                        <i class="fa fa-check"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-info accept_decline adbtn"
                                                                       role="button" data-target="#accept_decline"
                                                                       data-toggle="modal"
                                                                       data-id="<?= $ValueRM->id ?>"
                                                                       data-name="<?= $ValueRM->fullName ?>"
                                                                       data-rgnumber="<?= $ValueRM->Registration_Number ?>"
                                                                        >
                                                                        Decline
                                                                        <i class="fa fa-close"></i> </a>
                                                                <?php } else if ($Value->send_request_status_from_to == 'Accepted' || $Value->send_request_status_to_from == 'Accepted') {
                                                                    ?>
                                                                    <a href="javascript:void(0)" class="btn btn-info "
                                                                       role="button"
                                                                       data-target="#" data-toggle="modal"
                                                                       data-id="<?= $ValueRM->id ?>"
                                                                       data-name="<?= $ValueRM->fullName ?>"
                                                                       data-rgnumber="<?= $ValueRM->Registration_Number ?>"
                                                                       data-type="Connected">Connected
                                                                        <i class="fa fa-heart"></i> </a>
                                                                <?php } else if ($Value->send_request_status_from_to == 'Rejected' || $Value->send_request_status_to_from == 'Rejected') {
                                                                    ?>
                                                                    <a href="javascript:void(0)" class="btn btn-info "
                                                                       role="button"
                                                                       data-target="#" data-toggle="modal"
                                                                       data-id="<?= $ValueRM->id ?>"
                                                                       data-name="<?= $ValueRM->fullName ?>"
                                                                       data-rgnumber="<?= $ValueRM->Registration_Number ?>"
                                                                       data-type="Connected">Rejected <i
                                                                            class="fa fa-close"></i> </a>

                                                                <?php } else { ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-link isent" role="button">Interest
                                                                        Sent <i class="fa fa-heart"></i></a>
                                                                <?php } ?>
                                                            </p>
                                                            <!--<p class="s__<? /*= $Value->id */ ?>">
                                <?php
                                                            /*                                $Check = \common\models\UserRequest::checkSendInterest(Yii::$app->user->identity->id, $Value->id);
                                                                                            if ($Check->from_user_id == Yii::$app->user->identity->id && $Check->to_user_id == $Value->id && $Check->send_request_status == "Yes") {
                                                                                              */ ?>
                                  <a href="javascript:void(0)" class="btn btn-link isent" role="button">Interest Sent <i
                                        class="fa fa-heart"></i></a>
                                <?php /*} else { */ ?>
                                  <a href="javascript:void(0)" class="btn btn-info sendinterestpopup" role="button"
                                     data-target="#sendInterest" data-toggle="modal" data-id="<? /*= $Value->id */ ?>"
                                     data-name="<? /*= $Value->First_Name . " " . $Value->Last_Name */ ?>"
                                     data-rgnumber="<? /*= $Value->Registration_Number */ ?>">Send Interest
                                    <i class="fa fa-heart-o"></i>
                                  </a>
                                <?php /*} */ ?>
                              </p>-->
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- Short list block -->
                                <div class="row">
                                    <?php if (count($ShortListUser) > 0) { ?>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="bg-white mrg-tp-20">
                                                <h3 class="heading-xs">Your Profile Shortlisted By</h3>
                                                <ul class="list-unstyled ad-prof mrg-tp-20">
                                                    <?php foreach ($ShortListUser as $KeyShort => $ValueShort) { ?>
                                                        <li>
                                                    <span class="imgarea kp_pic_dis_dwn">
                                                        <?= Html::img(CommonHelper::getPhotos('USER', $ValueShort->id, "63" . $ValueShort->propic, 63, '', 'Yes', CommonHelper::getVisiblePhoto($ValueShort->id, $ValueShort->eStatusPhotoModify)), ['alt' => $ValueShort->FullName, 'style' => 'width: 63px !important;']); ?>
                                                    </span>
                                                    <span class="img-desc">
                                                        <a href="<?= Yii::$app->homeUrl ?>user/profile?uk=<?= $ValueShort->Registration_Number ?>&source=shortlisted_by"
                                                           class="name"
                                                           title="<?= $ValueShort->Registration_Number ?>">
                                                            <?= ucfirst($ValueShort->First_Name) ?>
                                                        </a>
                                                        <p><?= CommonHelper::getAge($ValueShort->DOB); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($ValueShort->height->vName, 'text')); ?> <?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($ValueShort->religionName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($ValueShort->communityName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($ValueShort->workingAsName->vWorkingAsName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($ValueShort->cityName->vCityName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($ValueShort->countryName->vCountryName, 'text')); ?></p>
                                                    </span>

                                                            <div class="clearfix"></div>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                <div class="text-right">
                                                    <?php if (count($ShortListUser) > 2) { ?>
                                                        <?= html::a('View All &gt;', ['search/basic-search', 'ref' => Yii::$app->params['ref']['you_shortlisted_by']], ['data-method' => 'post', 'class' => 'pull-right', 'title' => 'View All']) ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="bg-white mrg-tp-20">
                                            <h3 class="heading-xs">Your Phone No. Viewed By</h3>
                                            <ul class="list-unstyled ad-prof mrg-tp-20">
                                                <li><span
                                                        class="imgarea"><? /*= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile', 'class' => '']); */ ?></span> <span
                                                        class="img-desc"> <a title="KP123WERT" class="name" href="#">KP123WERT</a>
                        <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                        </span>

                                                    <div class="clearfix"></div>
                                                </li>
                                                <li><span
                                                        class="imgarea"><? /*= Html::img('@web/images/profile2.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile', 'class' => '']); */ ?></span> <span
                                                        class="img-desc"> <a title="KP123WERT" class="name" href="#">KP123WERT</a>
                        <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                        </span>

                                                    <div class="clearfix"></div>
                                                </li>
                                                <li><span
                                                        class="imgarea"><? /*= Html::img('@web/images/profile3.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile', 'class' => '']); */ ?></span> <span
                                                        class="img-desc"> <a title="KP123WERT" class="name" href="#">KP123WERT</a>
                        <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                        </span>

                                                    <div class="clearfix"></div>
                                                </li>
                                            </ul>
                                            <div class="text-right"><a title="View All" href="#">View All &gt;</a></div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <!-- <? /*= $this->render('/layouts/parts/_rightbar.php', ['SimilarProfile' => $SimilarProfile]) */ ?> -->

                    </div>
                </div>
            </section>
        <!-- <div class="modal fade" id="privacyoption" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <p class="text-center mrg-bt-10">
                        <img src="<? /*= CommonHelper::getLogo() */ ?>" width="157" height="61" alt="logo"></p>

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span> <span
                                    class="sr-only">Close</span></button>
                            <h2 class="text-center" id="model_heading">Set Privacy Options For Your Profile</h2>
                        </div>
                        <div class="modal-body">
                            <div class="choose-photo">
                                <?php /*$form = ActiveForm::begin(); */ ?>
                                <div class="form-cont">
                                    <div class="radio dl" id="IVA">
                                        <dt></dt>
                                        <dd data-ng-init="user_privacy_option=<? /*= $model->user_privacy_option */ ?>">
                                            <? /*= $form->field($model, 'user_privacy_option')->RadioList(
                                                ['0' => 'Visible to all', '1' => 'Visible only to members whom I had contacted / responded'],
                                                [
                                                    'item' => function ($index, $label, $name, $checked, $value) {
                                                        $checked = ($checked) ? 'checked' : '';
                                                        $return = '<input data-ng-model="user_privacy_option" type="radio" id="user_privacy_option_' . $value . '" name="' . $name . '" value="' . $value . '" ngValue="' . $checked . '">';
                                                        $return .= '<label for="user_privacy_option_' . $value . '">' . ucwords($label) . '</label>';
                                                        return $return;
                                                    }

                                                ]
                                            )->label(false); */ ?>
                                        </dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <a href="javascript:void(0)"
                                           class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right "
                                           id="privacysetting" data-ng-click="changePrivacy()">
                                            Save </a>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                                        <a href="javascript:void(0)"
                                           class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left"
                                           data-dismiss="modal"> Back </a>
                                    </div>
                                </div>
                                <?php /*ActiveForm::end(); */ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </main>
    </div>
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
                            <h6 class="mrg-bt-30 font-15 text-dark">
                                <strong><?= Yii::$app->params['sendInterest'] ?></strong>
                            </h6>
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
                                        <input type="hidden" id="send_request_id" value="">
                                        <input type="hidden" id="send_request_parentid" value="">
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
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/jquery.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?=$this->registerJsFile(Yii::$app->request->baseUrl.'/js/angular/controller/dashboardController.js', ['depends' => [\frontend\assets\AppAsset::className()],'position' => \yii\web\View::POS_END]);?>
    <script type="text/javascript">
        var PRO_COMP = <?=$PROFILE_COMPLETENESS?>;
    </script>

<?php
if ($type != '' && base64_decode($type) == "VERIFICATION-DONE") {
    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification("S", "VERIFICATION_COMPLETED");
    $this->registerJs('
        notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
    ');
}
$this->registerJs('
$(document).on("click",".send_request",function(e){
  Pace.restart();
  loaderStart();
  var formData1 = new FormData();
  formData1.append("ToUserId", $("#send_request_id").val());
  formData1.append("Action", "SEND_INTEREST");
  formData1.append("Name", $("#to_name").text());
  formData1.append("RGNumber", $("#to_rg_number").text());
  sendRequestDashboard("' . Url::to(['user/send-int-dashboard']) . '",".requests","SI",$("#send_request_parentid").val(),formData1);
  //sendRequestDashboard("' . Url::to(['user/send-int-dashboard']) . '",".requests","SI",$(this).data("parentid"),formData1);
});
$(document).on("click",".a_b_d",function(e){
  Pace.restart();
  loaderStart();
  var formData = new FormData();
  formData.append("ToUserId", $("#a_b_d_id").val());
  formData.append("Name", $(".to_name").text());
  formData.append("RGNumber", $(".to_rg_number").text());
  formData.append("Action",  $("#a_b_d_type").val());
  sendRequestDashboard("' . Url::to(['user/user-request']) . '",".requests","R_A_D_B",$("#a_b_d_parentid").val(),formData);
  //sendRequestDashboard("' . Url::to(['user/user-request']) . '",".requests","R_A_D_B",$(this).data("parentid"),formData);
});


');
?>
<?php require_once __DIR__ . '/_useroperation.php'; ?>

<?php #For Profile Photo Start
require_once __DIR__ . '/_photosection.php';
?>
<link href='<?= Yii::$app->request->baseUrl ?>/plugings/cropping/imgareaselect.css' rel='stylesheet' type='text/css'>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/cropping/jquery.imgareaselect.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/cropping/jquery.form.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php #For Profile Photo END ?>

<link href='<?= Yii::$app->request->baseUrl ?>/plugings/meter/css/asPieProgress.css' rel='stylesheet' type='text/css'>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/meter/js/jquery-asPieProgress.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php
$this->registerJs("
$('.pie_progress').asPieProgress({
        namespace: 'pie_progress'
      });
	  $('.pie_progress').asPieProgress('go', PRO_COMP+'%');
    ");
?>
<style type="text/css">

    .pie_progress {
        width: 160px;
        margin: 10px auto;
    }

    @media all and (max-width: 768px) {
        .pie_progress {
            width: 80%;
            max-width: 300px;
        }
    }
</style>