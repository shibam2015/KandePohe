$(function(){
    
    // Default functionality for Bootstrap notify plugin (used in Alert Widgets)
    if(typeof $.notify == "function")
    {
        $.notifyDefaults({
            delay: 10000,
            allow_dismiss : true,
            showProgressbar: false,
            offset: 0,
            placement:{
				from: "top",
				align: "center"
			},
            animate:{
                enter : "animated fadeInDown",
                exit  : "animated fadeOutUp"
            }
        });
    }
})

/**
 * Show modal box across whole site
 * @param title (title of modal box)
 * @param href  (url to open in iframe)
 * @param height (height for the modal box)
 * @param open_type (open type "bottom-to-top" OR "right-to-left")
 * @returns {Boolean}
 */
function showModal(title, href, height, open_type, width)
{
    $('#modal-box').unbind('show.bs.modal').unbind('hidden.bs.modal');
//    $('#modal-box').find('.modal-dialog').width($("section.content").width());
    if(open_type == 'bottom-to-top')
    {
        $('#modal-box').on('show.bs.modal', function(e){
            $('#modal-box').find('.modal-dialog').addClass('bottom-to-top');
            $('.bottom-to-top').css({
        		'width' : parseInt($("#sm-body-scroll section.content").width() + parseInt($("#sm-body-scroll section.content").css('padding-right'))),
        		//'padding-right' : $("#sm-body-scroll section.content").css('padding-right')
        	});
        });
    }

    if(open_type == 'left-to-right')
    {
        $('#modal-box').on('show.bs.modal', function(e){
            $('#modal-box').find('.modal-dialog').addClass('left-to-right');
        });
    }

    if(open_type == 'right-to-left')
    {
        $('#modal-box').on('show.bs.modal', function(e){
            $('#modal-box').find('.modal-dialog').addClass('right-to-left');
        });
    }
    
    $('#modal-box').unbind('hidden.bs.modal').on('hidden.bs.modal', function (e){
        $("#modal_content").attr("src", href_blank + '?'+Date.now()); // On close of model set blank url
        $('#modal-box').find('.modal-dialog').removeClass('right-to-left').removeClass('left-to-right').removeClass('bottom-to-top');
    });

    $("#modal-box").find(".modal-title").html(title);
    var $iframe = $("#modal-box").modal("show").find("#modal_content");
    $iframe.attr("src", href + '&' + Date.now());
    if (height && !isNaN(height))
        $iframe.attr("height", height);
    else
        $iframe.attr("height", '380');
    
    if (width && !isNaN(width))
    	$('#modal-box').find('.modal-dialog').css('width',width);
    
    return false;
}

$(document).ready(function(){
    if($(".elm_textarea").length > 0){
        tinymce.init({
            selector: "textarea.elm_textarea",
            theme: "modern",
            height:300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
            style_formats: [
                {title: "Bold text", inline: "b"},
                {title: "Red text", inline: "span", styles: {color: "#ff0000"}},
                {title: "Red header", block: "h1", styles: {color: "#ff0000"}},
                {title: "Example 1", inline: "span", classes: "example1"},
                {title: "Example 2", inline: "span", classes: "example2"},
                {title: "Table styles"},
                {title: "Table row 1", selector: "tr", classes: "tablerow1"}
            ]
        });    
    }
});