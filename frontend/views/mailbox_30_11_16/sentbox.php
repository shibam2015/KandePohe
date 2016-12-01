<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\widgets\Pjax;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
    <div class="main-section">
        <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
        <main>
            <section class="inbox">
                <div class="container">
                    <!--<div class="row">
                        <div class="col-sm-3 col-md-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"> Mail
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Mail</a></li>
                                    <li><a href="#">Contacts</a></li>
                                    <li><a href="#">Tasks</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-10">
                            <div class="pull-left">
                                <div class="checkbox mrg-tp-0">
                                    <input id="Remember" type="checkbox" name="Remember" value="check1">
                                    <label for="Remember" class="control-label">Select All</label>
                                    <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown">
                                        <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">All</a></li>
                                        <li><a href="#">None</a></li>
                                        <li><a href="#">Read</a></li>
                                        <li><a href="#">Unread</a></li>
                                        <li><a href="#">Starred</a></li>
                                        <li><a href="#">Unstarred</a></li>
                                    </ul>
                                    <button type="button" class="btn btn-default" title="Delete">Delete   </button>
                                    <button type="button" class="btn btn-default" title="Refresh">     <span
                                            class="glyphicon glyphicon-refresh"></span>   
                                    </button>
                                </div>
                            </div>
                            <div class="pull-right"><span class="text-muted">1-50 of 277 </span>

                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-default"><span
                                            class="glyphicon glyphicon-chevron-left"></span></button>
                                    <button type="button" class="btn btn-default"><span
                                            class="glyphicon glyphicon-chevron-right"></span></button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>-->
                    <div class="divider"></div>
                    <div class="row">
                        <?php require_once __DIR__ . '/_sidebar.php'; ?>
                        <div class="col-sm-9 col-md-10">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active nav-tabs-menu all"><a href="#all" data-toggle="tab">All</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-page">
                                <div class="tab-content" id="tab-content">
                                    <div class="tab-pane fade in active page-wrap-tab" id="all">
                                        <div class="text-center mrg-tp-20 mrg-lt-20"><p><i
                                                    class="fa fa-spinner fa-spin pink"></i> Loading...</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!-- remove list -->
    <div class="modal fade" id="del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10">
                <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
            </p>

            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span></button>
                    <h2 class="text-center">Delete conversation</h2>
                </div>
                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete this conversation?</p>

                    <p>&nbsp;</p>

                    <p>
                        <button class="btn btn-primary">Yes</button>
                        <button class="btn btn-primary" data-dismiss="modal">cancel</button>
                    </p>
                </div>
            </div>
            <!-- Modal Footer -->
        </div>
    </div>
    <!-- send mail -->
    <div class="modal fade" id="sendMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10">
                <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
            </p>
            <?php Pjax::begin(['id' => 'my_index7', 'enablePushState' => false]); ?>
            <div class="send_message">
                <div class="modal-content ">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> <span
                                class="sr-only">Close</span></button>
                        <h2 class="text-center">Please Wait</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mrg-tp-20">
                                <i class="fa fa-spinner fa-spin pink"></i> Loading Information...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
    <script src="<?= Yii::$app->homeUrl ?>js/jquery.js" type="text/javascript"></script>
    <script src="<?= Yii::$app->homeUrl ?>js/selectFx.js"></script>
<?php
$this->registerJs('
    $(function() {
    var newHash      = "",
        $mainContent = $(".tab-content"),
        $pageWrap    = $(".page-wrap-tab"),
        baseHeight   = 0,
        $el;
    $pageWrap.height($pageWrap.height());
    baseHeight = $pageWrap.height() - $mainContent.height();
    $(".nav-tabs-menu").delegate("a", "click", function() {
        window.location.hash = $(this).attr("href");
        return false;
    });
    $(window).bind("hashchange", function(e){
        newHash = window.location.hash.substring(1);
        if(newHash==""){
        newHash = "all";
        }
        if (newHash) {
            $mainContent
                .find(".page-wrap-tab")
                .fadeOut(1, function() {
                 $mainContent.html(loaderTab());
                    var sentboxurl = newHash+"?Type=Sentbox";
                    $mainContent.show().load(sentboxurl + " .page-wrap-tab", function(response, status, xhr) {
                    if ( status == "error" ) {
                        var msgSt = "' . Yii::$app->params['pageError'] . ' "+ xhr.status + " " + xhr.statusText;
                        $mainContent.html( pageError("E",msgSt));
                    }
                    $mainContent.fadeIn(1, function() {
                            $pageWrap.animate({
                               // height: baseHeight + $mainContent.height() + "px"
                            });
                        });
                        $(".nav-tabs li").removeClass("active");
                        $(".nav-tabs li."+newHash).addClass("active");
                    });
                });
        };

    });
    $(window).trigger("hashchange");

});
  ');
?>