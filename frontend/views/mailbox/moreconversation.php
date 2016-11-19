<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\widgets\Pjax;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

#echo "==> ".count($Model) ."====> ".count($HandleArray);exit;
#CommonHelper::pr($Type);
?>
    <div class="main-section">
        <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
        <main>
            <section class="inbox">
                <div class="container">
                    <div class="row">
                        <?php require_once __DIR__ . '/_sidebar.php'; ?>
                        <?php if (count($Model) && count($HandleArray) == 0) {
                            if ($Model->from_user_id == $Id) {
                                $ModelInfo = $Model->toUserInfo;
                            } else {
                                $ModelInfo = $Model->fromUserInfo;
                            }
                            ?>
                            <div class="col-sm-9 col-md-10">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="pull-right">
                                        <p class="text-muted">
                                            <?php /*if ($Model->send_request_status_from_to == 'Yes') { */ ?><!--
                                                <? /*= CommonHelper::DateTime($Model->date_send_request_from_to, 26); */ ?>
                                            <?php /*} else { */ ?>
                                                <? /*= CommonHelper::DateTime($Model->date_send_request_to_from, 26); */ ?>
                                            --><?php /*} */ ?>
                                            <?= CommonHelper::DateTime($OtherInformationArray[0]['LastMailDate'], 26); ?>
                                            <a href="#" data-toggle="modal" data-target="#del"><i class="fa fa-trash"
                                                                                                  aria-hidden="true"></i></a>
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="inbox-thread">
                                        <div class="box-inbox pull-left">
                                            <?= Html::img(CommonHelper::getPhotos('USER', $ModelInfo->id, $ModelInfo->propic, 75), ['width' => '60', 'height' => '60', 'alt' => 'Profile', 'class' => '']); ?>
                                        </div>
                                        <div class="box-inbox3 conv pull-right">
                                            <p class="name">
                                                <a href="<?= CommonHelper::getUserUrl($ModelInfo->Registration_Number); ?>">
                                                    <strong><?= $ModelInfo->fullName; ?></strong>
                                                </a>
                                                (Last online
                                                : <?= CommonHelper::DateTime($ModelInfo->LastLoginTime, 7); ?>
                                                )</p>
                                            <ul class="list-inline pull-left">
                                                <li><?= CommonHelper::getAge($ModelInfo->DOB); ?> YRS
                                                    <?= ($ModelInfo->height->vName != '') ? "," . $ModelInfo->height->vName : ''; ?></li>
                                                <li>
                                                    <strong>Religion:</strong> <?= $ModelInfo->religionName->vName; ?>
                                                    , Caste : <?= $ModelInfo->communityName->vName; ?>
                                                </li>
                                                <li>
                                                    <strong>Location:</strong> <?= $ModelInfo->cityName->vCityName; ?>
                                                    <?= ($ModelInfo->stateName->vStateName != '') ? "," . $ModelInfo->stateName->vStateName : ''; ?>
                                                    <?= ($ModelInfo->countryName->vCountryName != '') ? "," . $ModelInfo->countryName->vCountryName : ''; ?>
                                                </li>
                                                <li>
                                                    <strong>Education:</strong> <?= $ModelInfo->educationLevelName->vEducationLevelName; ?>
                                                </li>
                                                <li>
                                                    <strong>Occupation:</strong> <?= $ModelInfo->educationFieldName->vEducationFieldName; ?>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php ?>
                                        <?php Pjax::begin(['id' => 'my_last', 'enablePushState' => false]); ?>
                                        <div></div>
                                        <div class="gray-tabs-block padd-10 mrg-tp-10 mrg-bt-5"
                                             id="last_message_section">
                                            <i class="fa fa-spinner fa-spin pink"></i> Loading...
                                            <div class="clearfix"></div>
                                        </div>
                                        <?php Pjax::end(); ?>
                                        <div></div>
                                    </div>
                                </li>
                            </ul>
                            <div>
                                <?php Pjax::begin(['id' => 'my_covo', 'enablePushState' => false]); ?>
                                <div class="panel panel-default" id="other_convo">
                                    <div class="panel-heading">
                                        <h3>
                                            <strong>Other conversation with member </strong>
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="conversations">
                                            <i class="fa fa-spinner fa-spin pink"></i> Loading Conversation...
                                        </div>
                                    </div>
                                </div>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                        <?php } else { ?>
                            <div class="col-sm-9 col-md-10">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="pull-right">

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="inbox-thread mrg-tp-30">

                                            <div class="box-inbox3 conv mrg-bt-30 mrg-tp-30">
                                                <div class="list-group"></div>
                                                <div class="list-group mrg-tp-30">
                                                    <div></div>
                                                    <div class="list-group-item">
                                                        <div></div>
                                                        <div class="notice kp_warning ">
                                                            <p><?= Yii::$app->params['moreConversationErrorMessage']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <!--<div></div>-->
                                        </div>
                                    </li>
                                </ul>

                                <div>

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        </main>
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
<?php /*if ($MailArray[$Model->id]['MsgCount'] == 1 || $Model->send_request_status == 'Yes') { */ ?><!--
    <div class="modal fade" id="request_response" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10">
                <img src="<? /*= CommonHelper::getLogo() */ ?>" width="157" height="61" alt="logo">
            </p>

            <div class="send_message">
                <div class="modal-content ">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> <span
                                class="sr-only">Close</span></button>
                        <h2 class="text-center"><? /*= Yii::$app->params['modalTitle'] */ ?></h2>
                    </div>
                    <div class="modal-body text-center">
                        <div class="row">
                            <div class="col-md-12 mrg-tp-10 mrg-bt-10">
                                <p><strong id="requestBody"> </strong></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <a href="javascript:void(0)"
                                   class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right accept_decline">
                                    Yes </a>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 ">
                                <a href="javascript:void(0)"
                                   class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left"
                                   data-dismiss="modal"> Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
--><?php /*} */ ?>

    <script src="<?= Yii::$app->homeUrl ?>js/jquery.js" type="text/javascript"></script>
    <script src="<?= Yii::$app->homeUrl ?>js/selectFx.js"></script>
<?php
//  CommonHelper::pr($Model);

if (count($Model) && count($HandleArray) == 0) {
    $this->registerJs('
$(document).on("click",".sendmail",function(e){
      var formData = new FormData();
      formData.append("ToUserId", $(this).data("id"));
      sendRequest("' . Url::to(['mailbox/inbox-send-message']) . '",".send_message",formData);;
    });
  ');
    $this->registerJs('
        var formDataRequest = new FormData();
        formDataRequest.append("uk", "' . $ModelInfo->Registration_Number . '");
        sendRequest("' . Url::to(['mailbox/last-msg']) . '","#last_message_section",formDataRequest);
        sendRequest("' . Url::to(['mailbox/more-coversation-all']) . '","#other_convo",formDataRequest);
    ');
}
?>
<?php
require_once dirname(__DIR__) . '/user/_useroperation.php';
?>