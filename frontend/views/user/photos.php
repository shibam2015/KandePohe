<?php

use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use common\components\CommonHelper;

use yii\helpers\ArrayHelper;


$HOME_URL = Yii::getAlias('@web') . "/";
$HOME_URL_SITE = Yii::getAlias('@web') . "/site/";

$HOME_PAGE_URL = Yii::getAlias('@web') . "/";
$UPLOAD_DIR = Yii::getAlias('@frontend') . '/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') . '/web/';
#echo "<pre>"; print_r($model);
?>

<div class="">
    <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
    <main>

        <div class="main-section">

            <section>

                <div class="container">

                    <div class="row">

                        <div class="col-sm-12">

                            <div class="white-section">

                                <h3>Add Profile Photo </h3>
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
                                                    <div class="image">
                                                        <div class="placeholder text-center">
                                                            <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->user->identity->propic, 200), ['class' => 'img-responsive mainpropic', 'width' => '200', 'height' => '200', 'alt' => 'Profile Pic']); ?>
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

                                                            <?php

                                                            $form = ActiveForm::begin([
                                                                'id' => 'form-photo',
                                                            ]);
                                                            ?>
                                                            <!--<form method="POST" name="propicform" id="propicform" enctype="multipart/form-data">-->
                                                            <input type="hidden" name="id" id="id"
                                                                   value="<?= base64_encode(Yii::$app->user->identity->id) ?>">
                                                            <div id="file_browse_wrapper">Upload photo from computer
                                                                <input type="file" id="file_browse" name="file_browse[]"
                                                                       class="fileupload" multiple>
                                                            </div>
                                                            <!--</form>-->
                                                            <?php ActiveForm::end(); ?>
                                                        </div>

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
                                                            if ($V['Is_Profile_Photo'] == 'YES') {
                                                                $SELECTED = "selected";
                                                            } ?>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <a <?php if ($V['Is_Profile_Photo'] == 'YES'){ ?>class="selected"<?php } ?>
                                                                   href="#">
                                                                    <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name'], 140), ['class' => 'img-responsive ' . $SELECTED, 'height' => '140', 'alt' => 'Photo' . $K, 'style' => "height:140px;"]); ?>
                                                                </a>

                                                                <a href="javascript:void(0)"
                                                                   class="pull-left profile_set"
                                                                   data-id="<?= $V['iPhoto_ID'] ?>"
                                                                   data-target="#photodelete" data-toggle="modal">
                                                                    Profile pic
                                                                </a>

                                                                <a href="javascript:void(0)"
                                                                   class="pull-right profile_delete"
                                                                   data-id="<?= $V['iPhoto_ID'] ?>"
                                                                   data-target="#photodelete" data-toggle="modal">
                                                                    <i aria-hidden="true" class="fa fa-trash-o"></i>
                                                                </a>

                                                            </div>

                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                            <p> No Photos Available</p>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- <div class="col-md-3 col-sm-3 col-xs-6">

                                                        <a class="selected" href="#">
                                                            <?= Html::img('@web/images/placeholder.jpg', ['width' => '200', 'height' => '200', 'alt' => 'placeholder', 'class' => 'img-responsive']); ?>
                                                        </a>

                                                        <a href="#" class="pull-left"> Profile pic </a>

                                                        <a href="#" class="pull-right"> <i aria-hidden="true"
                                                                                           class="fa fa-trash-o"></i>
                                                        </a>
                                                    </div> -->
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
                                            </div>
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-5">

                                            <?php
                                            /*                    $form = ActiveForm::begin([
                                                                    'id' => 'form-register6',
                                                                ]);
                                                                */ ?><!--
                    <? /*= Html::submitButton('CONTINUE', ['class' => 'btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right', 'name' => 'CONTINUE']) */ ?>

                    --><?php /*ActiveForm::end(); */ ?>
                                            <a href="<?= $HOME_URL ?>user/my-profile"
                                               class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right"> My
                                                Profile</a>
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

                                                            <figure><img src="<?= $HOME_PAGE_URL ?>images/icon4.jpg"
                                                                         width="61" height="70"
                                                                         alt="Upload from Mobile"></figure>

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

                                                            <figure><img src="<?= $HOME_PAGE_URL ?>images/icon5.jpg"
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
                        if (count($model) > 0) {
                            foreach ($model as $K => $V) {
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
<div class="modal fade" id="photodelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo"></p>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
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
                            <a href="javascript:void(0)" class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left"
                               data-dismiss="modal"> No </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Footer -->
    </div>
</div>

<script language="javascript" type="text/javascript">
    var userid = "<?=base64_encode(Yii::$app->user->identity->id)?>";
</script>


<?php
$this->registerJs('
  $(function () {
        $(".fileupload").change(function () {
        Pace.restart();
        var tflag= 1;
            if (typeof (FileReader) != "undefined") {
                //var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg)$/;
                $($(this)[0].files).each(function () {
                    var file = $(this);
                    if (regex.test(file[0].name.toLowerCase())) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            //$(".mainpropic").attr("src", e.target.result);
                        }
                        reader.readAsDataURL(file[0]);
                    } else {
                        tflag= 0;
                        alert(file[0].name + " is not a valid image file.");
                        return false;
                    }
                });
                var file_len = $(this)[0].files.length;
                if (file_len != 0 && tflag == 1) {
                    
                    var file = $(this);
                    var formObj = $("#propicform");
                    var formData = new FormData($("#propicform"));
                    //formData.append( "fileInput", $("#file_browse")[0].files[0]);
                    
                    if (file_len != 0) {
                        $.each($(this)[0].files, function (i, file) {
                            formData.append("fileInput_" + i, file);
                        });
                    }
                    var uid = userid;
                    $.ajax({
                        url: "photoupload?id=" + uid + "&FILE=" + file,
                        type: "POST",
                        data: formData,
                        mimeType: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            var DataObject = JSON.parse(data);
                            if (DataObject.STATUS == "SUCCESS") {
                                $("#photo_list").html(DataObject.OUTPUT);
                                $("#profile_list_popup").html(DataObject.OUTPUT_ONE);
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                            } else {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE);
                            }
                            profile_photo();                    
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        alert("Request Failed");
                        }
                    });
                }
            } else {
                alert("This browser does not support HTML5 FileReader.");
            }
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
        
    });
    
   ');
?>
