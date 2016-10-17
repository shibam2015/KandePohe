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
                <div class="row">
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
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
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
                </div>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-sm-3 col-md-2"><a href="#" class="btn btn-danger btn-sm btn-block" role="button">COMPOSE</a>
                        <hr/>
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="#"><span class="badge pull-right">42</span> Inbox </a></li>
                            <li><a href="#">Starred</a></li>
                            <li><a href="#">Important</a></li>
                            <li><a href="#">Sent Mail</a></li>
                            <li><a href="#"><span class="badge pull-right">3</span>Drafts</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-9 col-md-10">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">All</a></li>
                            <li><a href="#tab2" data-toggle="tab">New</a></li>
                            <li><a href="#tab3" data-toggle="tab"> Read &amp; Not Replied</a></li>
                            <li><a href="#tab4" data-toggle="tab">Accepted</a></li>
                            <li><a href="#tab5" data-toggle="tab">Replied</a></li>
                            <li><a href="#tab6" data-toggle="tab">Not Interested</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div class="tab-pane fade in active" id="tab1">
                                <?php if (count($model)) {
                                    foreach ($model as $Key => $Value) {
                                        ?>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="thread-control">
                                            <p class="text-muted"><?= CommonHelper::DateTime($Value->date_send_request, 1); ?>
                                                <a href="#" data-toggle="modal"
                                                                                 data-target="#del"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a></p>
                                        </div>
                                        <div class="inbox-thread">
                                            <div class="box-inbox pull-left">
                                                <div class="checkbox mrg-tp-0">
                                                    <input id="chk" type="checkbox" name="chk" value="check1">
                                                    <label for="chk" class="control-label"></label>
                                                </div>
                                            </div>
                                            <div class="box-inbox pull-left">
                                                <?= Html::img(CommonHelper::getPhotos('USER', $Value->fromUserInfo->id, $Value->fromUserInfo->propic, 140), ['width' => '80', 'height' => '80', 'alt' => 'Profile', 'class' => '']); ?>
                                            </div>
                                            <div class="box-inbox3 pull-right">
                                                <p class="name"><strong><?= $Value->fromUserInfo->fullName; ?></strong>
                                                </p>
                                                <ul class="list-inline pull-left">
                                                    <li><?= $Value->fromUserInfo->Age; ?> YRS
                                                        , <?= $Value->fromUserInfo->height->vName; ?></li>
                                                    <li>
                                                        <strong>Religion:</strong> <?= $Value->fromUserInfo->religionName->vName; ?>
                                                        , Caste : <?= $Value->fromUserInfo->communityName->vName; ?>
                                                    </li>
                                                    <li>
                                                        <strong>Location:</strong> <?= $Value->fromUserInfo->cityName->vCityName; ?>
                                                        , <?= $Value->fromUserInfo->stateName->vStateName; ?>
                                                        , <?= $Value->fromUserInfo->countryName->vCountryName; ?></li>
                                                    <li>
                                                        <strong>Education:</strong> <?= $Value->fromUserInfo->educationLevelName->vEducationLevelName; ?>
                                                    </li>
                                                    <li>
                                                        <strong>Occupation:</strong> <?= $Value->fromUserInfo->educationFieldName->vEducationFieldName; ?>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <!--<p class="mrg-bt-20"><a class="small-focus" href="#"><? /*= $Value->phone_number_viewed;*/
                                                ?></a> This member is interested in your profile and viewed
                                                    your phone number.</p>-->
                                                <button class="btn btn-primary sendmail" data-target="#sendMail"
                                                        data-id="<?= $Value->fromUserInfo->id ?>"
                                                        data-toggle="modal">Send Mail
                                                </button>
                                                <a href="more-conversation.html" class="btn btn-info pull-right">+3 more
                                                    conversation</a></div>
                                            <div class="clearfix"></div>
                                            <div></div>
                                        </div>
                                    </li>

                                </ul>
                                    <?php }
                                } else { ?>
                                    <div class="list-group">
                                        <div class="list-group-item"><span class="text-center">There are no conversations with this label.</span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="tab-pane fade in" id="tab2">
                                <div class="list-group">
                                    <div class="list-group-item"><span class="text-center">There are no conversations with this label.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="tab3"> There are no conversations with this label.</div>
                            <div class="tab-pane fade in" id="tab4"> There are no conversations with this label.</div>
                            <div class="tab-pane fade in" id="tab5"> There are no conversations with this label.</div>
                            <div class="tab-pane fade in" id="tab6"> There are no conversations with this label.</div>
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
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
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
                        Loading Information...
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
    $(".sendmail").click(function(e){
      var formData = new FormData();
      formData.append("ToUserId", $(this).data("id"));
      sendRequest("' . Url::to(['mailbox/inbox-send-message']) . '",".send_message",formData);;
    });
  ');
?>
