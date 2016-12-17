$( document ).ready(function() {

    (function() {
        /*[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
         new SelectFx(el);
         } );*/
        if( $('select').length ){
            $('select').niceSelect();
        }
        if ($('select.tag-select-box').length) {
            $('select.tag-select-box').niceSelect('destroy');
        }
    })();


    jQuery(document).on('click','[data-toggle*=modal]',function(){
        jQuery('[role*=dialog]').each(function(){
            switch(jQuery(this).css('display')){
                case('block'):{jQuery('#'+jQuery(this).attr('id')).modal('hide'); break;}
            }
        });
    });

    $(document).ready(function(){

        // Dirty fix for jumping scrollbar when modal opens

        $('#requestModal').on('show.bs.modal', function (e) {
            if ($(window).width() > 768) {
                $(".navbar-default").css("padding-right","15px");
            }
        });

        $('#requestModal').on('hide.bs.modal', function (e) {
            if ($(window).width() > 768) {
                $(".navbar-default").css("padding-right","0px");
            }
        });

    });

    function toggleChevron(e) {
        $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('fa-angle-down fa-angle-up');
    }
    $('#accordion').on('hidden.bs.collapse', toggleChevron);
    $('#accordion').on('shown.bs.collapse', toggleChevron);

    function init() {
        window.addEventListener('scroll', function(e){
            var distanceY = window.pageYOffset || document.documentElement.scrollTop,
                shrinkOn = 100,
                header = document.querySelector("header");
            if (distanceY > shrinkOn) {
                classie.add(header,"smaller");
            } else {
                if (classie.has(header,"smaller")) {
                    classie.remove(header,"smaller");
                }
            }
        });
    }
    window.onload = init();

    $("#chatbox").click(function(e){
        e.preventDefault();
        $('body').toggleClass('chat-move');
        $('.chatwe').toggleClass('chat-height');
    });



    $(function () {

        var $activate_selectator4 = $('#activate_selectator4');
        $activate_selectator4.click(function () {
            var $select4 = $('.select4');
            if ($select4.data('selectator') === undefined) {
                $select4.selectator({
                    showAllOptionsOnFocus: true
                });
                $activate_selectator4.val('destroy selectator');
            } else {
                $select4.selectator('destroy');
                $activate_selectator4.val('activate selectator');
            }
        });
        $activate_selectator4.trigger('click');

    });


    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
    });



    $('head style[type="text/css"]');
    window.randomize = function() {
        if ($(".radial-progress").length) {
            $('.radial-progress').attr('data-progress', PRO_COMP);
        }

        //$('.radial-progress').attr('data-progress', Math.floor(Math.random() * 100));
    }
    setTimeout(window.randomize, 200);
    $('.radial-progress').click(window.randomize);




    $(function() {
        if( $( "#slider-range" ).length ){

            $( "#slider-range" ).slider({
                range: true,
                min: 0,
                max: 500,
                values: [ 75, 300 ],
                slide: function( event, ui ) {
                    $( "#amount" ).val( "km" + ui.values[ 0 ] + " - km" + ui.values[ 1 ] );
                }
            });
            $( "#amount" ).val( "km" + $( "#slider-range" ).slider( "values", 0 ) +
            " - km" + $("#slider-range").slider("values", 1));
        }

    });


    $(document).ready(function(){
        if( $('[data-toggle="tooltip"]').length ){
            $('[data-toggle="tooltip"]').tooltip();
        }



        $("#filter-toggle").click(function(){
            $(".open-div").toggle();
        });
        if( $('#ex18a').length ){
            $("#ex18a").slider({min  : 0, max  : 10, value: 5, labelledby: 'ex18-label-1'});
        }
        if( $('#ex18b').length ){
            $("#ex18b").slider({min  : 0, max  : 10, value: [3, 6], labelledby: ['ex18-label-2a', 'ex18-label-2b']});
        }

    });


    (function() {
        // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
        if (!String.prototype.trim) {
            (function() {
                // Make sure we trim BOM and NBSP
                var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                String.prototype.trim = function() {
                    return this.replace(rtrim, '');
                };
            })();
        }

        [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
            // in case the input is already filled..
            if( inputEl.value.trim() !== '' ) {
                classie.add( inputEl.parentNode, 'input--filled' );
            }

            // events:
            inputEl.addEventListener( 'focus', onInputFocus );
            inputEl.addEventListener( 'blur', onInputBlur );
        } );

        function onInputFocus( ev ) {
            classie.add( ev.target.parentNode, 'input--filled' );
        }

        function onInputBlur( ev ) {
            if( ev.target.value.trim() === '' ) {
                classie.remove( ev.target.parentNode, 'input--filled' );
            }
        }
    })();
});

$(document).ready(function(){
    if( $('[data-toggle="tooltip"]').length ){
        $('[data-toggle="tooltip"]').tooltip();
    }

});
/* NOTIFICATION POPUP START */
function notificationPopup(type, msg, title) {
    $(".modal").modal("hide");
    if (type == 'SUCCESS' || type == 'S') {
        var msg = '<span class="text-success"><strong>&#10003;</strong></span> ' + msg;
        $('#notification_msg').html(msg);
        //$('#notification_header').html(type);
    } else if (type == 'ERROR' || type == 'E') {
        var msg = '<span class="text-error"><strong>&#215;</strong></span> ' + msg;
        $('#notification_msg').html(msg);
        //$('#notification_header').html(type);
    } else {
        $('#notification_msg').html(msg);
    }

    $('#notification_header').html(title);
    $("#notification-model").modal("show");
}
/* NOTIFICATION POPUP END */

/* PHOTO PREVIEW START */
function photoPreview(input, divid) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + divid).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
/* PHOTO PREVIEW END */

function getInlineDetail(url, htmlId, type) {
    $.ajax({
        url: url,
        type: "POST",
        data: {"type": type},
        success: function (res) {
            $(htmlId).html(res);
        }
    });
}

function setDesign() {
    $('select').niceSelect();
    (function () {
        // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
        if (!String.prototype.trim) {
            (function () {
                // Make sure we trim BOM and NBSP
                var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                String.prototype.trim = function () {
                    return this.replace(rtrim, '');
                };
            })();
        }

        [].slice.call(document.querySelectorAll('input.input__field')).forEach(function (inputEl) {
            // in case the input is already filled..
            if (inputEl.value.trim() !== '') {
                classie.add(inputEl.parentNode, 'input--filled');
            }

            // events:
            inputEl.addEventListener('focus', onInputFocus);
            inputEl.addEventListener('blur', onInputBlur);
        });

        function onInputFocus(ev) {
            classie.add(ev.target.parentNode, 'input--filled');
        }

        function onInputBlur(ev) {
            if (ev.target.value.trim() === '') {
                classie.remove(ev.target.parentNode, 'input--filled');
            }
        }
    })();
}
/* Overlay Loader Start */

function loaderStop(element) {
    if (typeof(element) === 'undefined') element = 'main-section';
    $('.' + element).waitMe('hide');
    //$('.main-section').waitMe('hide');
}
function loaderStart(element) {
    if (typeof(element) === 'undefined') element = 'main-section';
    $(".modal").modal("hide");
    //$('.main-section').waitMe({
    $('.' + element).waitMe({
        effect: 'bounce',
        text: "Please Wait...",
        bg: "rgba(255,255,255,0.7)",
        color: "#EA0B44"
    });
}
/* Overlay Loader End */

/* Request send Start */

function sendRequest(url, htmlId, dataArr) {
    $.ajax({
        url: url,
        type: "POST",
        data: dataArr,
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            var dataObj = JSON.parse(res);
            $(htmlId).html(dataObj.HtmlOutput);
            loaderStop();
            if (dataObj.Notification.MESSAGE != '' && dataObj.Notification.length != 0) {
                showNotification(dataObj.Notification.STATUS, dataObj.Notification.MESSAGE);
            }

        }
    });
}
function sendRequestDashboard(url, htmlId, type, pid, dataArr) {
    loaderStart();
    $.ajax({
        url: url,
        type: "POST",
        data: dataArr,
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            loaderStop();
            var dataObj = JSON.parse(res);
            //console.log(dataObj);console.log(type);console.log(pid);
            var ToUserId = dataArr.get("ToUserId");
            var UserName = dataArr.get("Name");
            var RGNumber = dataArr.get("RGNumber");
            if (type == 'SI') {
                if (dataObj.STATUS == 'S') {
                    $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-info isent" role="button" data-id="' + ToUserId + '" data-name="' + UserName + '" data-rgnumber="' + RGNumber + '">Cancel Interest <i class="fa fa-heart"></i></a>');
                }
                if (dataObj.STATUS == 'W') {
                    $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-info accept_decline adbtn" role="button" data-target="#accept_decline" data-toggle="modal" data-id="' + ToUserId + '" data-name="' + UserName + '" data-rgnumber="' + RGNumber + '" data-type="Accept Interest"> Accept <i class="fa fa-check"></i> </a> <a href="javascript:void(0)" class="btn btn-info accept_decline adbtn" role="button" data-target="#accept_decline" data-toggle="modal" data-id="' + ToUserId + '" data-name="' + UserName + '" data-rgnumber="' + RGNumber + '" data-type="Decline Interest">Decline <i class="fa fa-close"></i> </a>');
                }
            }
            if (type == 'SL') {
                if (dataObj.STATUS == 'S') {
                    $('.' + pid).html('<a href="javascript:void(0)" class="isent" role="button">Interest Sent <i class="fa fa-heart"></i></a>');
                }
            }
            if (type == 'R_A_D_B') {
                if (dataObj.Action == 'ACCEPT_INTEREST') {
                    if (dataObj.STATUS == 'S' || dataObj.STATUS == 'IA') {
                        $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-info isent" role="button">Connected <i class="fa fa-heart"></i></a>');
                    } else if (dataObj.STATUS == 'IN') {
                        $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-info sendinterestpopup" role="button" data-target="#sendInterest" data-toggle="modal" data-id="' + ToUserId + '" data-name="' + UserName + '" data-rgnumber="' + RGNumber + '">Send Interest <i class="fa fa-heart-o"></i> </a>');
                    } else {//(dataObj.STATUS == 'W')
                        $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-link isent" role="button"><i class="fa fa-close"></i>Not Allowed</a>');
                    }
                } else if (dataObj.Action == 'DECLINE_INTEREST') {
                    if (dataObj.STATUS == 'S' || dataObj.STATUS == 'IR') {
                        $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-info isent" role="button">Rejected<i class="fa fa-close"></i></a>');
                    } else if (dataObj.STATUS == 'IN') {
                        $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-info sendinterestpopup" role="button" data-target="#sendInterest" data-toggle="modal" data-id="' + ToUserId + '" data-name="' + UserName + '" data-rgnumber="' + RGNumber + '">Send Interest <i class="fa fa-heart-o"></i> </a>');
                    }
                } else if (dataObj.Action == 'CANCEL_INTEREST') {
                    if (dataObj.STATUS == 'S' || dataObj.STATUS == 'IN') {
                        $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-info sendinterestpopup" role="button" data-target="#sendInterest" data-toggle="modal" data-id="' + ToUserId + '" data-name="' + UserName + '" data-rgnumber="' + RGNumber + '">Send Interest <i class="fa fa-heart-o"></i> </a>');
                    } else if (dataObj.STATUS == 'IA') {
                        $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-info isent" role="button">Connected <i class="fa fa-heart"></i></a>');
                    } else if (dataObj.STATUS == 'IR') {
                        $('.' + pid).html('<a href="javascript:void(0)" class="btn btn-info isent" role="button">Rejected<i class="fa fa-close"></i></a>');
                    }
                }
            }
            if (type == 'MAILBOX') {
                loaderStart();
                sendRequest("last-msg", "#last_message_section", dataArr);
                sendRequest("more-coversation-all", "#other_convo", dataArr);
            }
            //notificationPopup(dataObj.STATUS, dataObj.MESSAGE, dataObj.TITLE);
            showNotification(dataObj.STATUS, dataObj.MESSAGE);
        }
    });
}
/* Request send End */


$(document).on("click", ".sendinterestpopup", function (e) {
    $("#to_name").html($(this).data("name"));
    $("#to_rg_number").html($(this).data("rgnumber"));
    $(".send_request").attr("data-id", $(this).data("id"));
    if ($(this).closest('p').attr('class') === undefined) {
        $(".send_request").attr("data-parentid", $(this).closest('li').attr('class'));
    }
    else {
        $(".send_request").attr("data-parentid", $(this).closest('p').attr('class'));

    }

});

$(document).on("click", ".accept_decline", function (e) {
    $(".to_name").html($(this).data("name"));
    $(".to_rg_number").html($(this).data("rgnumber"));
    $(".a_b_d").attr("data-id", $(this).data("id"));
    $(".a_b_d").attr("data-type", $(this).data("type"));
    $(".main_title_popup").html($(this).data("type"));
    if ($(this).data("type") == 'Accept Interest') {
        $(".main_msg_popup").html(AcceptInterest);
    } else if ($(this).data("type") == 'Decline Interest') {
        $(".main_msg_popup").html(DeclineInterest);
    } else {
        $(".main_msg_popup").html(CancelInterest);
    }
    if ($(this).closest('p').attr('class') === undefined) {
        $(".a_b_d").attr("data-parentid", $(this).closest('li').attr('class'));
    }
    else {
        $(".a_b_d").attr("data-parentid", $(this).closest('p').attr('class'));

    }

});


/* Notification start */
$(document).on("click", ".kp_notification_close", function (e) {
    //$('.kp_notify').hide();
    $('.kp_notify').slideUp();
});

function showNotification(type, msg, flag) {
    if (flag != 'P') {
        $(".modal").modal("hide");
    }
    if (type == 'S') {
        $('.kp_notify').removeClass('red').addClass('green');
        $('.kp_notification').html(msg);
    } else if (type == 'E') {
        $('.kp_notify').removeClass('green').addClass('red');
        $('.kp_notification').html(msg);
    } else {
        $('.kp_notify').removeClass('green').removeClass('red').addClass('yellow');
        $('.kp_notification').html(msg);
    }
    setTimeout(function () {
        $('.kp_notify').slideUp();
    }, 10000);
    $('.kp_notify').slideDown();
}
/* Notification END  */
function loaderTab() {
    var html = '<div class="text-center mrg-tp-20 mrg-lt-20"><p><i class="fa fa-spinner fa-spin pink"></i> Loading...</p></div>';
    return html;
}
function pageError(type, msg) {
    var html = '';
    if (type == 'E') {
        html = '<div class="notice kp_error"><p>' + msg + '</p></div>';
    }
    return html;
}

function mailBox(url, htmlId, dataArr) {
    loaderStart();
    $.ajax({
        url: url,
        type: "POST",
        data: dataArr,
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            loaderStop();
            var dataObj = JSON.parse(res);
            showNotification(dataObj.STATUS, dataObj.MESSAGE);
        }
    });
}
/*
 $(document).on("click",".preferences_submit",function(e){
 var $this = $(this);
 $this.button("loading");
 setTimeout(function() {
 $this.button("reset");
 }, 8000);
 });*/
function pswd(x) {
    if (x == 1) {
        return '<span class="text-success"><strong>&#10003;</strong></span>';
    } else if (x == 2) {
        return '<span class="text-error"><strong>&#215;</strong></span>';
    } else {
        return '';
    }
}

function lightBox() {
    if ($(".gallery a").length) {
        var gallery = $('.gallery a').simpleLightbox();
    }
    //$('.lightgallery').lightGallery();
    if ($(".lightgallery").length) {
        alert("Asdasd");
        $('.lightgallery').lightGallery({
            selector: '.kp_gallery'
        });
    }
}
lightBox();

$(document).on("click", ".kp_not_gallery", function (e) {
    var $lg = $('.lightgallery');
    $lg.lightGallery();
    $lg.data('lightGallery').destroy(true);
});
$(document).on("mouseover", ".kp_gallery", function (e) {
    $('.lightgallery').lightGallery({
        selector: '.kp_gallery'
    });
    lightBox();
});

function commonRequest(url, htmlId, dataArr) {
    $.ajax({
        url: url,
        type: "POST",
        data: dataArr,
        contentType: false,
        cache: false,
        processData: false,
        success: function (res) {
            var dataObj = JSON.parse(res);
            $(htmlId).html(dataObj.HtmlOutput);
            lightBox();
        }
    });
}
