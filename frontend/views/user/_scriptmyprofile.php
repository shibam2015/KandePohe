<?php #COVER PHOTO
$this->registerJs("
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
                                    url: 'user/coverupload',
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
                                         notificationPopup('ERROR', 'Something went wrong. Please try again !', 'Error');
                                    }
                            });
                    } else {
                        tflag= 0;
                        notificationPopup('ERROR', file[0].name + ' is not a valid image file.', 'Error');
                        return false;
                    }
                });
            } else {
                notificationPopup('ERROR', 'This browser does not support HTML5 FileReader.', 'Error');
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
                url: 'user/save-cover-photo',
                data: formData,
                mimeType: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){       Pace.restart(); },
                success: function(data)
                {
                    var DataObject = JSON.parse(data);
                    if (DataObject.STATUS == 'S') {
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
                         //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                         showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                         return false;
                    } else {
                          //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                          showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
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
                url: 'user/save-cover-photo',
                data: formData,
                mimeType: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){       Pace.restart(); },
                success: function(data)
                {
                    var DataObject = JSON.parse(data);
                    if (DataObject.STATUS == 'S') {
                         $('.bgImagecover').fadeOut('slow');
                         $('.bgSaveRP').remove();
                         $('.bgCancel').remove();
                         $('#timelineShade').fadeIn('slow');
                         $('#timelineBGload').removeClass('headerimage');
                         $('#timelineBGload').removeClass('ui-corner-all');
                         $('#timelineBGload').addClass('bgImagecover');
                         $('#timelineBGload').css({'margin-top':position});
                         //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                         showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                         return false;
                    } else {
                         //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                         showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
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
                        url: 'user/coverupload',
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
                                   //notificationPopup('ERROR', 'Something went wrong. Please try again !', 'Error');
                                   showNotification('ERROR', 'Something went wrong. Please try again !', 'Error');
                        }
                    });            
        })
        $('#coverphotoreposition1').click(function (){
             //notificationPopup('ERROR', 'You can\\'t reposition default cover photo.', 'Error');
             showNotification('ERROR', 'You can\\'t reposition default cover photo.', 'Error');
        })
        $('body').on('click','.bgCancel',function ()
        { 
                var formData = new FormData();
                formData.append( 'ACTION', 'CANCEL');
                $.ajax({
                            type: 'POST',
                            url: 'user/coverphotoback',
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
                                  //notificationPopup('ERROR', 'Something went wrong. Please try again !', 'Error');
                                  showNotification('ERROR', 'Something went wrong. Please try again !', 'Error');
                            }
                });
        });

        $('body').on('click','#coverphotodelete',function ()
        { 
                var formData = new FormData();
                formData.append( 'ACTION', 'DELETE');
                $.ajax({
                          type: 'POST',
                          url: 'user/coverphotoback',
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
                               //notificationPopup('ERROR', 'Something went wrong. Please try again !', 'Error');
                               showNotification('ERROR', 'Something went wrong. Please try again !', 'Error');
                          }
                });
        });
        $('#coverphotodelete1').click(function (){
             //notificationPopup('ERROR', 'You can\\'t delete default cover photo.', 'Error');
             showNotification('ERROR', 'You can\\'t delete default cover photo.', 'Error');
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
     $(document).on('click','.cover_profile_set',function(e){
            var targetd  = $(this).data('target');
            if(targetd == '#photocovermodel'){
                PP_ID = $(this).data('id');
                $('#model_heading_cover').html('" . Yii::$app->params['coverPhotoSetConfirmation'] . "');
                $('#photo').modal('hide');
                $('#photocovermodel').modal();
            }
     });
    $('.yescover').click(function(){
            Pace.restart();
            loaderStart();
            var formDataPhoto = new FormData();
            formDataPhoto.append( 'ACTION', 'GET_PHOTO_FROM_PHOTOS');
            formDataPhoto.append( 'P_ID', PP_ID);    
            $.ajax({
                        url: 'user/get-cover-photo-from-photo',
                        type: 'POST',
                        data: formDataPhoto,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                          loaderStop();
                            var DataObject = JSON.parse(data);
                            if (DataObject.STATUS == 'S') {
                                $('#timelineBackground').html(DataObject.ABC);
                                $('.modal').modal('hide');
                            } else {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                            }
                            profile_photo();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        loaderStop();
                            //notificationPopup('ERROR', 'Request Failed', 'Error');
                            showNotification('ERROR', 'Something went wrong. Please try again !', 'Error');
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
                url: 'user/save-cover-photo-from-photo',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){       Pace.restart(); },
                success: function(data)
                {
                    var DataObject = JSON.parse(data);
                    if (DataObject.STATUS == 'S') {
                         $('.bgImagecover').fadeOut('slow');
                         $('.bgSaveFP').remove();
                         $('.bgCancel').remove();
                         $('#timelineShade').fadeIn('slow');
                         $('#timelineBGload').removeClass('headerimage');
                         $('#timelineBGload').removeClass('ui-corner-all');
                         $('#timelineBGload').addClass('bgImagecover');
                         $('#timelineBGload').css({'margin-top':position});
                         //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                         showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                         return false;
                    } else {
                         //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                         showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                    }
                    profile_photo();
                }
            });
            return false;
        });
"); ?>

<?php # HIDE SHOW Profile
$this->registerJs("
          $('body').on('click','.hideshow',function ()
                    {
                        loaderStart();
                        var formData = new FormData();
                        $.ajax({
                            type: 'POST',
                            url: 'user/hide-profile',
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function(){ },
                            success: function(data)
                            {
                              loaderStop();
                              var DataObject = JSON.parse(data);
                              $('#hideshow_a').html(DataObject.OUTPUT);
                              //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                              showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                              hideshowfun();
                            },
                            error:function(){
                                            loaderStop();
                            //notificationPopup('ERROR', 'Something went wrong. Please try again !', 'Error');
                            showNotification('ERROR', 'Something went wrong. Please try again !', 'Error');
  }
                            });
            });

           function hideshowfun(){
            $('.hideshowmenu').click(function() {
                 var name = $(this).data('name');
                 $('#model_heading_hideshow').html('');
                  if(name=='Yes'){
                    $('#model_heading_hideshow').html('If You Want To Show Your Profile!','Profile Show');
                  }else{
                    $('#model_heading_hideshow').html('If You Want To Hide Your Profile!','Profile Hide');
                  }
            })
           }
           hideshowfun();
     ");
?>

<?php # ADD TAG - ADD ALL TAG - DELETE TAG
$this->registerJs("
$(document).ready(function()
{  
          $('body').on('click','.suggest_tag',function () // single add from suggested tag
          {
                        var formData = new FormData();
                        var  TAG_ID = $(this).data('id');
                        formData.append( 'TAG_ID', TAG_ID);                        
                        formData.append( 'ACTION', 'ADD-TAG');                        
                        $.ajax({
                            type: 'POST',
                            url: 'user/suggest-tag-add',
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function(){ Pace.restart(); },
                            success: function(data)
                            {
                              var DataObject = JSON.parse(data);
                              if (DataObject.STATUS == 'S') {
                                  $('#user_tag_list').html(DataObject.USER_TAG_LIST);
                                  $('.suggest_tag[data-id='+TAG_ID+']').remove();
                                  $('#tag_count').html(DataObject.TAG_COUNT);
                                  //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                  showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                              }else{
                                  //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                  showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                              }
                              
                            },
                            error:function(){
                                    //notificationPopup('ERROR', 'Something went wrong. Please try again !', 'Error');
                                    showNotification('ERROR', 'Something went wrong. Please try again !', 'Error');
                            }
                        });
          });
          
          $('body').on('click','.suggest_tag_all_v',function () // Add All from suggested tag
          {
                        var formData = new FormData();
                        formData.append( 'ACTION', 'ADD-ALL-TAG');                        
                        $.ajax({
                            type: 'POST',
                            url: 'user/suggest-tag-add',
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function(){ Pace.restart(); },
                            success: function(data)
                            {
                              var DataObject = JSON.parse(data);
                              if (DataObject.STATUS == 'S') {
                                  $('#user_tag_list').html(DataObject.USER_TAG_LIST);
                                  $('#suggest_tag_list').html(DataObject.TAG_LIST_SUGGEST);
                                  $('#tag_count').html(DataObject.TAG_COUNT);
                                  //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                  showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                              }else{
                                  //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                  showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                              }
                            },
                            error:function(){
                                    //notificationPopup('ERROR', 'Something went wrong. Please try again !', 'Error');
                                    showNotification('ERROR', 'Something went wrong. Please try again !', 'Error');
                            }
                        });
          });
          
          $('body').on('click','.tag_delete',function () // single delete from User List Tag
          {
                        var formData = new FormData();
                        var  TAG_ID = $(this).data('id');
                        formData.append( 'TAG_ID', TAG_ID);                        
                        formData.append( 'ACTION', 'DELETE-TAG');                        
                        $.ajax({
                            type: 'POST',
                            url: 'user/suggest-tag-add',
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function(){ Pace.restart(); },
                            success: function(data)
                            {
                              var DataObject = JSON.parse(data);
                              if (DataObject.STATUS == 'S') {
                                  //$('#user_tag_list').html(DataObject.USER_TAG_LIST);
                                  $('#tag_delete_'+TAG_ID).remove();
                                  $('#suggest_tag_list').html(DataObject.TAG_LIST_SUGGEST);
                                  $('#tag_count').html(DataObject.TAG_COUNT);
                                  //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                  showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                              }else{
                                  //notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                  showNotification(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                              }
                              
                            },
                            error:function(){
                                    showNotification('ERROR', 'Something went wrong. Please try again !', 'Error');
                            }
                        });
          });
});
     ");
?>

<?php # DELETE ACCOUNT
$this->registerJs("
$(document).ready(function()
{  

    $('.delete_account').click(function(){ 
            Pace.restart();
            var formDataPhoto = new FormData();
            formDataPhoto.append( 'ACTION', 'DELETE-ACCOUNT');
            $.ajax({
                        url: 'user/account-delete',
                        type: 'POST',
                        data: formDataPhoto,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            var DataObject = JSON.parse(data);
                            if (DataObject.STATUS == 'S') {
                                $('#timelineBackground').html(DataObject.ABC);
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                                setTimeout(function(){ 
                                      location.reload();                                      
                                }, 1000);                    
                            } else {
                                notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            showNotification('ERROR', 'Something went wrong. Please try again !', 'Error');
                        }
            });
    })            
    
});
     ");
?>

<?php
$this->registerJs('
$(document).on("click",".preferences_submit",function(e){
    var $this = $(this);
    $this.button("loading");
    setTimeout(function() {
        $this.button("reset");
    }, 8000);
});
');
?>