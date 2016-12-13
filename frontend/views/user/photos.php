<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\helpers\ArrayHelper;
$HOME_URL = Yii::getAlias('@web') . "/";
$HOME_URL_SITE = Yii::getAlias('@web') . "/site/";
$HOME_PAGE_URL = Yii::getAlias('@web') . "/";
$UPLOAD_DIR = Yii::getAlias('@frontend') . '/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') . '/web/';
?>
<div class="" xmlns="http://www.w3.org/1999/html">
    <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
    <main>
        <div class="main-section">
            <div class="col-md-9 col-sm-12">
                <div class="right-column" style="margin-left: 73px;">
                </div>
            </div>

            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="white-section">
                                <h3>Add Profile Photo
                                    <?php if (!$USER_APPROVED) { ?>
                                        <a href="<?= $HOME_URL_SITE ?>verification" class="pull-right"><span
                                                class="link_small">( I will do this later )</span></a>
                                    <?php } ?>
                                </h3>
                                <div class="two-column">
                                    <div class="row">
                                        <div class="col-sm-6 bord">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p class="mrg-bt-10"><i class="fa fa-lock text-danger"></i> 100%
                                                        Privacy Settings</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="image gallery-popup">
                                                        <div class="placeholder text-center">
                                                            <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, "200" . Yii::$app->user->identity->propic, 200, '', 'Yes'), ['class' => 'img-responsive mainpropic ', 'width' => '200', 'alt' => 'Profile Photo']); ?>
                                                            <div class="add-photo" data-toggle="modal"
                                                                 data-target="#photo"><span class="file-input btn-file"> <i
                                                                        class="fa fa-plus-circle"></i> Add a photo </span>
                                                            </div>
                                                        </div>
                                                        <p class="mrg-tp-10">Upload a photo and get 12 times more
                                                            response</p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="upload">
                                                        <div>
                                                            <form action="" method="post" enctype="multipart/form-data"
                                                                  id="upload_form">
                                                                <div class="file_browse_wrapper"
                                                                     id="file_browse_wrapper" data-toggle="tooltip"
                                                                     data-placement="top"
                                                                     data-original-title="Click here to upload photos from your PC’s /Laptop’s local drive ">
                                                                    Upload photo from computer
                                                                </div>
                                                                <input name="__files[]" id="file_browse" type="file"
                                                                       multiple class="fileupload"/>
                                                            </form>
                                                        </div>
                                                        <!--<div class="bar-devider"><span>OR</span></div>
                                                        <a class="btn btn-block btn-social btn-facebook"
                                                           data-toggle="modal"
                                                           data-target="#profilecrop"> <i class="fa fa-facebook"></i>
                                                            Sign in with Facebook </a>-->
                                                        <!--<div class="bar-devider"> <span>OR</span> </div>-->
                                                        <!--<a class="btn btn-block btn-social btn-facebook"> <i class="fa fa-facebook"></i> Sign in with Facebook </a>-->

                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="choose-photo">
                                                <div class="row" id="photo_list">
                                                    <?php
                                                    if (count($model) > 0) {
                                                        foreach ($model as $K => $V) {
                                                            ?>
                                                            <?php $SELECTED = '';
                                                            if ($V->Is_Profile_Photo == 'YES') {
                                                                $SELECTED = "selected";
                                                            } ?>
                                                            <div
                                                                class="col-md-3 col-sm-3 col-xs-6 <?= ($V->eStatus == 'Approve' || $V->eStatus == 'Disapprove') ? '' : '   text-center' ?>"
                                                                 id="img_<?= $V['iPhoto_ID'] ?>">
                                                                <div
                                                                    class="<?= ($V->eStatus == 'Approve') ? 'gallery ' : 'img-blur' ?>">
                                                                    <a class="<?= $SELECTED ?>"
                                                                       data-toggle="tooltip" data-placement="top"
                                                                        <?php if ($V->eStatus == 'Approve') { ?>
                                                                            href="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                                                                            data-original-title="Click for full view"
                                                                        <?php } else { ?>
                                                                            href="javascript:void(0)"
                                                                            data-original-title="<?= ($V->eStatus == 'Pending') ? 'Awaiting Approval' : 'Please Remove this Photo.' ?>"
                                                                        <?php } ?>>
                                                                        <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->params['thumbnailPrefix'] . "110_" . $V['File_Name'], 110), ['class' => 'img-responsive ' . $SELECTED, 'width' => '140', 'alt' => 'Photo' . $K]); ?>
                                                                    </a>
                                                                </div>
                                                                <?php if ($V->eStatus == 'Approve') { ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="pull-left profile_set_kp set_profile_photo"
                                                                       data-id="<?= $V['iPhoto_ID'] ?>"
                                                                       data-target="#profilecrop" data-toggle="modal"
                                                                       data-item="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                                                                       data-name="<?= $V['File_Name'] ?>">
                                                                        Profile pic
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                       class="pull-right profile_delete"
                                                                       data-id="<?= $V['iPhoto_ID'] ?>"
                                                                       data-target="#photodelete" data-toggle="modal">
                                                                        <i aria-hidden="true" class="fa fa-trash-o"></i>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a href="javascript:void(0)"
                                                                       class=""
                                                                       data-id="<?= $V['iPhoto_ID'] ?>"
                                                                       data-item="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                                                                       data-name="<?= $V['File_Name'] ?>">
                                                                        <?= ($V->eStatus == 'Pending') ? 'Pending' : 'Disapproved' ?>
                                                                    </a>
                                                                    <?php if ($V->eStatus == 'Disapprove') { ?>
                                                                        <a href="javascript:void(0)"
                                                                           class="pull-right profile_delete"
                                                                           data-id="<?= $V['iPhoto_ID'] ?>"
                                                                           data-target="#photodelete"
                                                                           data-toggle="modal">
                                                                            <i aria-hidden="true"
                                                                               class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                            </div>
                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <div
                                                            class="col-md-12 col-md-offset-1 col-sm-12 col-xs-12 text-center mrg-tp-20">
                                                            <div class="notice kp_info"><p>No Photos Available.</p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="privacy-promo">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="phone-privacy mrg-tp-30">
                                                            Photo Privacy
                                                            <button type="button"
                                                                    class="btn btn-default btn-xs dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"><span
                                                                    class="glyphicon glyphicon-globe"></span> <span
                                                                    class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#"><span
                                                                            class="glyphicon glyphicon-globe"></span>
                                                                        <strong>Public</strong><br> <span
                                                                            class="sub-title">Anyone</span></a></li>
                                                                <li><a href="#"><span
                                                                            class="glyphicon glyphicon-certificate"></span>
                                                                        <strong>Members</strong><br> <span
                                                                            class="sub-title">Only Premium Members</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="privacy-promo">
                                                <div class="row">
                                                    <div class="col-sm-6 bord">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <?php
                                                                if ($model_user->eEmailVerifiedStatus != 'Yes' || $model_user->ePhoneVerifiedStatus != 'Yes') {
                                                                    $form = ActiveForm::begin([
                                                                        'id' => 'form-register6',
                                                                    ]);
                                                                    ?>
                                                                    <?= Html::submitButton('CONTINUE', ['class' => 'btn btn-primary mrg-bt-10  pull-left', 'name' => 'CONTINUE']) ?>

                                                                    <?php ActiveForm::end();
                                                                } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-5">

                                            <h4 class="mrg-left-mins">Profile Photo Guidelines</h4>
                                            <div class="faces-pic">
                                                <div class="row no-gutter mrg-tp-30">
                                                    <div class="col-md-3 col-sm-6 col-xs-6 text-center"><img
                                                            src="<?= $HOME_PAGE_URL ?>images/faces/face1.jpg"
                                                            width="113" height="97" class="img-responsive"
                                                            alt="Close up">
                                                        <div class="title right">Close up</div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-6 text-center"><img
                                                            src="<?= $HOME_PAGE_URL ?>images/faces/face2.jpg"
                                                            width="113" height="97" class="img-responsive"
                                                            alt="Full view">
                                                        <div class="title right">Full View</div>
                                                    </div>
                                                </div>
                                                <div class="row no-gutter mrg-tp-10">
                                                    <div class="col-md-3 col-sm-6 col-xs-6 text-center"><img
                                                            src="<?= $HOME_PAGE_URL ?>images/faces/face2.jpg"
                                                            width="113" height="97" class="img-responsive"
                                                            alt="Side Face">
                                                        <div class="title wrong">Side Face</div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-6 text-center"><img
                                                            src="<?= $HOME_PAGE_URL ?>images/faces/face4.jpg"
                                                            width="113" height="97" class="img-responsive"
                                                            alt="Blur Image">
                                                        <div class="title wrong">Blur Image</div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-6 text-center"><img
                                                            src="<?= $HOME_PAGE_URL ?>images/faces/face5.jpg"
                                                            width="113" height="97" class="img-responsive" alt="Group ">
                                                        <div class="title wrong">Group</div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-6 text-center"><img
                                                            src="<?= $HOME_PAGE_URL ?>images/faces/face6.jpg"
                                                            width="113" height="97" class="img-responsive"
                                                            alt="Watermark">
                                                        <div class="title wrong">Watermark</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="privacy-promo">
                                                <h4 class="mrg-tp-30">Other ways to upload photo</h4>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="promo">
                                                            <figure>
                                                                <img src="<?= $HOME_PAGE_URL ?>images/icon4.jpg"
                                                                     width="61" height="70"
                                                                     alt="Upload from Mobile">
                                                            </figure>

                                                            <figcaption>
                                                                <h4>Upload from Mobile</h4>
                                                                <p>Click <a href="#">Click here</a> to upload photo from
                                                                    your mobile. We will send you upload instructions
                                                                    via SMS</p>
                                                            </figcaption>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="promo">
                                                            <figure>
                                                                <img src="<?= $HOME_PAGE_URL ?>images/icon5.jpg"
                                                                     width="61" height="70" alt="Send via Email">
                                                            </figure>
                                                            <figcaption>
                                                                <h4>Send via Email</h4>
                                                                <p>Email your photo to <a href="mailto:photos@kp.com">photos@kp.com</a>
                                                                    along with your profile id (KP245454567)</p>
                                                            </figcaption>
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
                </div>
            </section>
        </div>
    </main>
</div>
<?php
require_once __DIR__ . '/_photosection.php';
?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/simplelightbox/simple-lightbox.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<link href='<?= Yii::$app->request->baseUrl ?>/plugings/simplelightbox/simplelightbox.min.css' rel='stylesheet'
      type='text/css'>
<link href='<?= Yii::$app->request->baseUrl ?>/plugings/cropping/imgareaselect.css' rel='stylesheet' type='text/css'>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/cropping/jquery.imgareaselect.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/cropping/jquery.form.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
