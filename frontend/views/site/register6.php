<?php

use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use common\components\CommonHelper;

use yii\helpers\ArrayHelper;


$HOME_URL = Yii::getAlias('@web')."/";
$HOME_URL_SITE = Yii::getAlias('@web')."/site/";

$HOME_PAGE_URL = Yii::getAlias('@web')."/";
$UPLOAD_DIR = Yii::getAlias('@frontend') .'/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') .'/web/';

?>
<?php
  echo $this->render('/layouts/parts/_headerregister.php');
?>

<main>

  <div class="main-section">

    <section>

      <div class="container">


        <div class="row">

          <div class="col-sm-12">

            <div class="white-section">
              <div class="col-md-9 col-sm-12">
                <div class="right-column"> <span class="welcome-note">
            <?php
            if ($model->Profile_created_for !== "Self") {
              ?>
              <p><strong>Welcome ,</strong> please give us few details about
                <strong><?= $model->First_Name; ?> </strong>.</p>
            <?php } else {
              ?>
              <p><strong>Welcome <?= $model->First_Name; ?> ,</strong> please give us few details about yourself.</p>

            <?php
            }
            ?>

              </span>
                </div>
              </div>


              <h3>Add Profile Photo <a href="<?=$HOME_URL_SITE?>verification" class="pull-right"><span class="link_small">( I will do this later )</span></a>

              </h3>



              <div class="two-column">

                <div class="row">

                  <div class="col-sm-6 bord">

                    <div class="row">

                      <div class="col-sm-12">

                        <p class="mrg-bt-10"><i class="fa fa-lock text-danger"></i> 100% Privacy Settings</p>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col-sm-5">

                        <div class="image">



                          <div class="placeholder text-center">

                            <!--<img src="<? /*=($model->propic!='') ? $model->propic : $HOME_PAGE_URL.'images/placeholder.jpg';*/ ?>" width="200" height="200" alt="placeholder" class="img-responsive mainpropic">-->

                            <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->user->identity->propic, 200), ['class' => 'img-responsive mainpropic', 'width' => '200', 'height' => '200', 'alt' => 'Profile Pic']); ?>

                            <div class="add-photo" data-toggle="modal" data-target="#photo"> <span class="file-input btn-file"> <i class="fa fa-plus-circle"></i> Add a photo </span> </div>

                          </div>

                          <p class="mrg-tp-10">Upload a photo and get 12 times more response</p>

                        </div>

                      </div>

                      <div class="col-sm-7">

                        <div class="upload">

                          <div>

                            <?php

                            $form = ActiveForm::begin([

                                'id' => 'form-register6',

                            ]);

                            ?>

                            <!--<form method="POST" name="propicform" id="propicform" enctype="multipart/form-data">-->

                            <input type="hidden" name="id" id="id" value="<?=base64_encode($model->id)?>">

                            <div id="file_browse_wrapper">Upload photo from computer

                              <input type="file" id="file_browse" name="file_browse" class="fileupload">

                            </div>

                            <!--</form>-->

                            <?php ActiveForm::end(); ?>

                          </div>

                          <div class="bar-devider"> <span>OR</span> </div>

                          <a class="btn btn-block btn-social btn-facebook"> <i class="fa fa-facebook"></i> Sign in with Facebook </a> </div>

                      </div>

                    </div>

                    <div class="choose-photo">

                      <div class="row">

                        <div class="col-md-3 col-sm-3 col-xs-6">

                          <a class="selected" href="#">
                            <?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class' => 'img-responsive']); ?>
                          </a>

                          <a href="#" class="pull-left"> Profile pic </a>

                          <a href="#" class="pull-right"> <i aria-hidden="true" class="fa fa-trash-o"></i> </a>

                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6">

                          <a class="selected" href="#">
                            <?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class' => 'img-responsive']); ?>
                          </a>

                          <a href="#" class="pull-left"> Profile pic </a>

                          <a href="#" class="pull-right"> <i aria-hidden="true" class="fa fa-trash-o"></i> </a>

                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6">

                          <a class="selected" href="#">
                            <?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class' => 'img-responsive']); ?>
                          </a>

                          <a href="#" class="pull-left"> Profile pic </a>

                          <a href="#" class="pull-right"> <i aria-hidden="true" class="fa fa-trash-o"></i> </a>

                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6">

                          <a class="selected" href="#">
                            <?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class' => 'img-responsive']); ?>
                          </a>

                          <a href="#" class="pull-left"> Profile pic </a>

                          <a href="#" class="pull-right"> <i aria-hidden="true" class="fa fa-trash-o"></i> </a>

                        </div>



                        <div class="col-md-3 col-sm-3 col-xs-6">

                          <a class="selected" href="#">
                            <?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class' => 'img-responsive']); ?>
                          </a>

                          <a href="#" class="pull-left"> Profile pic </a>

                          <a href="#" class="pull-right"> <i aria-hidden="true" class="fa fa-trash-o"></i> </a>

                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6">

                          <a class="selected" href="#">
                            <?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class' => 'img-responsive']); ?>
                          </a>

                          <a href="#" class="pull-left"> Profile pic </a>

                          <a href="#" class="pull-right"> <i aria-hidden="true" class="fa fa-trash-o"></i> </a>

                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6">

                          <a class="selected" href="#">
                            <?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class' => 'img-responsive']); ?>
                          </a>

                          <a href="#" class="pull-left"> Profile pic </a>

                          <a href="#" class="pull-right"> <i aria-hidden="true" class="fa fa-trash-o"></i> </a>

                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-6">

                          <a class="selected" href="#">
                            <?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class' => 'img-responsive']); ?>
                          </a>

                          <a href="#" class="pull-left"> Profile pic </a>

                          <a href="#" class="pull-right"> <i aria-hidden="true" class="fa fa-trash-o"></i> </a>

                        </div>

                      </div>

                    </div>

                    <div class="privacy-promo">

                      <div class="row">

                        <div class="col-sm-12">

                          <div class="phone-privacy mrg-tp-30">

                            Photo Privacy <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-globe"></span> <span class="caret"></span>

                            </button>

                            <ul class="dropdown-menu">

                              <li><a href="#"><span class="glyphicon glyphicon-globe"></span> <strong>Public</strong><br> <span class="sub-title">Anyone</span></a></li>

                              <li><a href="#"><span class="glyphicon glyphicon-certificate"></span> <strong>Members</strong><br> <span class="sub-title">Only Premium Members</span></a></li>



                            </ul>

                          </div>



                        </div>

                      </div>



                    </div>

                  </div>

                  <div class="col-sm-1"> </div>



                  <div class="col-sm-5">

                    <?php

                    $form = ActiveForm::begin([

                        'id' => 'form-register6',

                    ]);

                    ?>

                    <!--<form class="mrg-tp-30" method="post">-->

                    <!--<input type="hidden" name="<?/*=Yii::$app->request->csrfParam*/?>"  value="<?/*=Yii::$app->request->getCsrfToken()*/?>" />

                    <input type="submit" value="CONTINUE" class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right">-->

                    <!--</form>-->

                    <?= Html::submitButton('CONTINUE', ['class' => 'btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right', 'name' => 'CONTINUE']) ?>

                    <?php ActiveForm::end(); ?>

                    <h4 class="mrg-left-mins">Profile Photo Guidelines</h4>

                    <div class="faces-pic">

                      <div class="row no-gutter mrg-tp-30">

                        <div class="col-md-3 col-sm-6 col-xs-6 text-center"> <img src="<?=$HOME_PAGE_URL?>images/faces/face1.jpg" width="113" height="97" class="img-responsive" alt="Close up">

                          <div class="title right">Close up</div>

                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-6 text-center"> <img src="<?=$HOME_PAGE_URL?>images/faces/face2.jpg" width="113" height="97" class="img-responsive" alt="Full view">

                          <div class="title right">Full View</div>

                        </div>

                      </div>

                      <div class="row no-gutter mrg-tp-10">

                        <div class="col-md-3 col-sm-6 col-xs-6 text-center"> <img src="<?=$HOME_PAGE_URL?>images/faces/face2.jpg" width="113" height="97" class="img-responsive" alt="Side Face">

                          <div class="title wrong">Side Face</div>

                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-6 text-center"> <img src="<?=$HOME_PAGE_URL?>images/faces/face4.jpg" width="113" height="97" class="img-responsive" alt="Blur Image">

                          <div class="title wrong">Blur Image</div>

                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-6 text-center"> <img src="<?=$HOME_PAGE_URL?>images/faces/face5.jpg" width="113" height="97" class="img-responsive" alt="Group ">

                          <div class="title wrong">Group </div>

                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-6 text-center"> <img src="<?=$HOME_PAGE_URL?>images/faces/face6.jpg" width="113" height="97" class="img-responsive" alt="Watermark">

                          <div class="title wrong">Watermark</div>

                        </div>

                      </div>

                    </div>

                    <div class="privacy-promo">

                      <h4 class="mrg-tp-30">Other ways to upload photo</h4>

                      <div class="row">

                        <div class="col-sm-6">

                          <div class="promo">

                            <figure> <img src="<?=$HOME_PAGE_URL?>images/icon4.jpg" width="61" height="70" alt="Upload from Mobile"> </figure>

                            <figcaption>

                              <h4>Upload from Mobile</h4>

                              <p>Click <a href="#">Click here</a> to upload photo from your mobile. We will send you upload instructions via SMS</p>

                            </figcaption>

                          </div>

                        </div>

                        <div class="col-sm-6">

                          <div class="promo">

                            <figure> <img src="<?=$HOME_PAGE_URL?>images/icon5.jpg" width="61" height="70" alt="Send via Email"> </figure>

                            <figcaption>

                              <h4>Send via Email</h4>

                              <p>Email your photo to <a href="mailto:photos@kp.com">photos@kp.com</a> along with your profile id (KP245454567)</p>

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



<!-- Modal Photo -->

<div class="modal fade" id="photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog">

    <p class="text-center mrg-bt-10"><img src="<?=$HOME_PAGE_URL?>images/logo.png" width="157" height="61" alt="logo" ></p>

    <div class="modal-content">

      <!-- Modal Header -->

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span> </button>

        <h2 class="text-center">My Photo Gallery</h2>

        <div class="profile-control photo-btn">

          <button class="btn active" type="button"> Upload Video or Photo </button>

          <button class="btn " type="button"> Choose from Photos </button>

          <button class="btn" type="button"> Albums </button>

        </div>

      </div>

      <!-- Modal Body -->

      <div class="modal-body photo-gallery">

        <div class="choose-photo">

          <div class="row">

            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#" class="selected"><img width="200" height="200" class="img-responsive" alt="placeholder" src="<?=$HOME_PAGE_URL?>images/placeholder.jpg"></a> </div>

            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><img width="200" height="200" class="img-responsive" alt="placeholder" src="<?=$HOME_PAGE_URL?>images/placeholder.jpg"></a> </div>

            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><img width="200" height="200" class="img-responsive" alt="placeholder" src="<?=$HOME_PAGE_URL?>images/placeholder.jpg"></a> </div>

            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><img width="200" height="200" class="img-responsive" alt="placeholder" src="<?=$HOME_PAGE_URL?>images/placeholder.jpg"></a> </div>

            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><img width="200" height="200" class="img-responsive" alt="placeholder" src="<?=$HOME_PAGE_URL?>images/placeholder.jpg"></a> </div>

            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><img width="200" height="200" class="img-responsive" alt="placeholder" src="<?=$HOME_PAGE_URL?>images/placeholder.jpg"></a> </div>

            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><img width="200" height="200" class="img-responsive" alt="placeholder" src="<?=$HOME_PAGE_URL?>images/placeholder.jpg"></a> </div>

            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><img width="200" height="200" class="img-responsive" alt="placeholder" src="<?=$HOME_PAGE_URL?>images/placeholder.jpg"></a> </div>

          </div>

        </div>

      </div>

    </div>

    <!-- Modal Footer -->

  </div>

</div>

<!-- Bootstrap core JavaScript

    ================================================== -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script language="javascript" type="text/javascript">

  $(function () {

    $(".fileupload").change(function () {

      if (typeof (FileReader) != "undefined") {

        /*var dvPreview = $("#dvPreview");

         dvPreview.html("");*/

        $('.mainpropic').attr("src", 'images/placeholder.jpg');

        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;

        //console.log($(this)[0].files.length);

        $($(this)[0].files).each(function () {

          var file = $(this);

          if (regex.test(file[0].name.toLowerCase())) {

            var reader = new FileReader();

            reader.onload = function (e) {

              $('.mainpropic').attr("src", e.target.result);

              /*var img = $("<img />");

               img.attr("style", "height:100px;width: 100px");

               img.attr("src", e.target.result);

               dvPreview.append(img);*/

            }

            reader.readAsDataURL(file[0]);

          } else {

            alert(file[0].name + " is not a valid image file.");

            $('.mainpropic').attr("src", 'images/placeholder.jpg');

            return false;

          }

        });

        if($(this)[0].files.length ==0){

          //alert("1");

          $.ajax({

            url    : 'site/photoupload',

            type   : 'POST',

            data   : form.serialize(),

            //contentType: "application/json; charset=utf-8",

            dataType: "json",

            success: function (response)

            {

            },

            error  : function (e)

            {



            }

          });

        }else{

          var file = $(this);

          var formObj = $('#propicform');

          //var formData = new FormData('#propicform');

          //var formData = new FormData($('form')[0]);

          //var formData = new FormData($("#propicform"));

          var formData = new FormData($("#propicform"));

          formData.append( "fileInput", $("#file_browse")[0].files[0]);

          var uid ='<?=base64_encode($model->id)?>';

          $.ajax({

            url    : 'photoupload?id='+uid+'&FILE='+file,

            type: 'POST',

            data:  formData,

            mimeType:"multipart/form-data",

            contentType: false,

            cache: false,

            processData:false,

            success: function(data, textStatus, jqXHR)

            {

              var DataObject = JSON.parse(data);

//                    console.log(DataObject);

              if(DataObject.STATUS == 1)

              {

                //showNotification(DataObject.STATUS,DataObject.NOTIFICATION_MSG);

                $("#vPhotoCard").val("");

                $('.profile_photo').attr("src",DataObject.PHOTO);

                // $('.username').html($('#vFirstName').val()+ ' '+$('#vLastName').val());

              }else{

                $("#vPhotoCard").val("");

                // showNotification(DataObject.STATUS,DataObject.NOTIFICATION_MSG);

              }

            },

            error: function(jqXHR, textStatus, errorThrown)

            {



              //showNotification(0,"Request failed : " + textStatus );



            }

          });

        }

      } else {

        alert("This browser does not support HTML5 FileReader.");

      }

    });

  });

</script>