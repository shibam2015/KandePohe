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
/*$religion_data = CommonHelper::getReligion();
$community_data = CommonHelper::getCommunity();*/

// var_dump($id = Yii::$app->user->identity->id);
$id = 0;
$PROFILE_COMPLETENESS = 0;
if (!Yii::$app->user->isGuest) {
#$id = base64_decode($id);
    $id = Yii::$app->user->identity->id;
    $PROFILE_COMPLETENESS = $this->context->profileCompleteness($model->completed_step);
}

$HOME_URL = Yii::getAlias('@web')."/";
$HOME_URL_SITE = Yii::getAlias('@web')."/site/";
$UPLOAD_DIR = Yii::getAlias('@frontend') .'/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') .'/web/';

?>

    <link rel="stylesheet" type="text/css" href="<?= $HOME_URL ?>css/radical-progress.css"/>
    <!-- Custom styles for this template -->
    <!-- <link rel="stylesheet" type="text/css" href="css/cs-select.css" />
    <link rel="stylesheet" type="text/css" href="css/radical-progress.css" />
    <link rel="stylesheet" type="text/css" href="css/cs-skin-border.css" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet"> -->
    <!--<div class="wrapper">-->
    <div class="">
        <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
        <main>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="pr">
                                        <div class="cover-pic">
                                            <div class="dropdown">
                                                <button class="btn edit dropdown-toggle" type="button"
                                                        data-toggle="dropdown"><i class="fa fa-pencil"></i></button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    <li><a href="#">Choose from My Photos</a></li>
                                                    <li><a href="#">Upload Photo</a></li>
                                                    <li><a href="#">Reposition</a></li>
                                                    <li><a href="#">Delete Photo</a></li>
                                                </ul>
                                            </div>
                                            <?= Html::img('@web/images/profile-bg.jpg', ['class' => 'img-responsive', 'alt' => 'Profile image example']); ?>
                                        </div>
                                        <div class="pr-inner">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="im-pc">
                                                        <div class="image">
                                                            <div class="placeholder text-center">
                                                                <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->user->identity->propic, 200), ['class' => 'img-responsive mainpropic', 'width' => '200', 'height' => '200', 'alt' => 'Profile Pic']); ?>

                                                                <div class="add-photo" data-toggle="modal"
                                                                     data-target="#photo"><span
                                                                        class="file-input btn-file"> <i
                                                                            class="fa fa-plus-circle"></i> Add a photo </span>
                                                                </div>
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
                                                                        <li><a href="#" data-target="#hideProfile"
                                                                               data-toggle="modal"><i
                                                                                    class="fa fa-eye-slash"></i> Hide
                                                                                Profile</a></li>
                                                                        <li><a href="#" data-target="#deleteProfile"
                                                                               data-toggle="modal"><i
                                                                                    class="fa fa-times"></i> Delete
                                                                                Profile</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <ul class="list-inline minor-control">
                                                                        <?php
                                                                        $USER_FACEBOOK = \common\models\User::wightegeCheck(11);
                                                                        $USER_PHONE = \common\models\User::wightegeCheck(8);
                                                                        $USER_EMAIL = \common\models\User::wightegeCheck(9);
                                                                        $USER_APPROVED = \common\models\User::wightegeCheck(10);
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
                                                            <div class="numbers"><span>-</span><span>0% Complete</span>
                                                                <?php for ($i = 1; $i <= 100; $i++) { ?>
                                                                    <span><?= $i ?>% Complete</span>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <p>Complete your profile for better search results</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="panel no-border padd-hr-10 panel-default panel-friends">
                                            <div class="panel-heading"><a href="#" class="pull-right text-muted">4/5</a>
                                                <h3 class="panel-title text-muted mrg-bt-10">Add Tags</h3>
                                                <a href="#" class="text-muted">Add more tags</a></div>
                                            <div class="panel-body no-padd text-center">
                                                <div class="bootstrap-tagsinput"><span class="tag label label-danger">Spritual <i
                                                            data-role="remove" class="fa fa-times"></i></span> <span
                                                        class="tag label label-danger">Homely <i data-role="remove"
                                                                                                 class="fa fa-times"></i></span>
                                                    <span class="tag label label-danger">Music Lover <i
                                                            data-role="remove" class="fa fa-times"></i></span> <span
                                                        class="tag label label-danger">Well Educated <i
                                                            data-role="remove" class="fa fa-times"></i></span></div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="panel no-border padd-hr-10 panel-default panel-friends">
                                            <div class="panel-heading"><a href="#" class="pull-right">Add All</a>
                                                <h3 class="panel-title text-muted">Text Suggestions</h3>
                                            </div>
                                            <div class="panel-body no-padd text-center">
                                                <div class="bootstrap-tagsinput"><span class="tag label label-default">Traveller </span>
                                                    <span class="tag label label-default">Romantic </span> <span
                                                        class="tag label label-default">Adventurous </span> <span
                                                        class="tag label label-default">Foodie </span> <span
                                                        class="tag label label-default">Talkative </span></div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <?php if (count($photo_model) > 0) { ?>
                                            <div class="panel no-border panel-default panel-friends">
                                                <div class="panel-heading">
                                                    <h3 class="heading-xs"> Photos <span
                                                            class="text-danger">(<?= count($photo_model) ?>)</span></h3>
                                                </div>
                                                <div class="panel-body text-center">
                                                    <ul class="friends">
                                                        <?php foreach ($photo_model as $K => $V) { ?>
                                                            <li><a href="#">
                                                                    <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name'], 75), ['class' => 'img-responsive tip', 'alt' => $V['File_Name'] . $K, 'style' => "height:72px;"]); ?>
                                                                </a></li>
                                                        <?php } ?>
                                                    </ul>
                                                    <span class="pull-right"><a href="#" data-toggle="modal"
                                                                                data-target="#photo">View all photos</a></span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <ul class="nav nav-tabs bg-white my-profile" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab1" aria-controls="home"
                                                                                  role="tab" data-toggle="tab">Home</a>
                                        </li>
                                        <li role="presentation"><a href="#tab2" aria-controls="profile" role="tab"
                                                                   data-toggle="tab">Partner Preferences</a></li>
                                        <li role="presentation"><a href="#tab3" aria-controls="profile" role="tab"
                                                                   data-toggle="tab"> Contact Details</a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content my-profile">
                                        <div role="tabpanel" class="tab-pane active" id="tab1">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation"><a href="javascript:void(0)"
                                                                               class="edit_btn" attr-name="my_info"><i
                                                                class="fa fa-pencil"></i> Edit</a></li>
                                                </ul>
                                            </div>
                                            <div class="inner-block">
                                                <div class="fb-profile-text padd-xs padd-tp-0">
                                                    <h1><span class="heading-icons icon9"></span> My Information</h1>
                                                </div>
                                                <p class="dis_my_info"><?= $model->tYourSelf; ?></p>
                                            </div>
                                            <div class="divider"></div>
                                            <div class="inner-block">
                                                <div class="profile-edit pull-right">
                                                    <ul class="list-inline major-control">
                                                        <li role="presentation"><a href="#"><i class="fa fa-pencil"></i>
                                                                Edit</a></li>
                                                    </ul>
                                                </div>
                                                <h3><span class="heading-icons icon2"></span> Personal information</h3>
                                                <dl class="dl-horizontal">
                                                    <dt>Name</dt>
                                                    <dd><?= $model->FullName; ?>
                                                    <dd>
                                                    <dt>Profile created by</dt>
                                                    <dd>Self</dd>
                                                    <dt>Age</dt>
                                                    <dd>30 years
                                                    <dd>
                                                    <dt>Height</dt>
                                                    <dd><?= $model->height->vName ?></dd>
                                                    <dt>Weight</dt>
                                                    <dd>76 kgs/ 172 lbs</dd>
                                                    <dt>Physical status</dt>
                                                    <dd>Normal</dd>
                                                    <dt>Mother tongue</dt>
                                                    <dd>Marathi</dd>
                                                    <dt>Marital status</dt>
                                                    <dd><?= $model->maritalStatusName->vName; ?></dd>
                                                </dl>
                                            </div>
                                            <div class="divider"></div>
                                            <div class="inner-block">
                                                <div class="profile-edit pull-right">
                                                    <ul class="list-inline major-control">
                                                        <li role="presentation"><a href="#"><i class="fa fa-pencil"></i>
                                                                Edit</a></li>
                                                    </ul>
                                                </div>
                                                <h3><span class="heading-icons icon2"></span> Basic information</h3>
                                                <dl class="dl-horizontal">
                                                    <dt>Religion</dt>
                                                    <dd><?= $model->religionName->vName; ?>
                                                    <dd>
                                                    <dt>Community</dt>
                                                    <dd><?= $model->communityName->vName; ?></dd>
                                                    <dt>Sub Community</dt>
                                                    <dd><?= $model->subCommunityName->vName; ?>
                                                    <dd>
                                                    <dt>Marital Status</dt>
                                                    <dd><?= $model->maritalStatusName->vName; ?></dd>
                                                    <dt>Gotra</dt>
                                                    <dd><?= $model->gotraName->vName; ?></dd>
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
                                            <div class="divider"></div>
                                            <div class="inner-block">
                                                <div class="profile-edit pull-right">
                                                    <ul class="list-inline major-control">
                                                        <li role="presentation"><a href="#"><i class="fa fa-pencil"></i>
                                                                Edit</a></li>
                                                    </ul>
                                                </div>
                                                <h3><span class="heading-icons icon2"></span> Educational & Occupational
                                                </h3>
                                                <dl class="dl-horizontal">
                                                    <dt>Education Level</dt>
                                                    <dd><?= $model->educationLevelName->vEducationLevelName; ?>
                                                    <dd>
                                                    <dt>Education Field</dt>
                                                    <dd><?= $model->educationFieldName->vEducationFieldName; ?></dd>
                                                    <dt>Sub Community</dt>
                                                    <dd><?= $model->communityName->vName; ?>
                                                    <dd>
                                                    <dt>Working With</dt>
                                                    <dd><?= $model->workingWithName->vWorkingWithName; ?></dd>
                                                    <dt>Woking As</dt>
                                                    <dd><?= $model->workingAsName->vWorkingAsName; ?></dd>
                                                    <dt>Annual Income</dt>
                                                    <dd><?= $model->annualIncome->vAnnualIncome; ?></dd>
                                                </dl>
                                            </div>
                                            <div class="divider"></div>
                                            <div class="inner-block">
                                                <div class="profile-edit pull-right">
                                                    <ul class="list-inline major-control">
                                                        <li role="presentation"><a href="#"><i class="fa fa-pencil"></i>
                                                                Edit</a></li>
                                                    </ul>
                                                </div>
                                                <h3><span class="heading-icons icon2"></span> Lifestyle & Appearance
                                                </h3>
                                                <dl class="dl-horizontal">
                                                    <dt>Height</dt>
                                                    <dd><?= $model->height->vName ?>
                                                    <dd>
                                                    <dt>Skin Tone</dt>
                                                    <dd><?= $model->vSkinTone; ?></dd>
                                                    <dt>Body type</dt>
                                                    <dd><?= $model->vBodyType; ?>
                                                    <dd>
                                                    <dt>Smoke</dt>
                                                    <dd><?= $model->vSmoke; ?></dd>
                                                    <dt>Drink</dt>
                                                    <dd><?= $model->vDrink; ?></dd>
                                                    <dt>Spectacles/Lens</dt>
                                                    <dd><?= $model->vSpectaclesLens; ?></dd>
                                                    <dt>Diet</dt>
                                                    <dd><?= $model->dietName->vName; ?></dd>
                                                </dl>
                                            </div>
                                            <div class="divider"></div>
                                            <div class="inner-block">
                                                <div class="profile-edit pull-right">
                                                    <ul class="list-inline major-control">
                                                        <li role="presentation"><a href="#"><i class="fa fa-pencil"></i>
                                                                Edit</a></li>
                                                    </ul>
                                                </div>
                                                <h3><span class="heading-icons icon2"></span> Family</h3>
                                                <dl class="dl-horizontal">
                                                    <dt>Father Status</dt>
                                                    <dd><?= $model->fatherStatus->vName ?>
                                                    <dd>
                                                    <dt>Father Working As</dt>
                                                    <dd><?= $model->fatherStatusId->vWorkingAsName; ?></dd>
                                                    <dt>Mother Status</dt>
                                                    <dd><?= $model->motherStatus->vName ?>
                                                    <dd>
                                                    <dt>Mother Working As</dt>
                                                    <dd><?= $model->motherStatusId->vWorkingAsName; ?></dd>
                                                    <dt>No of Brothers</dt>
                                                    <dd><?= $model->nob; ?></dd>
                                                    <dt>No of Sisters</dt>
                                                    <dd><?= $model->nos; ?></dd>
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
                                                    <dt>Native Place</dt>
                                                    <dd><?= $model->vNativePlaceCA ?></dd>
                                                    <dt>Parents Residing At</dt>
                                                    <dd><?= $model->vParentsResiding ?></dd>
                                                    <dt>Family Affluence Level</dt>
                                                    <dd><?= $model->vFamilyAffluenceLevel; ?></dd>
                                                    <dt>Family Type</dt>
                                                    <dd><?= $model->vFamilyType ?></dd>
                                                    <dt>Property Details</dt>
                                                    <dd><?= $model->vFamilyProperty ?></dd>
                                                    <dt>You can enter your relative surnames etc</dt>
                                                    <dd><?= $model->vAreaName ?></dd>
                                                </dl>
                                            </div>
                                        </div>


                                        <div role="tabpanel" class="tab-pane" id="tab2">Tab 2</div>
                                        <div role="tabpanel" class="tab-pane" id="tab3">Tab 3</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $this->render('/layouts/parts/_rightbar.php') ?>
                    </div>
                </div>
            </section>
        </main>
        <!--  <footer>
            <div class="legal">
              <p>© 2016 Kande Pohe.com. All Rights Reserved.</p>
            </div>
          </footer>-->
    </div>
    <div class="chatwe">
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne"
                 id="chatbox"><i class="fa fa-comment"></i> Members Online
            </div>
            <div class="panel-collapse collapse" id="collapseOne">
                <div class="panel-body">
                    <ul class="list-unstyled ad-prof">
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                        <li class="active"><span
                                class="imgarea"><?= Html::img('@web/images/profile2.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="online"></span> </li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile3.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile1.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile2.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile3.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group"> <span class="input-group-btn">
          <button class="btn btn-default btn-sm" id="btn-chat"><span class="glyphicon glyphicon-search"></span></button>
          </span>
                        <input id="btn-input" type="text" class="form-control input-sm"
                               placeholder="Type your message here..."/>
                        <span class="input-group-btn dropup">
          <button class="btn btn-default btn-sm" id="btn-chat"><i class="fa fa-pencil-square-o"></i></button>
          <button class="btn btn-default btn-sm" id="btn-chat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i> </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
          </ul>
          </span> </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Photo -->
    <div class="modal fade" id="photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10"><img src="<?= CommonHelper::getLogo() ?>" width="157" height="61"
                                                  alt="logo"></p>
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        <span
                            class="sr-only">Close</span></button>
                    <h2 class="text-center">My Photo Gallery</h2>
                    <div class="profile-control photo-btn">
                        <button class="btn " type="button"> Upload Video or Photo</button>
                        <button class="btn active" type="button"> Choose from Photos</button>
                        <button class="btn" type="button"> Albums</button>
                    </div>
                </div>
                <!-- Modal Body -->
                <div class="modal-body photo-gallery">
                    <div class="choose-photo">
                        <div class="row" id="profile_list_popup">
                            <?php
                            if (count($photo_model) > 0) {
                                foreach ($photo_model as $K => $V) {
                                    ?>
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <?php $SELECTED = '';
                                        if ($V['Is_Profile_Photo'] == 'YES') {
                                            $SELECTED = "selected";
                                        } ?>
                                        <a href="javascript:void(0)" class="pull-left profile_set"
                                           data-id="<?= $V['iPhoto_ID'] ?>"
                                           data-target="#photodelete" data-toggle="modal">
                                            <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name'], 140), ['class' => 'img-responsive ' . $SELECTED, 'height' => '140', 'alt' => 'Photo' . $K, 'style' => "height:140px;"]); ?>
                                        </a>
                                    </div>
                                    <!-- <div class="col-md-3 col-sm-3 col-xs-6">
                                    <a href="javascript:void(0)" class="pull-left profile_set" data-id="<?= $V['iPhoto_ID'] ?>"
                                       data-target="#photodelete" data-toggle="modal">
                                        Profile pic
                                    </a>
                                </div>
-->
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
    <div class="modal fade" id="photodelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10">
                <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo"></p>
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        <span
                            class="sr-only">Close</span></button>
                    <h2 class="text-center" id="model_heading"></h2>
                </div>
                <!-- Modal Body -->
                <div class="modal-body photo-gallery">
                    <div class="choose-photo">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <a href="javascript:void(0)"
                                   class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right yes"> Yes </a>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 ">
                                <a href="javascript:void(0)"
                                   class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left"
                                   data-dismiss="modal"> No </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Footer -->
        </div>
    </div>
    <script type="text/javascript">
        var PRO_COMP = <?=$PROFILE_COMPLETENESS?>;
    </script>
    <script src="<?= $HOME_URL ?>js/selectFx.js"></script>
<?php
$this->registerJs('
  $(".edit_btn").click(function(e){
      $.ajax({
        url : "'.Url::to(['user/edit-myinfo']).'",
        type:"GET",
        data:{},
        success:function(res){
          $(".dis_my_info").html(res);
        }
      });
  });
  
        var P_ID = "";
        var P_TYPE = "";
        function profile_photo(){
        $(".profile_delete").click(function(){
                P_ID = $(this).data("id");
                P_TYPE = "PHOTO_DELETE";
                $("#model_heading").html("Are you sure want to delete this photo ?");
        })
        $(".profile_set").click(function(){
                P_ID = $(this).data("id");
                P_TYPE = "PHOTO_PROFILE_SET";
                $("#model_heading").html("Are you sure want to set this photo as profile photo?");
        })
        }
        profile_photo();
        
        $(".yes").click(function(){
            Pace.restart();
            var formDataPhoto = new FormData();
            formDataPhoto.append( "P_ID", P_ID);
            formDataPhoto.append( "P_TYPE", P_TYPE);    
                $.ajax({
                        url: "photo-operation",
                        type: "POST",
                        data: formDataPhoto,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            var DataObject = JSON.parse(data);
                            if (DataObject.STATUS == "SUCCESS") {
                                if(P_TYPE=="PHOTO_PROFILE_SET"){
                                    $("#photo_list").html(DataObject.OUTPUT);
                                    $("#profile_list_popup").html(DataObject.OUTPUT_ONE);
                                    $(".mainpropic").attr("src", DataObject.PROFILE_PHOTO);
                                    $(".profile_photo_one").attr("src", DataObject.PROFILE_PHOTO_ONE);
                                    notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                                }else{
                                    $("#photo_list").html(DataObject.OUTPUT);
                                    $("#profile_list_popup").html(DataObject.OUTPUT_ONE);
                                    if(DataObject.PROFILE_PHOTO != ""){
                                        $(".mainpropic").attr("src", DataObject.PROFILE_PHOTO);
                                    }
                                    if(DataObject.PROFILE_PHOTO_ONE != ""){
                                        $(".profile_photo_one").attr("src", DataObject.PROFILE_PHOTO_ONE);
                                    }
                                    notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                                }
                            } else {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                            }
                                                                
                        profile_photo();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        alert("Request Failed");
                        }
                    });
        })
  ');

