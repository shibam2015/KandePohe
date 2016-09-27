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
                                    <div class="cover-pic" id="timelineContainer">
                                        <div class="dropdown">
                                            <button class="btn edit dropdown-toggle" type="button"
                                                    data-toggle="dropdown"><i class="fa fa-pencil"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="javascript:void(0)" data-toggle="modal"
                                                       data-target="#photo" id="choosecoverphoto">Choose from My
                                                        Photos</a></li>
                                                <li>
                                                    <a href="javascript:void(0)" id="coverphotoupload">Upload Photo</a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)" <?= ($model->cover_background_position != '') ? 'id="coverphotoreposition"' : 'id="coverphotoreposition1"'; ?> >Reposition</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" <?= ($model->cover_background_position != '') ? 'id="coverphotodelete"' : 'id="coverphotodelete1"'; ?>>Delete
                                                        Photo</a></li>
                                            </ul>
                                        </div>
                                        <div id="timelineBackground">
                                            <img src="<?php echo $COVER_PHOTO; ?>" class="bgImagecover"
                                                 style="margin-top: <?= $model->cover_background_position ?>;">
                                            <!-- $model->cover_background_position -->
                                        </div>
                                        <div id="timelineShade" style="display: none">
                                            <form id="bgimageform" method="post" enctype="multipart/form-data">
                                                <div class="uploadFile timelineUploadBG">
                                                    <input type="file" name="photoimg" id="bgphotoimgcover"
                                                           class=" custom-file-input"
                                                           original-title="Change Cover Picture">
                                                </div>
                                            </form>
                                        </div>

                                        <div id="timelineNav"></div>
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
                                                                    <li id="hideshow_a"><a href="javascript:void(0)"
                                                                                           data-target="#hideProfile"
                                                                                           data-toggle="modal"
                                                                                           class="hideshowmenu"
                                                                                           data-name="<?= $model->hide_profile ?>">
                                                                            <i class="fa <?= ($model->hide_profile == 'Yes') ? 'fa-eye' : 'fa-eye-slash'; ?>"></i> <?= ($model->hide_profile == 'Yes') ? 'Show' : 'Hide'; ?>
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
                                <?php Pjax::begin(['id' => 'refresh_index']); ?>
                                <?= Html::a("Refresh", ['user/my-profile'], ['class' => 'btn btn-lg btn-primary hidden']) ?>
                                <?php Pjax::end(); ?>
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
                                            <?php Pjax::begin(['id' => 'my_index', 'enablePushState' => false]); ?>
                                            <p class="dis_my_info"><?= $model->tYourSelf; ?></p>
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation">
                                                        <a href="javascript:void(0)" class="edit_personal_btn"
                                                           attr-name="my_info"><i class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon2"></span> Personal information</h3>
                                            <?php Pjax::begin(['id' => 'my_index1', 'enablePushState' => false]); ?>
                                            <div class="div_personal_info">
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
                                            <?php Pjax::end(); ?>

                                        </div>
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation"><a href="javascript:void(0)"
                                                                               class="edit_basic_information"
                                                                               attr-name="my_info"><i
                                                                class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon2"></span> Basic information</h3>
                                            <?php Pjax::begin(['id' => 'my_index2', 'enablePushState' => false]); ?>
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
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation">
                                                        <a href="javascript:void(0)" class="edit_education"
                                                           attr-name="my_info"><i class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon2"></span> Educational & Occupational
                                            </h3>
                                            <?php Pjax::begin(['id' => 'my_index3', 'enablePushState' => false]); ?>
                                            <div class="div_education">
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
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation">
                                                        <a href="javascript:void(0)" class="edit_lifestyle"
                                                           attr-name="my_info"><i class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon2"></span> Lifestyle & Appearance
                                            </h3>
                                            <?php Pjax::begin(['id' => 'my_index4', 'enablePushState' => false]); ?>
                                            <div class="div_lifestyle">
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
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation">
                                                        <a href="javascript:void(0)" class="edit_family"
                                                           attr-name="my_info"><i class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon2"></span> Family</h3>
                                            <?php Pjax::begin(['id' => 'my_index5', 'enablePushState' => false]); ?>
                                            <div class="div_family">
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
                                                    <dd><?= $model->countryNameCA->vCountryName; ?></dd>
                                                    <dt>State</dt>
                                                    <dd><?= $model->stateNameCA->vStateName; ?></dd>
                                                    <dt>City</dt>
                                                    <dd><?= $model->cityNameCA->vCityName; ?></dd>
                                                    <dt>Distict</dt>
                                                    <dd><?= $model->districtNameCA->vName; ?></dd>
                                                    <dt>Taluks</dt>
                                                    <dd><?= $model->talukaNameCA->vName; ?></dd>
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
                                            <?php Pjax::end(); ?>
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
                                    <a href="javascript:void(0)" class="pull-left profile_set cover_profile_set"
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
<div class="modal fade" id="photocovermodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                <h2 class="text-center" id="model_heading_cover"></h2>
            </div>
            <!-- Modal Body -->
            <div class="modal-body photo-gallery">
                <div class="choose-photo">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <a href="javascript:void(0)"
                               class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right yescover"> Yes </a>
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

<div class="modal fade" id="hideProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                <h2 class="text-center" id="model_heading_hideshow">
                    If You Want To Hide Your Profile!
                </h2>
            </div>
            <!-- Modal Body -->
            <div class="modal-body photo-gallery">
                <div class="choose-photo">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <a href="javascript:void(0)"
                               class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right hideshow"> Yes </a>
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
    $(".edit_personal_btn").click(function(e){
    $.ajax({
        url : "' . Url::to(['user/edit-personal-info']) . '",
        type:"GET",
        data:{},
        success:function(res){
          $(".div_personal_info").html(res);
        }
      });
  });
  $(".edit_basic_information").click(function(e){
    $.ajax({
        url : "' . Url::to(['user/edit-basic-info']) . '",
        type:"GET",
        data:{},
        success:function(res){
          $(".div_basic_info").html(res);
        }
      });
  });
  $(".edit_education").click(function(e){
    $.ajax({
        url : "' . Url::to(['user/edit-education']) . '",
        type:"GET",
        data:{},
        success:function(res){
          $(".div_education").html(res);
        }
      });
  });
  $(".edit_lifestyle").click(function(e){
    $.ajax({
        url : "' . Url::to(['user/edit-lifestyle']) . '",
        type:"GET",
        data:{},
        success:function(res){
          $(".div_lifestyle").html(res);
        }
      });
  });
  $(".edit_family").click(function(e){
    $.ajax({
        url : "' . Url::to(['user/edit-family']) . '",
        type:"GET",
        data:{},
        success:function(res){
          $(".div_family").html(res);
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
?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
<?php
#$this->registerJsFile($HOME_URL.'js/cover/jquery.min.js');
#$this->registerJsFile($HOME_URL.'js/cover/jquery-ui.min.js');
#$this->registerJsFile($HOME_URL.'js/cover/jquery.form.js');
?>
<?php $this->registerJs("
    $(document).ready(function()
    {
        $('#bgphotoimgcover').change(function () {
        Pace.restart();
        var tflag= 1;
            if (typeof (FileReader) != \"undefined\") {
                //var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg)$/;
                $($(this)[0].files).each(function () {
                    var file = $(this);
                    if (regex.test(file[0].name.toLowerCase())) {
                            $.ajax({
                                    type: 'POST',
                                    url: 'coverupload',
                                    data: '',
                                    mimeType: 'multipart/form-data',
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    beforeSend: function(){       Pace.restart(); },
                                    success: function(html)
                                    {
                                            var DATAV = JSON.parse(html);
                                            $('#timelineBackground').html(DATAV.ABC);
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                            $('#timelineBGload').attr('src', e.target.result);
                                        }
                                        reader.readAsDataURL(file[0]);
                                    },
                                     error:function(){
                                         notificationPopup('ERROR', 'Something went wrong. Please try again !');
                                    }
                            });
                    } else {
                        tflag= 0;
                        notificationPopup('ERROR', file[0].name + ' is not a valid image file.');
                        return false;
                    }
                });
            } else {
                notificationPopup('ERROR', 'This browser does not support HTML5 FileReader.');
            }
        });
		
        $('body').on('mouseover','.headerimage',function ()
        {
            var y1 = $('#timelineBackground').height();
            var y2 =  $('.headerimage').height();
            $(this).draggable({
                scroll: false,
                axis: 'y',
                drag: function(event, ui) {
                    if(ui.position.top >= 0)
                    {
                        ui.position.top = 0;
                    }
                    else if(ui.position.top <= y1 - y2)
                    {
                        ui.position.top = y1 - y2;
                    }
                },
                stop: function(event, ui)
                {
                }
            });
        });
        /* Banner Position Save*/
        $('body').on('click','.bgSave',function ()
        {
            var id = $(this).attr('id');
            var p = $('#timelineBGload').attr('style');
            var Y =p.split('top:');
            var Z=Y[1].split(';');
            var dataString ='position='+Z[0];
            var position = Z[0];
            /* Photo FIle Start */
                    var file = $('#bgphotoimgcover');
                    var formData = new FormData($('#bgimageform'));
                    formData.append( 'cover_photo', $('#bgphotoimgcover')[0].files[0]);
                    formData.append( 'position', position);
            /* Photo FIle END */
            $.ajax({
                type: 'POST',
                url: 'savecoverphoto',
                data: formData,
                mimeType: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){       Pace.restart(); },
                success: function(data)
                {
                    var DataObject = JSON.parse(data);
                    if (DataObject.STATUS == 'SUCCESS') {
                         $('#photo_list').html(DataObject.OUTPUT);
                         $('#profile_list_popup').html(DataObject.OUTPUT_ONE);
                         
                                
                         $('.bgImagecover').fadeOut('slow');
                         $('.bgSave').remove();
                         $('.bgCancel').remove();
                         $('#timelineShade').fadeIn('slow');
                         $('#timelineBGload').removeClass('headerimage');
                         $('#timelineBGload').removeClass('ui-corner-all');
                         $('#timelineBGload').addClass('bgImagecover');
                         $('#timelineBGload').css({'margin-top':position});
                         
                         $('#coverphotoreposition1').attr('id', 'coverphotoreposition');            
                         $('#coverphotodelete1').attr('id', 'coverphotodelete');     
                         notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                         return false;
                    } else {
                          notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                    }
                    profile_photo();
                }
            });
            return false;
        });

        $('body').on('click','.bgSaveRP',function ()
        {
            var id = $(this).attr('id');
            var p = $('#timelineBGload').attr('style');
            var Y =p.split('top:');
            var Z=Y[1].split(';');
            var dataString ='position='+Z[0];
            var position = Z[0];

            var formData = new FormData();
            formData.append( 'position', position);
            
            $.ajax({
                type: 'POST',
                url: 'savecoverphoto',
                data: formData,
                mimeType: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){       Pace.restart(); },
                success: function(data)
                {
                    var DataObject = JSON.parse(data);
                    if (DataObject.STATUS == 'SUCCESS') {
                         $('.bgImagecover').fadeOut('slow');
                         $('.bgSaveRP').remove();
                         $('.bgCancel').remove();
                         $('#timelineShade').fadeIn('slow');
                         $('#timelineBGload').removeClass('headerimage');
                         $('#timelineBGload').removeClass('ui-corner-all');
                         $('#timelineBGload').addClass('bgImagecover');
                         $('#timelineBGload').css({'margin-top':position});
                         notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                         return false;
                    } else {
                         notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                    }
                    profile_photo();
                }
            });
            return false;
        });
        $('#coverphotoreposition').click(function (){
                    var formData = new FormData();
                    formData.append( 'ACTION', 'REPOSITION');
                    $.ajax({
                        type: 'POST',
                        url: 'coverupload',
                        data: formData,
                        mimeType: 'multipart/form-data',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function(){ },
                        success: function(html)
                        {
                              var DATAV = JSON.parse(html);
                              $('#timelineBackground').html(DATAV.ABC);
                              
                        },
                        error:function(){
                                   notificationPopup('ERROR', 'Something went wrong. Please try again !');
                        }
                    });            
        })
        $('#coverphotoreposition1').click(function (){
             notificationPopup('ERROR', 'You can\\'t reposition default cover photo.');
        })
        $('body').on('click','.bgCancel',function ()
        { 
                var formData = new FormData();
                formData.append( 'ACTION', 'CANCEL');
                $.ajax({
                            type: 'POST',
                            url: 'coverphotoback',
                            data: formData,
                            mimeType: 'multipart/form-data',
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function(){ },
                            success: function(html)
                            {
                                  var DATAV = JSON.parse(html);
                                  $('#timelineBackground').html(DATAV.ABC);
                            },
                            error:function(){
                                  notificationPopup('ERROR', 'Something went wrong. Please try again !');
                            }
                });
        });

        $('body').on('click','#coverphotodelete',function ()
        { 
                var formData = new FormData();
                formData.append( 'ACTION', 'DELETE');
                $.ajax({
                          type: 'POST',
                          url: 'coverphotoback',
                          data: formData,
                          contentType: false,
                          cache: false,
                          processData: false,
                          beforeSend: function(){ },
                          success: function(html)
                          {
                               var DATAV = JSON.parse(html);
                               $('#timelineBackground').html(DATAV.ABC);
                               $('#coverphotoreposition').attr('id', 'coverphotoreposition1');            
                               $('#coverphotodelete').attr('id', 'coverphotodelete1');            
                          },
                          error:function(){
                               notificationPopup('ERROR', 'Something went wrong. Please try again !');
                          }
                });
        });
        $('#coverphotodelete1').click(function (){
             notificationPopup('ERROR', 'You can\\'t delete default cover photo.');
        })
    });

    $('#coverphotoupload').click(function(){
        $('#bgphotoimgcover').trigger('click');
    });
    $('#choosecoverphoto').click(function(){
        $('.cover_profile_set').attr('data-target','#photocovermodel'); 
        $('.cover_profile_set').removeClass('profile_set'); 
    });
    $('.add-photo').click(function(){
        $('.cover_profile_set').addClass('profile_set');
        $('.cover_profile_set').attr('data-target','#photodelete'); 
         
    });
    var PP_ID ='';
    $('.cover_profile_set').click(function(){
                        var targetd  = $(this).data('target');
                        if(targetd == '#photocovermodel'){
                            PP_ID = $(this).data('id');
                                $('#model_heading_cover').html('Are you sure want to set this photo as cover photo?');
                        }
    })
    
    $('.yescover').click(function(){
            Pace.restart();
            var formDataPhoto = new FormData();
            formDataPhoto.append( 'ACTION', 'GET_PHOTO_FROM_PHOTOS');
            formDataPhoto.append( 'P_ID', PP_ID);    
                $.ajax({
                        url: 'get-cover-photo-from-photo',
                        type: 'POST',
                        data: formDataPhoto,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            var DataObject = JSON.parse(data);
                            if (DataObject.STATUS == 'SUCCESS') {
                                $('#timelineBackground').html(DataObject.ABC);
                                $('.modal').modal('hide');
                            } else {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                            }
                                                                
                        profile_photo();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            notificationPopup('ERROR', 'Request Failed');
                        }
                });
        })            
    
        $('body').on('click','.bgSaveFP',function ()
        {
            var id = $(this).attr('id');
            var p = $('#timelineBGload').attr('style');
            var Y =p.split('top:');
            var Z=Y[1].split(';');
            var dataString ='position='+Z[0];
            var position = Z[0];

            var formData = new FormData();
            formData.append( 'position', position);
            formData.append( 'P_ID', PP_ID);
            $.ajax({
                type: 'POST',
                url: 'save-cover-photo-from-photo',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){       Pace.restart(); },
                success: function(data)
                {
                    var DataObject = JSON.parse(data);
                    if (DataObject.STATUS == 'SUCCESS') {
                         $('.bgImagecover').fadeOut('slow');
                         $('.bgSaveFP').remove();
                         $('.bgCancel').remove();
                         $('#timelineShade').fadeIn('slow');
                         $('#timelineBGload').removeClass('headerimage');
                         $('#timelineBGload').removeClass('ui-corner-all');
                         $('#timelineBGload').addClass('bgImagecover');
                         $('#timelineBGload').css({'margin-top':position});
                         notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                         return false;
                    } else {
                         notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                    }
                    profile_photo();
                }
            });
            return false;
        });
"); ?>

<?php
$this->registerJs("
          $('body').on('click','.hideshow',function ()
                    {
                        var formData = new FormData();
                        $.ajax({
                            type: 'POST',
                            url: 'hide-profile',
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function(){ },
                            success: function(data)
                            {
                              var DataObject = JSON.parse(data);
                              $('#hideshow_a').html(DataObject.OUTPUT);
                              notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                              hideshowfun();
                            },
                            error:function(){
                            notificationPopup('ERROR', 'Something went wrong. Please try again !');
  }
                            });
            });

           function hideshowfun(){
            $('.hideshowmenu').click(function() {
                 var name = $(this).data('name');
                 $('#model_heading_hideshow').html('');
                  if(name=='Yes'){
                    $('#model_heading_hideshow').html('If You Want To Show Your Profile!');
                  }else{
                    $('#model_heading_hideshow').html('If You Want To Hide Your Profile!');
                  }
            })
           }
           hideshowfun();
     ");
?>
