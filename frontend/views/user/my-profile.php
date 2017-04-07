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
$id = 0;
$PROFILE_COMPLETENESS = 0;
if (!Yii::$app->user->isGuest) {
    $id = Yii::$app->user->identity->id;
    $PROFILE_COMPLETENESS = $this->context->profileCompleteness($model->completed_step);
}
?>

<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/radical-progress.css"/>
<!-- Custom styles for this template -->
<!-- <link rel="stylesheet" type="text/css" href="css/cs-select.css" />
<link rel="stylesheet" type="text/css" href="css/radical-progress.css" />
<link rel="stylesheet" type="text/css" href="css/cs-skin-border.css" />
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet"> -->
<!--<div class="wrapper">-->
<div class="main-section">
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
                                                       class="gallery-popup"
                                                       data-target="#photo"
                                                       data-item="<?= Yii::$app->params['cover'] ?>">Choose from My
                                                        Photos</a></li>
                                                <li>
                                                    <a href="javascript:void(0)" id="coverphotoupload">Upload
                                                        Photo</a>
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
                                            <?php $pos = strpos($COVER_PHOTO, 'profile-bg.jpg'); ?>
                                            <img src="<?php echo $COVER_PHOTO; ?>" class="bgImagecover"
                                                 style="margin-top: <?= (!$pos) ? $model->cover_background_position : ''; ?>;">

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
                                    <div class="browse-photo">
                                        <form action="" method="post" enctype="multipart/form-data"
                                              id="upload_form">
                                            <input name="__files[]" id="file_browse" type="file"
                                                   multiple class="fileupload"/>
                                        </form>
                                    </div>
                                    <div class="pr-inner">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="im-pc">
                                                    <div class="image gallery-popup">
                                                        <div class="placeholder text-center">
                                                            <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, "200" . Yii::$app->user->identity->propic, 200, '', 'Yes'), ['class' => 'img-responsive mainpropic', 'width' => '200', 'height' => '200', 'alt' => 'Profile Pic']); ?>
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
                                                                    <li id="hideshow_a">
                                                                        <a href="javascript:void(0)"
                                                                           data-target="#hideProfile"
                                                                           data-toggle="modal"
                                                                           class="hideshowmenu"
                                                                           data-name="<?= $model->hide_profile ?>">
                                                                            <i class="fa <?= ($model->hide_profile == 'Yes') ? 'fa-eye' : 'fa-eye-slash'; ?>"></i> <?= ($model->hide_profile == 'Yes') ? 'Show' : 'Hide'; ?>
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
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="pull-right">
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

                                            <div class="pie_progress mrg-tp-10" role="progressbar" data-goal="33">
                                                <div class="pie_progress__number">0%</div>
                                                <div class="pie_progress__label">Complete</div>
                                            </div>
                                            <?php if ($PROFILE_COMPLETENESS < 100) { ?>
                                                <!--<div class="radial-progress" data-progress="0">
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
                                                                    <?php /*for ($i = 1; $i <= 100; $i++) { */ ?>
                                                                        <span><? /*= $i */ ?>% Complete</span>
                                                                    <?php /*} */ ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>-->
                                                <div class="text-center">
                                                    <p>Complete your profile for better search results</p>
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
                                            <a href="javascript:void(0)" class="pull-right text-muted"
                                               id="tag_count">
                                                <i class="fa fa-spinner fa-spin pink"></i>
                                            </a>

                                            <h3 class="panel-title text-muted mrg-bt-10">Add Tags</h3>
                                            <!--<a href="javascript:void(0)" class="text-muted">Add more tags</a>-->
                                        </div>
                                        <div class="panel-body no-padd text-center">
                                            <?php Pjax::begin(['id' => 'my_index111', 'enablePushState' => false]); ?>
                                            <div class="bootstrap-tagsinput" id="user_tag_list">
                                                <i class="fa fa-spinner fa-spin pink"></i> Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="panel no-border padd-hr-10 panel-default panel-friends"
                                         id="suggest_tag_list">
                                        <div class="panel-heading" id="add_all_tag">
                                            <h3 class="panel-title text-muted">Tag Suggestions</h3>
                                        </div>
                                        <div class="panel-body no-padd text-center">
                                            <div class="bootstrap-tagsinput">
                                                <i class="fa fa-spinner fa-spin pink"></i> Loading...
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <?php if (count($UserTotalPhotoCount) > 1) { ?>
                                        <div class="panel no-border panel-default panel-friends">
                                            <div class="panel-heading">
                                                <h3 class="heading-xs"> Photos <span
                                                        class="text-danger">(<?= count($UserTotalPhotoCount) ?>)</span>
                                                </h3>
                                            </div>
                                            <div class="panel-body text-center">
                                                <ul class="friends">
                                                    <?php foreach ($photo_model as $K => $V) { ?>
                                                        <li class="hovertool<?= ($V->eStatus == 'Approve') ? '' : ' img-blur1' ?>">
                                                            <a <?= ($V->eStatus == 'Approve') ? ' profile_set_kp set_profile_photo' : ' profile_set_kp set_profile_photo' ?>
                                                                href="javascript:void(0)">
                                                                <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->params['thumbnailPrefix'] . "75_" . $V['File_Name'], 75), ['width' => 75, 'height' => 75, 'class' => 'img-responsive tip', 'alt' => $V['File_Name'] . $K, 'style' => 'height: 75px;']); ?>

                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                    <span class="pull-right"><a href="#" data-toggle="modal"
                                                                                data-target="#photo"
                                                                                class="gallery-popup">View all
                                                            photos</a></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-8 mp-left">
                                <ul class="nav nav-pills bg-white my-profile tab-width" role="tablist">
                                    <li role="presentation" <?= ($tab == '') ? 'class="active"' : ''; ?> ><a
                                            href="#tab1" aria-controls="home"
                                            role="tab" data-toggle="tab">Personal Information</a>
                                    </li>
                                    <li role="presentation" <?= ($tab == 'EP') ? 'class="active"' : ''; ?> ><a
                                            href="#tab2" aria-controls="profile" role="tab"
                                            data-toggle="tab">Partner Preferences</a></li>
                                    <li role="presentation"><a href="#tab3" aria-controls="profile" role="tab"
                                                               data-toggle="tab"> Contact Details</a></li>
                                    <!--<li role="presentation"><a href="#tab4" aria-controls="profile" role="tab"
                                                               data-toggle="tab"> Hobby / Interest</a></li>-->
                                </ul>
                                <!-- Tab panes -->
                                <?php Pjax::begin(['id' => 'refresh_index']); ?>
                                <?= Html::a("Refresh", ['user/my-profile'], ['class' => 'btn btn-lg btn-primary hidden']) ?>
                                <?php Pjax::end(); ?>
                                <div class="tab-content my-profile tab-width">
                                    <div role="tabpanel" class="tab-pane <?= ($tab == '') ? 'active' : ''; ?> "
                                         id="tab1">

                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_btn" attr-name="my_info"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span
                                                        class="heading-icons <?= ($model->Gender == 'MALE') ? 'icon9' : 'icon1'; ?>"></span>
                                                    About Me</h1>
                                            </div>

                                            <?php Pjax::begin(['id' => 'div_my_info', 'enablePushState' => false]); ?>
                                            <p class="div_my_info">
                                                <i class="fa fa-spinner fa-spin pink"></i> About Me Loading...
                                            </p>
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation">
                                                        <a href="javascript:void(0)" class="edit_personal_btn"
                                                           attr-name="edit_personal_btn"><i
                                                                class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon2"></span> Basic information</h3>
                                            <?php Pjax::begin(['id' => 'div_personal_info1', 'enablePushState' => false]); ?>
                                            <div class="div_personal_info1">
                                                <i class="fa fa-spinner fa-spin pink"></i>
                                                Personal Information Loading...
                                            </div>
                                            <?php Pjax::end(); ?>

                                        </div>
                                        <!--<div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation"><a href="javascript:void(0)"
                                                                               class="edit_basic_information"
                                                                               attr-name="edit_basic_information"><i
                                                                class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon2"></span> Basic information</h3>
                                            <?php /*Pjax::begin(['id' => 'div_basic_info', 'enablePushState' => false]); */ ?>
                                            <div class="div_basic_info">
                                                <i class="fa fa-spinner fa-spin pink"></i> Basic Information
                                                Loading...
                                            </div>
                                            <?php /*Pjax::end(); */ ?>
                                        </div>-->
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation">
                                                        <a href="javascript:void(0)" class="edit_education"
                                                           attr-name="edit_education"><i class="fa fa-pencil"></i>
                                                            Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon6"></span> Educational & Occupational
                                            </h3>
                                            <?php Pjax::begin(['id' => 'div_education', 'enablePushState' => false]); ?>
                                            <div class="div_education">
                                                <i class="fa fa-spinner fa-spin pink"></i> Educational &
                                                Occupational Information Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation">
                                                        <a href="javascript:void(0)" class="edit_lifestyle"
                                                           attr-name="edit_lifestyle"><i class="fa fa-pencil"></i>
                                                            Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon2"></span> Lifestyle & Appearance
                                            </h3>
                                            <?php Pjax::begin(['id' => 'div_lifestyle', 'enablePushState' => false]); ?>
                                            <div class="div_lifestyle">
                                                <i class="fa fa-spinner fa-spin pink"></i> Lifestyle & Appearance
                                                Information Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation">
                                                        <a href="javascript:void(0)" class="edit_family"
                                                           attr-name="edit_family"><i class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon5"></span> Family</h3>
                                            <?php Pjax::begin(['id' => 'div_family', 'enablePushState' => false]); ?>
                                            <div class="div_family">
                                                <i class="fa fa-spinner fa-spin pink"></i> Family Information
                                                Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation">
                                                        <a href="javascript:void(0)" class="edit_horoscope"
                                                           attr-name="edit_horoscope"><i class="fa fa-pencil"></i>
                                                            Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon3"></span> Horoscope Details</h3>
                                            <?php Pjax::begin(['id' => 'div_horoscope', 'enablePushState' => false]); ?>
                                            <div class="div_horoscope">
                                                <i class="fa fa-spinner fa-spin pink"></i> Horoscope Details
                                                Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>

                                        <div class="inner-block">
                                            <div class="profile-edit pull-right">
                                                <ul class="list-inline major-control">
                                                    <li role="presentation"><a href="javascript:void(0)"
                                                                               class="edit_hobby"
                                                                               attr-name="edit_hobby"><i
                                                                class="fa fa-pencil"></i> Edit</a></li>
                                                </ul>
                                            </div>
                                            <h3><span class="heading-icons icon7"></span> Hobby/Interest</h3>
                                            <?php Pjax::begin(['id' => 'my_hobby', 'enablePushState' => false]); ?>
                                            <div class="div_hobby">
                                                <i class="fa fa-spinner fa-spin pink"></i> Hobby/Interest
                                                Information Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>


                                    </div>


                                    <div role="tabpanel" class="tab-pane <?= ($tab == 'EP') ? 'active' : ''; ?> "
                                         id="tab2">
                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_preferences"
                                                                           attr-name="edit_preferences"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span class="heading-icons icon2"></span> My Preferences</h1>
                                            </div>
                                            <?php Pjax::begin(['id' => 'my_preferences', 'enablePushState' => false]); ?>
                                            <div class="div_preferences">
                                                <i class="fa fa-spinner fa-spin pink"></i> Preferences Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>

                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_profession "
                                                                           attr-name="edit_profession"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span class="heading-icons icon6"></span>Profession Preferences
                                                </h1>
                                            </div>
                                            <?php Pjax::begin(['id' => 'my_profession', 'enablePushState' => false]); ?>
                                            <div class="div_profession">
                                                <i class="fa fa-spinner fa-spin pink"></i> Educational &
                                                Occupational Preferences
                                                Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_location"
                                                                           attr-name="edit_location"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span class="heading-icons icon2"></span> Location Preferences
                                                </h1>
                                            </div>
                                            <?php Pjax::begin(['id' => 'my_location', 'enablePushState' => false]); ?>
                                            <div class="div_location">
                                                <i class="fa fa-spinner fa-spin pink"></i> Location Preferences
                                                Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>


                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_partner_family"
                                                                           attr-name="edit_partner_family"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span
                                                        class="heading-icons icon5"></span>
                                                    Family Preferences
                                                </h1>
                                            </div>
                                            <?php Pjax::begin(['id' => 'partner_family', 'enablePushState' => false]); ?>
                                            <div class="partner_family">
                                                <i class="fa fa-spinner fa-spin pink"></i> Family Preferences Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>

                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_partner_hobby"
                                                                           attr-name="edit_partner_hobby"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span
                                                        class="heading-icons icon7"></span>
                                                    Hobby/Interest Preferences
                                                </h1>
                                            </div>
                                            <?php Pjax::begin(['id' => 'partner_hobby', 'enablePushState' => false]); ?>
                                            <div class="partner_hobby">
                                                <i class="fa fa-spinner fa-spin pink"></i> Hobby/Interest
                                                Preferences
                                                Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>
                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_looking"
                                                                           attr-name="edit_looking"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span
                                                        class="heading-icons <?= ($model->Gender == 'MALE') ? 'icon1' : 'icon9'; ?>"></span>
                                                    What I am looking for
                                                </h1>
                                            </div>


                                            <?php Pjax::begin(['id' => 'my_looking', 'enablePushState' => false]); ?>
                                            <div class="div_looking">
                                                <i class="fa fa-spinner fa-spin pink"></i> What I am looking for
                                                Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>

                                    </div>


                                    <div role="tabpanel" class="tab-pane" id="tab3">
                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_contact_detail"
                                                                           attr-name="my_contact_detail"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span
                                                        class="heading-icons icon2"></span>
                                                    Contact Detail
                                                </h1>
                                            </div>
                                            <?php Pjax::begin(['id' => 'my_contact_details', 'enablePushState' => false]); ?>
                                            <div class="div_contact_detail">
                                                <i class="fa fa-spinner fa-spin pink"></i> Contact Detail
                                                Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>

                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_permanent_address"
                                                                           attr-name="my_permanent_address"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span
                                                        class="heading-icons icon2"></span>
                                                    Permanent Address
                                                </h1>
                                            </div>
                                            <?php Pjax::begin(['id' => 'my_permanent_address', 'enablePushState' => false]); ?>
                                            <div class="div_permanent_address">
                                                <i class="fa fa-spinner fa-spin pink"></i> Permanent Address
                                                Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>

                                        <div class="profile-edit pull-right">
                                            <ul class="list-inline major-control">
                                                <li role="presentation"><a href="javascript:void(0)"
                                                                           class="edit_current_address"
                                                                           attr-name="my_current_address"><i
                                                            class="fa fa-pencil"></i> Edit</a></li>
                                            </ul>
                                        </div>
                                        <div class="inner-block">
                                            <div class="fb-profile-text padd-xs padd-tp-0">
                                                <h1><span
                                                        class="heading-icons icon2"></span>
                                                    Current Address
                                                </h1>
                                            </div>
                                            <?php Pjax::begin(['id' => 'my_current_address', 'enablePushState' => false]); ?>
                                            <div class="div_current_address">
                                                <i class="fa fa-spinner fa-spin pink"></i> Current Address
                                                Loading...
                                            </div>
                                            <?php Pjax::end(); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <? /*= $this->render('/layouts/parts/_rightbar.php', ['SimilarProfile' => $SimilarProfile]) */ ?> -->
                </div>
            </div>
        </section>
    </main>
</div>
<!--<div class="chatwe">
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne"
             id="chatbox"><i class="fa fa-comment"></i> Members Online
        </div>
        <div class="panel-collapse collapse" id="collapseOne">
            <div class="panel-body">
                <ul class="list-unstyled ad-prof">
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    <li class="active"><span
                            class="imgarea"><? /*= Html::img('@web/images/profile2.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="online"></span> </li>
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile3.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile1.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile2.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile3.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
                    <li><span
                            class="imgarea"><? /*= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); */ ?></span>
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
</div>-->
<!-- Modal Photo -->
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
<div class="modal fade" id="deleteProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo"></p>
        </p>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <h2 class="text-center"><?= Yii::$app->params['deleteProfileTitle'] ?></h2>
            </div>
            <div class="modal-body text-center">
                <p><strong><?= Yii::$app->params['deleteProfileMessage'] ?></strong></p>

                <p><?= Yii::$app->params['deleteProfileNote'] ?></p>

                <p></p><br>

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <button class="btn btn-primary delete_account yes">Yes</button>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <button class="btn btn-primary" data-dismiss="modal">cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var PRO_COMP = <?=$PROFILE_COMPLETENESS?>;
</script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/selectFx.js"></script>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/cover/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php
$this->registerJs('
    function getInlineDetail(url,htmlId,cancel){
     loaderStart();
        $.ajax({
        url : url,
        type:"POST",
        data:{"cancel":cancel},
        success:function(res){
                  loaderStop();
          $(htmlId).html(res);
        }
      });
    }

    getInlineDetail("' . Url::to(['user/tag-list']) . '","#user_tag_list","1");
    getInlineDetail("' . Url::to(['user/tag-suggestion-list']) . '","#suggest_tag_list","1");
    getInlineDetail("' . Url::to(['user/tag-count']) . '","#tag_count","1");

    $(".edit_btn").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-myinfo']) . '","#div_my_info","0");
    });
    getInlineDetail("' . Url::to(['user/edit-myinfo']) . '","#div_my_info","1");
    $(document).on("click","#cancel_edit_info",function(e){
        getInlineDetail("' . Url::to(['user/edit-myinfo']) . '","#div_my_info","1");
    });

    $(".edit_personal_btn").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-personal-info']) . '","#div_personal_info1","0");
    });
    getInlineDetail("' . Url::to(['user/edit-personal-info']) . '","#div_personal_info1","1");

    $(document).on("click","#cancel_edit_personalinfo",function(e){
        getInlineDetail("' . Url::to(['user/edit-personal-info']) . '","#div_personal_info1","1");
    });

    /*
    $(".edit_basic_information").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-basic-info']) . '","#div_basic_info","0");
    });
    getInlineDetail("' . Url::to(['user/edit-basic-info']) . '","#div_basic_info","1");
    */

    $(document).on("click","#cancel_edit_basicinfo",function(e){
        getInlineDetail("' . Url::to(['user/edit-basic-info']) . '","#div_basic_info","1");
    });

    $(".edit_education").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-education']) . '","#div_education","0");
    });
    getInlineDetail("' . Url::to(['user/edit-education']) . '","#div_education","1");
    $(document).on("click","#cancel_edit_education",function(e){
        getInlineDetail("' . Url::to(['user/edit-education']) . '","#div_education","1");
    });
    
    $(".edit_lifestyle").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-lifestyle']) . '","#div_lifestyle","0");
    });
    getInlineDetail("' . Url::to(['user/edit-lifestyle']) . '","#div_lifestyle","1");
    $(document).on("click","#cancel_edit_lifestyle",function(e){
        getInlineDetail("' . Url::to(['user/edit-lifestyle']) . '","#div_lifestyle","1");
    });
    
    $(".edit_family").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-family']) . '","#div_family","0");
    });
    getInlineDetail("' . Url::to(['user/edit-family']) . '","#div_family","1");
    $(document).on("click","#cancel_edit_family",function(e){
        getInlineDetail("' . Url::to(['user/edit-family']) . '","#div_family","1");
    });

    $(".edit_preferences").click(function(e){
        getInlineDetail("'.Url::to(['user/edit-preferences']).'","#my_preferences","0");
    });
    getInlineDetail("'.Url::to(['user/edit-preferences']).'","#my_preferences","1");
    $(document).on("click","#cancel_edit_preferences",function(e){
        getInlineDetail("'.Url::to(['user/edit-preferences']).'","#my_preferences","1");
    });

    $(".edit_horoscope").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-horoscope']) . '","#div_horoscope","0");
    });
    getInlineDetail("' . Url::to(['user/edit-horoscope']) . '","#div_horoscope","1");
    $(document).on("click","#cancel_edit_horoscope",function(e){
        getInlineDetail("' . Url::to(['user/edit-horoscope']) . '","#div_horoscope","1");
    });

/*  partner preferences */

     $(".edit_preferences").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences']) . '","#my_preferences","0");
    });
    getInlineDetail("' . Url::to(['user/edit-preferences']) . '","#my_preferences","1");
    $(document).on("click","#cancel_edit_preferences",function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences']) . '","#my_preferences","1");
    });
    $(".edit_profession").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences-profession']) . '","#my_profession","0");
    });
    getInlineDetail("' . Url::to(['user/edit-preferences-profession']) . '","#my_profession","1");
    $(document).on("click","#cancel_edit_profession",function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences-profession']) . '","#my_profession","1");
    });
    $(".edit_location").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences-location']) . '","#my_location","0");
    });
    getInlineDetail("' . Url::to(['user/edit-preferences-location']) . '","#my_location","1");
    $(document).on("click","#cancel_edit_location",function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences-location']) . '","#my_location","1");
    });

    $(".edit_partner_hobby").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences-hobby']) . '","#partner_hobby","0");
    });
    getInlineDetail("' . Url::to(['user/edit-preferences-hobby']) . '","#partner_hobby","1");
    $(document).on("click","#cancel_edit_partner_hobby",function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences-hobby']) . '","#partner_hobby","1");
    });

    $(".edit_partner_family").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences-family']) . '","#partner_family","0");
    });
    getInlineDetail("' . Url::to(['user/edit-preferences-family']) . '","#partner_family","1");
    $(document).on("click","#cancel_edit_partner_family",function(e){
        getInlineDetail("' . Url::to(['user/edit-preferences-family']) . '","#partner_family","1");
    });

    $(".edit_looking").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-looking-for']) . '","#my_looking","0");
    });
    getInlineDetail("' . Url::to(['user/edit-looking-for']) . '","#my_looking","1");
    $(document).on("click","#cancel_edit_looking",function(e){
        getInlineDetail("' . Url::to(['user/edit-looking-for']) . '","#my_looking","1");
    });

    $(".edit_contact_detail").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-contact-detail']) . '","#my_contact_details","0");
    });
    getInlineDetail("' . Url::to(['user/edit-contact-detail']) . '","#my_contact_details","1");
    $(document).on("click","#cancel_edit_contact_detail",function(e){
        getInlineDetail("' . Url::to(['user/edit-contact-detail']) . '","#my_contact_details","1");
    });

    $(".edit_permanent_address").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-permanent-address']) . '","#my_permanent_address","0");
    });
    getInlineDetail("' . Url::to(['user/edit-permanent-address']) . '","#my_permanent_address","1");
    $(document).on("click","#cancel_edit_permanent_address",function(e){
        getInlineDetail("' . Url::to(['user/edit-permanent-address']) . '","#my_permanent_address","1");
    });

     $(".edit_current_address").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-current-address']) . '","#my_current_address","0");
    });
    getInlineDetail("' . Url::to(['user/edit-current-address']) . '","#my_current_address","1");
    $(document).on("click","#cancel_edit_current_address",function(e){
        getInlineDetail("' . Url::to(['user/edit-current-address']) . '","#my_current_address","1");
    });


    $(".edit_hobby").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-hobby']) . '","#my_hobby","0");
    });
    getInlineDetail("' . Url::to(['user/edit-hobby']) . '","#my_hobby","1");
    $(document).on("click","#cancel_edit_hobby",function(e){
        getInlineDetail("' . Url::to(['user/edit-hobby']) . '","#my_hobby","1");
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
            loaderStart();
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
                            if (DataObject.STATUS == "S") {
                            loaderStop();
                                if(P_TYPE=="PHOTO_PROFILE_SET"){
                                    $("#photo_list").html(DataObject.OUTPUT);
                                    $("#profile_list_popup").html(DataObject.OUTPUT_ONE);
                                    $(".mainpropic").attr("src", DataObject.PROFILE_PHOTO);
                                    $(".profile_photo_one").attr("src", DataObject.PROFILE_PHOTO_ONE);
                                    notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                }else{
                                    $("#photo_list").html(DataObject.OUTPUT);
                                    $("#profile_list_popup").html(DataObject.OUTPUT_ONE);
                                    if(DataObject.PROFILE_PHOTO != ""){
                                        $(".mainpropic").attr("src", DataObject.PROFILE_PHOTO);
                                    }
                                    if(DataObject.PROFILE_PHOTO_ONE != ""){
                                        $(".profile_photo_one").attr("src", DataObject.PROFILE_PHOTO_ONE);
                                    }
                                    notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                }
                            } else {
                                 loaderStop();
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                            }
                                                                
                        profile_photo();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                         loaderStop();
                                notificationPopup(\'ERROR\', \'Something went wrong. Please try again !\', \'Error\');
                        }
                    });
        })
        
        
  ');
?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
<?= $this->render('_scriptmyprofile'); ?>

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

    .form-horizontal .control-label {

        font-size: 13px;
        color: #949494;
        font-weight: 400;

    }

    label {
        font-weight: 400;
    }
</style>