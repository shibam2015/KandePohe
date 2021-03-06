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

// var_dump($id = Yii::$app->user->identity->id);
$id = 0;
$PROFILE_COMPLETENESS = 0;
if (!Yii::$app->user->isGuest) {
#$id = base64_decode($id);
    $id = Yii::$app->user->identity->id;
    $PROFILE_COMPLETENESS = $this->context->profileCompleteness($model->completed_step);
}

$HOME_URL = Yii::getAlias('@web') . "/";
$HOME_URL_SITE = Yii::getAlias('@web') . "/site/";
$UPLOAD_DIR = Yii::getAlias('@frontend') . '/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') . '/web/';

?>

    <link rel="stylesheet" type="text/css" href="<?= $HOME_URL ?>css/radical-progress.css"/>
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
                                            <div class="panel-heading">

                                                <a href="#" class="pull-right text-muted" id="tag_count">
                                                    <?= count($TAG_LIST_USER) ?>/<?= count($TAG_LIST) ?>
                                                </a>

                                                <h3 class="panel-title text-muted mrg-bt-10">Add Tags</h3>
                                                <a href="#" class="text-muted">Add more tags</a></div>
                                            <div class="panel-body no-padd text-center">
                                                <div class="bootstrap-tagsinput" id="user_tag_list">
                                                    <?php
                                                    $SET_TAGS = array();
                                                    if (count($TAG_LIST_USER) != 0) {
                                                        foreach ($TAG_LIST_USER as $TK => $TV) {
                                                            array_push($SET_TAGS, $TV->tag_id);
                                                            ?>
                                                            <span class="tag label label-danger"
                                                                  id="tag_delete_<?= $TV->id ?>">
                                                             <?= $TV->tagName->Name ?>
                                                                <i data-role="remove" class="fa fa-times tag_delete"
                                                                   data-id="<?= $TV->id ?>"></i>
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
                                        <div class="panel no-border padd-hr-10 panel-default panel-friends">
                                            <div class="panel-heading">
                                                <?php if (count($TAG_LIST) != count($TAG_LIST_USER)) { ?>
                                                    <a href="javascript:void(0)" class="pull-right suggest_tag_all">Add
                                                        All</a>
                                                <?php } ?>
                                                <h3 class="panel-title text-muted">Tag Suggestions</h3>
                                            </div>
                                            <div class="panel-body no-padd text-center">
                                                <div class="bootstrap-tagsinput" id="suggest_tag_list">
                                                    <?php if (count($TAG_LIST) != count($TAG_LIST_USER)) {
                                                        foreach ($TAG_LIST as $TK => $TV) {
                                                            if (!in_array($TV['ID'], $SET_TAGS)) {
                                                                ?>
                                                                <!-- <span class="tag label label-default"><?= $TV['Name'] ?></span> -->
                                                                <button class="btn btn-default suggest_tag"
                                                                        data-id="<?= $TV['ID'] ?>"><?= $TV['Name'] ?></button>
                                                            <?php }
                                                        }
                                                    } else { ?>
                                                        <span
                                                            class="tag label label-default">Tag Suggestion Not Available</span>
                                                    <?php }
                                                    ?>
                                                </div>
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
                                                            <li><a href="javascript:void(0)">
                                                                    <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name'], 75), ['class' => 'img-responsive tip', 'alt' => $V['File_Name'] . $K]); ?>
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
                                                <p class="dis_my_info">

                                                </p>
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

                                                </div>
                                                <?php Pjax::end(); ?>
                                            </div>
                                        </div>


                                        <div role="tabpanel" class="tab-pane" id="tab2">Tab 2</div>
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
            </span> <span class="time">12:24</span></li>
                        <li class="active"><span
                                class="imgarea"><?= Html::img('@web/images/profile2.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="online"></span></li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile3.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span></li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile1.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span></li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile2.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span></li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile3.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span></li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span></li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span></li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span></li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span></li>
                        <li><span
                                class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40', 'height' => '40', 'alt' => 'Profile']); ?></span>
                            <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span></li>
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
          <button class="btn btn-default btn-sm" id="btn-chat" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false"> <i class="fa fa-cog"></i> </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
          </ul>
          </span></div>
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
                    <div class="choose-photo jumbotron">
                        <div class="row">
                            <div class="col-lg-6" id="crop-section" style="display:none">
                                <!--<div class="col-lg-6" id="crop-section" style="display:none">-->
                                <img src="" id="thumbnail" alt="Create Thumbnail"/>
                                <div id="thumb_preview_holder">
                                    <img src="" alt="Thumbnail Preview" id="thumb_preview"/>
                                </div>
                                <div>
                                    <input type="hidden" name="filename" value="" id="filename"/>
                                    <input type="hidden" name="x1" value="" id="x1"/>
                                    <input type="hidden" name="y1" value="" id="y1"/>
                                    <input type="hidden" name="x2" value="" id="x2"/>
                                    <input type="hidden" name="y2" value="" id="y2"/>
                                    <input type="hidden" name="w" value="" id="w"/>
                                    <input type="hidden" name="h" value="" id="h"/><br>

                                    <input type="submit" class="btn btn-primary button" name="upload_thumbnail"
                                           value="Save Thumbnail" id="save_thumb"/>
                                </div>
                                <!--</div>-->
                            </div>
                        </div>
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
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span></button>
                    <h2 class="text-center">Delete profile</h2>
                </div>
                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <p><strong>Are you sure you want to delete your profile?</strong></p>
                    <p>Deleting your account will disable your Profile. Some information may still be visible to others,
                        such as your name in their Inbox list and messages that you've sent.</p>
                    <p></p><br>
                    <p>
                        <button class="btn btn-primary delete_account">Yes</button>
                        <button class="btn btn-primary" data-dismiss="modal">cancel</button>
                    </p>
                </div>
            </div>
            <!-- Modal Footer -->
        </div>
    </div>


    <script type="text/javascript">
        var PRO_COMP = <?=$PROFILE_COMPLETENESS?>;
    </script>
    <script src="<?= $HOME_URL ?>js/selectFx.js"></script>

    <style>
        #upload .upload {
            font-family: verdana;
        }

        #thumbnail {
            float: left;
        }

        #thumb_preview_holder {
            float: left;
            width: 156px;
            height: 156px;
            overflow: hidden;
            margin-left: 10px;
            margin-top: 20px;
        }

        #save_thumb {
            margin-top: 30px;
        }
    </style>
<?php
$this->registerJs('
    function getInlineDetail(url,htmlId,cancel){
        $.ajax({
        url : url,
        type:"POST",
        data:{"cancel":cancel},
        success:function(res){
          $(htmlId).html(res);
        }
      });
    }

    $(".edit_btn").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-myinfo']) . '",".dis_my_info","0");
    });
    getInlineDetail("' . Url::to(['user/edit-myinfo']) . '",".dis_my_info","1");
    $(document).on("click","#cancel_edit_myinfo",function(e){
        getInlineDetail("' . Url::to(['user/edit-myinfo']) . '",".dis_my_info","1");
    });

    $(".edit_personal_btn").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-personal-info']) . '",".div_personal_info","0");
    });
    getInlineDetail("' . Url::to(['user/edit-personal-info']) . '",".div_personal_info","1");
    $(document).on("click","#cancel_edit_personalinfo",function(e){
        getInlineDetail("' . Url::to(['user/edit-personal-info']) . '",".div_personal_info","1");
    });

    $(".edit_basic_information").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-basic-info']) . '",".div_basic_info","0");
    });
    getInlineDetail("' . Url::to(['user/edit-basic-info']) . '",".div_basic_info","1");
    $(document).on("click","#cancel_edit_basicinfo",function(e){
        getInlineDetail("' . Url::to(['user/edit-basic-info']) . '",".div_basic_info","1");
    });
    
    $(".edit_education").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-education']) . '",".div_education","0");
    });
    getInlineDetail("' . Url::to(['user/edit-education']) . '",".div_education","1");
    $(document).on("click","#cancel_edit_education",function(e){
        getInlineDetail("' . Url::to(['user/edit-education']) . '",".div_education","1");
    });
    
    $(".edit_lifestyle").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-lifestyle']) . '",".div_lifestyle","0");
    });
    getInlineDetail("' . Url::to(['user/edit-lifestyle']) . '",".div_lifestyle","1");
    $(document).on("click","#cancel_edit_lifestyle",function(e){
        getInlineDetail("' . Url::to(['user/edit-lifestyle']) . '",".div_lifestyle","1");
    });
    
    $(".edit_family").click(function(e){
        getInlineDetail("' . Url::to(['user/edit-family']) . '",".div_family","0");
    });
    getInlineDetail("' . Url::to(['user/edit-family']) . '",".div_family","1");
    $(document).on("click","#cancel_edit_family",function(e){
        getInlineDetail("' . Url::to(['user/edit-family']) . '",".div_family","1");
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
        createUploader("asd");
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
#$this->registerJsFile($HOME_URL.'js/crop/jquery-pack.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile($HOME_URL.'js/crop/fileuploader.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($HOME_URL . 'js/crop/jquery.imgareaselect.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs('
  $(document).ready();
	$(document).ready(function(){
            var thumb = $(".thumbnails");

		$(\'#thumbnail\').imgAreaSelect({ aspectRatio: \'1:1\', onSelectChange: preview});

		$(\'#save_thumb\').click(function() {
			var x1 = $(\'#x1\').val();
			var y1 = $(\'#y1\').val();
			var x2 = $(\'#x2\').val();
			var y2 = $(\'#y2\').val();
			var w = $(\'#w\').val();
			var h = $(\'#h\').val();
			if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
				alert("You must make a selection first");
				return false;
			}
			else{
				$.ajax({
					type : \'POST\',
					url: "crop_script.php",
					data: "filename="+$(\'#filename\').val()+"&x1="+x1+"&x2="+x2+"&y1="+y1+"&y2="+y2+"&w="+w+"&h="+h,
					success: function(data){
						thumb.attr(\'src\', \'uploads/thumb_\'+$(\'#filename\').val());
						thumb.addClass(\'thumbnail\');
						$(\'#thumbnail\').imgAreaSelect({ hide: true, x1: 0, y1: 0, x2: 0, y2: 0 });
						// let\'s clear the modal
						$(\'#thumbnail\').attr(\'src\', \'\');
						$(\'#crop-section\').hide();
						$(\'#uploader-section\').show();
						$(\'#thumb_preview\').attr(\'src\', \'\');
						$(\'#filename\').attr(\'value\', \'\');
					}
				});

				return true;
			}
		});
	});

    function createUploader1(){ 
    	var button = $(\'#upload\');           
        var uploader = new qq.FileUploaderBasic({
            button: document.getElementById(\'file-uploader\'),
            action: \'upload.php\',
            allowedExtensions: [\'jpg\', \'gif\', \'png\', \'jpeg\'],
            onSubmit: function(id, fileName) {
				// change button text, when user selects file			
				button.text(\'Uploading\');
				// Uploding -> Uploading. -> Uploading...
				interval = window.setInterval(function(){
					var text = button.text();
					if (text.length < 13){
						button.text(text + \'.\');					
					} else {
						button.text(\'Uploading\');				
					}
				}, 200);
			},
            onComplete: function(id, fileName, responseJSON){
            	button.text(\'Change profile picture\');
				window.clearInterval(interval);

            	if(responseJSON[\'success\'])
            	{
            		load_original(responseJSON[\'filename\']);
					}},
                debug: true
            });           
    }

    function createUploader(){
        load_original("abc");
    }

    function load_original(filename){
    filename ="";
    	$(\'#thumbnail\').attr(\'src\', "/KandePohe/uploads/users/2/16621474973413.jpg"+filename);
		$(\'#thumb_preview\').attr(\'src\', "/KandePohe/uploads/uploads/users/2/16621474973413.jpg"+filename);
		$(\'#filename\').attr(\'value\', filename);
		//if ( $.browser.msie ) {
		/*if ( $.browser.msie ) {
			$(\'#thumb_preview_holder\').remove();
		}*/
		$(\'#crop-section\').show();
		$(\'#uploader-section\').hide();
	}

	function preview(img, selection) { 
		var mythumb = $(\'#thumbnail\');
		var scaleX = 156/selection.width; 
		var scaleY = 156/selection.height; 

		$(\'#thumbnail + div > img\').css({ 
			width: Math.round(scaleX * mythumb.outerWidth() ) + \'px\', 
			height: Math.round(scaleY * mythumb.outerHeight()) + \'px\',
			marginLeft: \'-\' + Math.round(scaleX * selection.x1) + \'px\', 
			marginTop: \'-\' + Math.round(scaleY * selection.y1) + \'px\' 
		});
		$(\'#x1\').val(selection.x1);
		$(\'#y1\').val(selection.y1);
		$(\'#x2\').val(selection.x2);
		$(\'#y2\').val(selection.y2);
		$(\'#w\').val(selection.width);
		$(\'#h\').val(selection.height);
	}        
        
  ');
?>

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
<?= $this->render('_scriptmyprofile'); ?>