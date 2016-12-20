<?php
use yii\widgets\Pjax;
use yii\helpers\Url;
?>
<!-- Modal Photo -->
<div class="modal fade" id="photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= \common\components\CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h2 class="text-center">My Photo Gallery</h2>
            </div>
            <div class="modal-body photo-gallery" id="photo-gallery">
                <div>
                    <?php Pjax::begin(['id' => 'my_gallery', 'enablePushState' => false]); ?>
                    <div class="choose-photo mrg-tp-20 text-center">
                        <div class="row" id="profile_list_popup">
                            <i class="fa fa-spinner fa-spin pink"></i> Loading...
                        </div>
                    </div>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="photodelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= \common\components\CommonHelper::getLogo() ?>" width="157" height="61" alt="logo"></p>

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
<div class="modal fade photo-kp-crop1 profilecropmodal" id="profilecrop" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog"><!--modal-lg -->
        <p class="text-center mrg-bt-10">
            <img src="<?= \common\components\CommonHelper::getLogo() ?>" width="157" height="61" alt="logo"></p>

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center" id="model_heading"> Set Profile Photo</h2>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="choose-photo">
                    <div class="text-center " id="crop_loader">
                        <i class="fa fa-spinner fa-spin pink"></i> Loading...
                    </div>
                    <!--<div class="row">
                        <div class="col-sm-2">
                            <img class="img-circle" id="avatar-edit-img" height="128" data-src="default.jpg"  data-holder-rendered="true" style="width: 140px; height: 140px;" src="default.jpg"/>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="changePic" class="" style="">
                                <form id="cropimage" method="post" enctype="multipart/form-data">
                                    <!--<label>Photo For Cropping</label>-->
                                    <input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value=""/>
                                    <input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value=""/>
                                    <input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis"/>
                                    <input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis"/>
                                    <input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value=""/>
                                    <input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value=""/>
                                    <input type="hidden" name="action" value="" id="action"/>
                                    <input type="hidden" name="image_name" value="" id="image_name"/>
                                    <input type="hidden" name="image_id" value="" id="image_id"/>

                                    <div id='preview-avatar-profile' class="photo-kp-crop">
                                        <img class="img-responsive preview" id='photov' width="" alt="">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer -->
                </div>
            </div>
            <div class="modal-footer crop_save" style="display: none;">
                <div class="row">
                    <div class="col-md-4 col-sm-10 col-sm-offset-1">
                        <button type="button" class="btn btn-primary mrg-tp-10 col-xs-12" data-dismiss="modal">Back
                        </button>
                    </div>
                    <div class="col-md-4  col-sm-10 col-sm-offset-1 ">
                        <button type="button" id="btn-crop" class="btn btn-primary mrg-tp-10 col-xs-12 crop-save-btn"
                                disabled>Crop & Save
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="photoList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= \common\components\CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>

        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>-->
                <h2 class="text-center"><?= Yii::$app->params['uploadPhotoListWait'] ?></h2>
            </div>
            <div class="modal-body" id="photoListDiv" style="margin-top: -35px;">
            </div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
    var userid = "<?=base64_encode(Yii::$app->user->identity->id)?>";
</script>
<?php
$this->registerJs('
        $(document).on("click",".file_browse_wrapper",function(e){
            $(".modal").modal("hide");
            $("#file_browse").click();
        });
  $(function () {
        var max_file_size 		= ' . Yii::$app->params['max_file_size'] . '; //allowed file size. (1 MB = 1048576 Bytes)
        //var allowed_file_types 		= ["image/png", "image/gif", "image/jpeg", "image/pjpeg"]; //allowed file types
        var allowed_file_types 		= ["image/jpeg", "image/pjpeg"]; //allowed file types
        var result_output 		= "#output"; //ID of an element for response output
        var my_form_id 			= "#upload_form"; //ID of an element for response output
        var total_files_allowed 	= ' . Yii::$app->params['uploadPhotoLimit'] . '; //Number files allowed to upload at a time

//on form submit
$(".fileupload").change(function () {
    $(my_form_id).submit();
});
$(my_form_id).on( "submit", function(event) {
    event.preventDefault();
    var proceed = true; //set proceed flag
    var error = [];	//errors
    var names_photo = [];	//photo list
    var total_files_size = 0;

    if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn"t supports File API
        showNotification("E", "' . Yii::$app->params['browserFileSupportError'] . '", "Error");
    }else{
        var total_selected_files = this.elements["__files[]"].files.length; //number of files
		if(total_selected_files > total_files_allowed){
            showNotification("E", "You have selected "+total_selected_files+" file(s), " + total_files_allowed +" is maximum!", "Error");
            proceed = false; //set proceed flag to false
        }
		 //iterate files in file input field
		$(this.elements["__files[]"].files).each(function(i, ifile){
            if(ifile.value !== ""){ //continue only if file(s) are selected
                if(allowed_file_types.indexOf(ifile.type) === -1){ //check unsupported file
                    //error.push( "<b>"+ ifile.name + "</b> is unsupported file type!"); //push error text
                    showNotification("E", "<b>"+ ifile.name + "</b> is unsupported file type!", "Error");
                    proceed = false; //set proceed flag to false
                }
                names_photo.push(ifile.name);
                total_files_size = total_files_size + ifile.size; //add file size to total size
            }
        });
		if(total_files_size > max_file_size){
            var temp_max_file_size = (max_file_size/1048576)+" MB";
            var temp_total_files_size = (total_files_size/1048576).toFixed(2)+" MB";
            //showNotification("E", "You have "+total_selected_files+" file(s) with total size "+total_files_size+", Allowed size is " + max_file_size +", Try smaller file!", "Error");
            showNotification("E", "You have "+total_selected_files+" file(s) with total size "+temp_total_files_size+", Allowed size is " + temp_max_file_size+", Try smaller file!", "Error");
            proceed = false; //set proceed flag to false
        }
        /*
        var _URL = window.URL || window.webkitURL;
        var temp_wh = 0;
        var msg_hw = "";
		$(this.elements["__files[]"].files).each(function(i, ifile){
                    var image, file1;
            if(ifile.value !== ""){
                    if ((file1 = ifile)) {
                        image = new Image();
                        image.onload = function() {
                           if(this.width <300 && this.height < 300){
                                showNotification("E", "<b>"+ ifile.name + "</b> is smaller by height or Width! Please select large photo.", "Error");
                                //msg_hw += "<b>"+ ifile.name + "</b> is smaller by height or Width! Please select large photo.<br>";
                                proceed = false; //set proceed flag to false
                                console.log(msg_hw);
                            }
                        };
                        image.src = _URL.createObjectURL(file1);
                    }
            }
        });*/
		var submit_btn  = $("#file_browse_wrapper"); //form submit button
		//var submit_btn  = $(this).find("input[type=submit]"); //form submit button
		//if everything looks good, proceed with jQuery Ajax
		if(proceed){
		    submit_btn.html("Please Wait...").prop( "disabled", true); //disable submit button
		    //loaderStart();
		    var htmlPhotoList = "";
		    for (ctri = 0; ctri < names_photo.length; ctri++) {
		        htmlPhotoList += "<div class=\"notice kp_warningv\" id=\"photolists_"+ctri+"\"><span>"+names_photo[ctri]+"</span> </div>";
            }
            $("#photoList").modal({
                backdrop: "static",
                keyboard: false
            });
            $("#photoListDiv").html(htmlPhotoList);
            var form_data = new FormData(this); //Creates new FormData object
            //var post_url = $(this).attr("action"); //get action URL of form
            var uid = userid;
            var post_url = "photo-upload?id=" + uid ;
            //jQuery Ajax to Post form data
            $.ajax({
				url : post_url,
				type: "POST",
				data : form_data,
				contentType: false,
				cache: false,
				processData:false,
				mimeType:"multipart/form-data"
			}).done(function(res){ //
                $(my_form_id)[0].reset(); //reset form
                //$(result_output).html(res); //output response from server
                var DataObject = JSON.parse(res);
                            if (DataObject.STATUS == "S") {
                                $("#photoList").modal();
                                $("#photo_list").html(DataObject.HtmlOutput);
                                setTimeout(function(){
                                       setTimeout(function(){
                                          var Total = names_photo.length - 1;
                                          for (tempi = 0; tempi < names_photo.length; tempi++) {
                                              $("#photolists_"+tempi).addClass("kp_success").removeClass("kp_warningv");
                                              if(tempi == Total){
                                                setTimeout(function(){
                                                    notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                                }, 1500);
                                              }
                                          }
                                       }, 1000);
                                }, 3000);
                                //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                lightBox();
                                profile_photo();

                            } else {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                            }
                            submit_btn.html("Upload photo from computer").prop( "disabled", false); //enable submit button once ajax is done
                }).error(function (jqXHR, textStatus, errorThrown) {
                        showNotification(\'E\', \'Something went wrong. Please try again !\', \'Error\');
                        });
		    }
	    }
        $(error).each(function(i){ //output any error to output element
            //$(result_output).append("<div class="error">"+error[i]+"</div>");
            //$(result_output).append("<div class=\"error\">"+error[i]+"</div>");
            showNotification("E", "+error[i]+", "Error");
        });
    });
    });

        $(document).on("click",".gallery-popup",function(e){
            commonRequest("' . Url::to(['user/photo-pop-up']) . '","#photo-gallery","1");
        });
   ');

$this->registerJs('
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
  $(function () {
        $(".yes").click(function(){
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
                                    $("#photo_list").html(DataObject.HtmlOutput);
                                    $(".mainpropic").attr("src", DataObject.PROFILE_PHOTO);
                                    $(".profile_photo_one").attr("src", DataObject.PROFILE_PHOTO_ONE);
                                    notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                }else{
                                    $("#photo_list").html(DataObject.HtmlOutput);
                                    if(DataObject.PROFILE_PHOTO != ""){
                                        $(".mainpropic").attr("src", DataObject.PROFILE_PHOTO);
                                    }
                                    if(DataObject.PROFILE_PHOTO_ONE != ""){
                                        $(".profile_photo_one").attr("src", DataObject.PROFILE_PHOTO_ONE);
                                    }
                                    notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                }
                                lightBox();
                            } else {
                                loaderStop();
                                   notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                            }
                            profile_photo();
                            lightBox();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        loaderStop();
                        notificationPopup(\'ERROR\', \'Something went wrong. Please try again !\', \'Error\');
                        }
                    });
        })
    });
   ');


$this->registerJs("
        $(document).on('click','.set_profile_photo1',function(e){

       var croppicContainerPreloadOptions = {
				//uploadUrl:'img_save_to_file.php',
				cropUrl:'set-profile-photo-one',
				loadPicture:$(this).data('item'),
				imgId:$(this).data('id'),
				imgName:$(this).data('name'),
				modal:true,
				//enableMousescroll:true,
				//doubleZoomControls:false,
			    rotateControls: false,
			    zoomFactor:50,
				loaderHtml:'<div class=\'loader bubblingG\'><span id=\'bubblingG_1\'></span><span id=\'bubblingG_2\'></span><span id=\'bubblingG_3\'></span></div> ',
				//onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				//onAfterImgUpload: function(){console.log('onAfterImgUpload') },
				//onImgDrag: function(){ console.log('onImgDrag') },
				//onImgZoom: function(){ console.log('onImgZoom') },
				//onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				//onAfterImgCrop:function(e,response){ console.log('onAfterImgCrop')},
				onReset:function(){ console.log('onReset'); $('.kp_crop_close').hide();},
				onError:function(errormessage){
				    showNotification('E', 'onError:'+errormessage); //console.log('onError:'+errormessage)
				}
		}
		var cropContainerPreload = new Croppic('cropContainerPreload', croppicContainerPreloadOptions);
    });


");

?>
