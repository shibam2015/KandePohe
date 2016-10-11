<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\helpers\ArrayHelper;
?>
<div class="main-section">
    <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <?php if ($flag) { ?>
                        <div class="padd-xs mrg-tp-10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <ul class="list-inline pull-right">
                                        <li><a href="#"><i class="fa fa-angle-left"></i> Previous Profile </a></li>
                                        <li><a href="#">Next Profile <i class="fa fa-angle-right"></i></a></li>
                                    </ul>
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
                                                <div class="carousel-inner">
                                                    <?php if (count($PhotoList) > 0) {
                                                        foreach ($PhotoList as $K => $V) {
                                                            $SELECTED = '';
                                                            if ($V['Is_Profile_Photo'] == 'YES') {
                                                                $SELECTED = "active";
                                                            } ?>
                                                            <div class="item <?= $SELECTED ?>">
                                                                <?= Html::img(CommonHelper::getPhotos('USER', $model->id, $V['File_Name'], 140), ['width' => '205', 'height' => '205', 'alt' => 'Profile', 'class' => 'img-responsive']); ?>
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="item active">
                                                            <?= Html::img(CommonHelper::getPhotos('USER', $model->id, 'no-photo.jpg', 140), ['width' => '205', 'height' => '205', 'alt' => 'Profile', 'class' => 'img-responsive']); ?>
                                                        </div>
                                                    <?php } ?>

                                                </div>
                                                <!-- Controls -->
                                                <?php if (count($PhotoList) > 0) { ?>
                                                    <a class="left carousel-control" href="#carousel-example-generic"
                                                       data-slide="prev"> <span
                                                            class="glyphicon glyphicon-chevron-left"></span> </a> <a
                                                        class="right carousel-control" href="#carousel-example-generic"
                                                        data-slide="next"> <span
                                                            class="glyphicon glyphicon-chevron-right"></span>
                                                    </a>         <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (count($PhotoList) > 0) { ?>
                                        <p class="text-right"><a href="#" data-toggle="modal" data-target="#photo">View
                                                Album <i class="fa fa-angle-right"></i></a></p>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-9">
                                    <div class="name-panel">
                                        <h2 class="nameplate"><?= $model->FullName; ?><span
                                                class="font-light">(<?= CommonHelper::setInputVal($model->Registration_Number, 'text') ?>
                                                )</span></h2>

                                        <p>Profile created by <?= $model->Profile_created_for; ?> | Last online 2:36
                                            pm</p>
                                        <!-- TODO: Set Last login time and profile creted by -->
                                    </div>
                                    <div class="profile-control">
                                        <button type="button" class="btn active" data-target="#sendInterest"
                                                data-toggle="modal"> Send Interest <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="btn"> Shortlist <i class="fa fa-list-ul"></i>
                                        </button>
                                        <button type="button" class="btn"> Block <i class="fa fa-ban"></i></button>
                                        <!--<button type="button" class="btn"> No <i class="fa fa-thumbs-o-down"></i></button>-->
                                    </div>
                                    <dl class="dl-horizontal mrg-tp-20">
                                        <dt>Personal Details</dt>
                                        <dd><?= CommonHelper::getAge($model->DOB); ?> years,
                                            <?= CommonHelper::setInputVal($model->height->vName, 'text'); ?>, Capricorn
                                            <!-- TODO : Raashi -->
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
                                                <a href="<?= Yii::$app->homeUrl ?>/payment/payment?source=profile_callsmsnow&uk=<?= $model->Registration_Number ?>"
                                                   target="_blank"><i class="fa">
                                                        <?= Html::img('@web/images/call.png', ['width' => '', 'height' => '', 'alt' => 'call']); ?>
                                                    </i> Call/ Send SMS</a></li>
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
                                            <h3><span class="heading-icons icon1"></span> About</h3>

                                            <p>
                                                <?php if ($model->tYourSelf != '') { ?>
                                                    <?= $model->tYourSelf; ?>
                                                <?php } else { ?>
                                                    Information Not Available
                                                <?php } ?>
                                            </p>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon2"></span> Lifestyle &amp; Appearance
                                            </h3>
                                            <dl class="dl-horizontal">
                                                <dt>Food Habbits</dt>
                                                <dd><?= CommonHelper::setInputVal($model->dietName->vName, 'text') ?>
                                                <dd>

                                                <dt>Drinking Habit</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vDrink, 'text') ?>
                                                <dd>

                                                <dt>Smoking Habit</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vSmoke, 'text') ?>
                                                <dd>

                                                <dt>Looks &amp; Appearance</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vSkinTone, 'text') . ', ' . CommonHelper::setInputVal($model->vBodyType, 'text') ?>
                                                <dd>


                                            </dl>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon2"></span> Background</h3>
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
                                                <dt>Current Location</dt>
                                                <dd><?= CommonHelper::setInputVal($model->cityName->vCityName, 'text') . ', ' . CommonHelper::setInputVal($model->stateName->vStateName, 'text') . ', ' . CommonHelper::setInputVal($model->countryName->vCountryName, 'text') ?></dd>
                                                <dt>Distict</dt>
                                                <dd><?= $model->districtName->vName; ?></dd>
                                                <dt>Taluks</dt>
                                                <dd><?= $model->talukaName->vName; ?></dd>
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
                                            <h3><span class="heading-icons icon3"></span> Horoscope Details</h3>
                                            <figcaption class="mrg-tp-30 horo-wrap">
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
                                                <?= Html::img('@web/images/prof-img.jpg', ['width' => '', 'height' => '', 'alt' => 'email', 'class' => 'img-responsive']); ?>
                                            </figcaption>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon5"></span> Family Detail</h3>
                                            <dl class="dl-horizontal">
                                                <dt>Father</dt>
                                                <dd><?= CommonHelper::setInputVal($model->fatherStatusId->vWorkingAsName, 'text') ?>
                                                <dd>
                                                <dt>Mother</dt>
                                                <dd><?= CommonHelper::setInputVal($model->motherStatusId->vWorkingAsName, 'text') ?></dd>
                                                <dt>Siblings</dt>
                                                <dd><?= $model->nob . ' Brother(s) & ' . $model->nos . ' Sister(s)' ?></dd>
                                                <dt>Family Class</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vFamilyAffluenceLevel, 'text') ?></dd>

                                                <dt>Native Place</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vNativePlaceCA, 'text') ?></dd>

                                                <dt>Traditionl Values</dt>
                                                <dd><?= CommonHelper::setInputVal($model->vFamilyType, 'text') ?></dd>
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
                                            <p>To view details about <strong>College and Company</strong> working at:
                                                <span class="mrg-lt-15"><a href="#">Upgrade Now!</a></span></p>
                                        </div>
                                        <div class="inner-block">
                                            <h3><span class="heading-icons icon7"></span> Interests &amp; More</h3>
                                            <dl class="dl-horizontal">
                                                <dt>Hobbies &amp; Other Interests</dt>
                                                <dd>Dancing, Travelling, Singing, Eating, Reading, Sports Activities
                                                    <!-- TODO: set Hobbies and display -->
                                                <dd>
                                            </dl>
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
                                                    <div class="col-sm-5 text-center"> Your Match Compatibility is<br>
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
                                            <!--<h3><span class="heading-icons icon2"></span> Background</h3>-->
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
                                                <dt>Marital Status</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersMaritalStatus->maritalStatusName->vName, 'text') ?>
                                                <dd>
                                                <dt>Gotra</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersGotra->gotraName->vName, 'text') ?>
                                                <dd>
                                                <dt>Father Status</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersFathersStatus->fatherStatus->vName, 'text') ?>
                                                <dd>
                                                <dt>Mother Status</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersMothersStatus->motherStatus->vName, 'text') ?>
                                                <dd>
                                                <dt>Education Level</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersEducationalLevel->educationLevelName->vEducationLevelName, 'text') ?>
                                                <dd>
                                                <dt>Education Field</dt>
                                                <dd><?= CommonHelper::setInputVal($PartnersEducationField->educationFieldName->vEducationFieldName, 'text') ?>
                                                <dd>

                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?php } else { ?>
                        <div class="padd-xs mrg-tp-10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <ul class="list-inline pull-right">
                                        <li><a href="<?= Yii::$app->homeUrl ?>"><i class="fa fa-angle-left"></i> Back to
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
                                        <div class="clearfix"></div>
                                        <p><?= $Message ?></p>

                                        <!--<div class="row">
                                            <div class="col-sm-12">-->
                                        <ul class="list-inline pull-right">
                                            <li><a href="<?= Yii::$app->homeUrl ?>user/my-profile"><i
                                                        class="fa fa-angle-left"></i> My Profile </a></li>
                                            <li><a href="<?= Yii::$app->homeUrl ?>user/dashboard">My Dashboard <i
                                                        class="fa fa-angle-right"></i></a></li>
                                        </ul>
                                        <!--</div>
                                    </div>-->

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    <?php } ?>

                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="row">
                        <div class="bg-white aside padd-20">
                            <div class="ad-title">Similar Profiles</div>
                            <ul class="list-unstyled ad-prof">
                                <li><span
                                        class="imgarea"> <?= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?></span> <span
                                        class="img-desc">
                  <p class="name"><strong>Ishita J</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>

                                    <div class="clearfix"></div>
                                </li>
                                <li><span
                                        class="imgarea"> <?= Html::img('@web/images/profile2.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?></span> <span
                                        class="img-desc">
                  <p class="name"><strong>Arathi B</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>

                                    <div class="clearfix"></div>
                                </li>
                                <li><span
                                        class="imgarea"> <?= Html::img('@web/images/profile3.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?></span> <span
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
                                <?= Html::img('@web/images/image1.jpg', ['width' => '', 'height' => '', 'alt' => 'Image', 'class' => 'img-responsive']); ?>
                            </div>
                            <span class="pull-right"><a href="#" class="text-right">Read All Stories <i
                                        class="fa fa-angle-right"></i></a></span>

                            <div class="clearfix"></div>
                            <div class="border"></div>
                            <div class="ad-title">Interest Accepted</div>
                            <ul class="list-unstyled ad-prof">
                                <li> <span class="imgarea">
                    <?= Html::img('@web/images/profile4.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?>
                  </span> <span class="img-desc">
                  <p class="name">Mrunmal Sawant</p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>

                                    <div class="clearfix"></div>
                                </li>
                                <li> <span class="imgarea">
                    <?= Html::img('@web/images/heart.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile']); ?>
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
                </div>
            </div>
            <?php if ($flag) { ?>
                <div class="mrg-bt-10">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="pull-left"><a href="#">Back to Top</a></div>
                            <div class="pull-right"><a href="#"> <i class="fa fa-angle-left"></i> Previous Profile</a>
                                &nbsp; &nbsp; &nbsp; &nbsp; <a href="#">Next Profile <i class="fa fa-angle-right"></i>
                                </a></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</div>
<!-- Modal Photo -->
<div class="modal fade" id="photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10"><img src="<?= CommonHelper::getLogo() ?>" width="157" height="61"
                                              alt="logo"></p>

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

        <!-- Modal Footer -->

    </div>

</div>
<div class="modal fade" id="sendInterest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                </button>
                <h4 class="text-center"> Send Interest </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form>
                    <div class="text-center">
                        <p class="mrg-bt-10 font-15"><span class="text-success"><strong>&#10003;</strong></span> Your
                            interest has been sent successfully to</p>

                        <div class="fb-profile-text mrg-bt-30 text-dark">
                            <h1>Swapnil Kanherkar <span class="sub-text">(KP123456667)</span></h1>
                        </div>
                        <h6 class="mrg-bt-30 font-15 text-dark"><strong>Request the member to add the following
                                details</strong></h6>

                        <div class="checkbox mrg-tp-0 profile-control">
                            <input id="Photo" type="checkbox" name="Photo" value="check1">
                            <label for="Photo" class="control-label">Photo</label>
                            <input id="Horoscope" type="checkbox" name="Horoscope" value="check1">
                            <label for="Horoscope" class="control-label">Horoscope</label>
                            <button type="button" class="btn active send_request"> Send Interest</button>
                        </div>
                    </div>
                    <div class="well">
                        <h6 class="font-15 text-dark"><strong> More Similar Profiles</strong> <a title="View All"
                                                                                                 class="pull-right"
                                                                                                 href="#">View All</a>
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
                        <label for="allinter" class="control-label"><a href="#">Send Interest to All</a></label>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
        </div>
    </div>
</div>

<script language="javascript" type="text/javascript">
    var userid = "<?=base64_encode(Yii::$app->user->identity->id)?>";
</script>


<?php
$this->registerJs('
$(document).on("click",".send_email",function(e){
        loaderStart();
         var formData = new FormData();
         formData.append("UserId", ' . $model->id . ');
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
');
?>

