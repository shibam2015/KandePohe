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
                        <?php require_once __DIR__ . '/_sidebar.php'; ?>
                        <div class="col-sm-9 col-md-10">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="pull-right">
                                        <p class="text-muted"><?= CommonHelper::DateTime($model->date_send_request, 26); ?>
                                            <a href="#" data-toggle="modal" data-target="#del"><i class="fa fa-trash"
                                                                                                  aria-hidden="true"></i></a>
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="inbox-thread">
                                        <div class="box-inbox pull-left">
                                            <?= Html::img(CommonHelper::getPhotos('USER', $model->fromUserInfo->id, $model->fromUserInfo->propic, 75), ['width' => '60', 'height' => '60', 'alt' => 'Profile', 'class' => '']); ?>
                                        </div>
                                        <div class="box-inbox3 conv pull-right">
                                            <p class="name">
                                                <a href="<?= CommonHelper::getUserUrl($model->fromUserInfo->Registration_Number); ?>">
                                                    <strong><?= $model->fromUserInfo->fullName; ?></strong>
                                                </a>
                                                (Last online
                                                : <?= CommonHelper::DateTime($model->fromUserInfo->LastLoginTime, 7); ?>
                                                )</p>
                                            <ul class="list-inline pull-left">
                                                <li><?= CommonHelper::getAge($model->fromUserInfo->DOB); ?> YRS
                                                    <?= ($model->fromUserInfo->height->vName != '') ? "," . $model->fromUserInfo->height->vName : ''; ?></li>
                                                <li>
                                                    <strong>Religion:</strong> <?= $model->fromUserInfo->religionName->vName; ?>
                                                    , Caste : <?= $model->fromUserInfo->communityName->vName; ?>
                                                </li>
                                                <li>
                                                    <strong>Location:</strong> <?= $model->fromUserInfo->cityName->vCityName; ?>
                                                    <?= ($model->fromUserInfo->stateName->vStateName != '') ? "," . $model->fromUserInfo->stateName->vStateName : ''; ?>
                                                    <?= ($model->fromUserInfo->countryName->vCountryName != '') ? "," . $model->fromUserInfo->countryName->vCountryName : ''; ?>
                                                </li>
                                                <li>
                                                    <strong>Education:</strong> <?= $model->fromUserInfo->educationLevelName->vEducationLevelName; ?>
                                                </li>
                                                <li>
                                                    <strong>Occupation:</strong> <?= $model->fromUserInfo->educationFieldName->vEducationFieldName; ?>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>

                                        </div>
                                        <div class="clearfix"></div>


                                        <div class="gray-tabs-block padd-10 mrg-tp-10 mrg-bt-5">
                                            <?php if ($MailArray[$model->id]['MsgCount'] == 1 || $model->send_request_status == 'Yes') { ?>
                                                <p><?= $MailArray[$model->id]['LastMsg'] ?></p>
                                                <div class="desc-mail">
                                                    <!--<p><strong><em>Member Message</em></strong></p>
                                                    <p><em>Hello, we have gone through ur profile, suitable to our daughter. If you are interested pls call us on 9218392199.</em></p>-->
                                                </div>
                                                <div class="pull-right">
                                                    <span>Would you like to communicate further</span>
                                                    <button class="btn btn-info">Yes</button>
                                                    <button class="btn btn-secondary">No</button>
                                                </div>

                                            <?php } else { ?>
                                                <p><?= $MailConversation[0]->MailContent ?></p>
                                                <div class="desc-mail">
                                                    <!--<p><strong><em>Member Message</em></strong></p>
                                                    <p><em>Hello, we have gone through ur profile, suitable to our daughter. If you are interested pls call us on 9218392199.</em></p>-->
                                                    <button class="btn btn-primary sendmail" data-target="#sendMail"
                                                            data-id="<?= $model->fromUserInfo->id ?>"
                                                            data-toggle="modal">Send Mail
                                                    </button>
                                                </div>
                                            <?php } ?>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div></div>
                                    </div>
                                </li>
                            </ul>

                            <div>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3><strong>Other conversation with member
                                                (<?= $MailArray[$model->id]['MsgCount'] ?>)</strong></h3></div>
                                    <div class="panel-body">
                                        <table class="table table-condensed">
                                            <tbody>
                                            <?php
                                            foreach ($MailConversation as $MKey => $MValue) { ?>
                                                <tr data-toggle="collapse" data-target="#demo<?= $MKey ?>"
                                                    class="accordion-toggle">
                                                    <td>
                                                        <button class="btn btn-default btn-xs"><span
                                                                class="glyphicon glyphicon-eye-open"></span></button>
                                                    </td>
                                                    <td><?= $MValue->from_reg_no ?></td>
                                                    <td>
                                                        <?= str_replace("#NAME#", $model->fromUserInfo->fullName, CommonHelper::truncate($MValue->MailContent, 100)) ?></td>
                                                    <td><?= CommonHelper::DateTime($MValue->dtadded, 27); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12" class="hiddenRow">
                                                        <div class="accordian-body collapse" id="demo<?= $MKey ?>">
                                                            <?= str_replace("#NAME#", $model->fromUserInfo->fullName, $MValue->MailContent) ?>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>


                        </div>
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