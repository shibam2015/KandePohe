<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

/*$modelInbox = $model['modelInbox'];
$ToUserId = $model['ToUserId'];
$model = $model['model'];*/
?>
<div class="tab-pane fade in active page-wrap-tab" id="all">
    <?php if (count($ModelBox)) {
        foreach ($OtherInformationArray as $Key => $Value) {
            $ModelInfo = $Value['ModelInfo'];
            $FId = $Value['ModelInfo']->id;
            ?>
            <ul class="list-group" id="list_all_">
                <li class="list-group-item <?= ($Value['LastMailReadStatus'] == 'No') ? 'kp_ur1' : ''; ?>">
                    <div class="thread-control">
                        <p class="text-muted">
                            <?= CommonHelper::DateTime($Value['LastMailDate'], 26); ?>
                            <a href="#" data-toggle="modal"
                               data-target="#del"><i
                                    class="fa fa-trash" aria-hidden="true"></i></a></p>
                    </div>
                    <div class="inbox-thread">
                        <div class="box-inbox pull-left">
                            <div class="checkbox mrg-tp-0">
                                <input id="chk" type="checkbox" name="chk"
                                       value="check1">
                                <label for="chk" class="control-label"></label>
                            </div>
                        </div>
                        <div class="box-inbox pull-left">
                            <?= Html::img(CommonHelper::getPhotos('USER', $FId, "75" . $ModelInfo->propic, 75, '', 'Yes', CommonHelper::getVisiblePhoto($FId, $ModelInfo->eStatusPhotoModify)), ['width' => '65', 'height' => '', 'alt' => 'Profile Pic', 'class' => '']); ?>
                        </div>
                        <div class="box-inbox3 pull-right">
                            <p class="name">
                                <a href="<?= CommonHelper::getUserUrl($ModelInfo->Registration_Number); ?>">
                                    <strong><?= $ModelInfo->fullName; ?></strong>
                                </a>
                                (Last online
                                : <?= CommonHelper::DateTime($ModelInfo->LastLoginTime, 7); ?>
                                )</p>
                            <ul class="list-inline pull-left">
                                <li><?= CommonHelper::getAge($ModelInfo->DOB); ?>
                                    YRS
                                    <?= ($ModelInfo->height->vName != '') ? "," . $ModelInfo->height->vName : ''; ?></li>
                                <li>
                                    <strong>Religion:</strong> <?= $ModelInfo->religionName->vName; ?>
                                    , Caste
                                    : <?= $ModelInfo->communityName->vName; ?>
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
                            <hr>
                            <!--<p class="mrg-bt-20">
                                <? /*= $MailArray[$Value->id]['LastMsg'] */ ?>
                            </p>
                            <?php /*if ($MailArray[$Value->id]['MsgCount'] > 1 || $Model->send_request_status == 'Yes') { */ ?>
                            <button class="btn btn-primary sendmail" data-target="#sendMail"
                                    data-id="<? /*= $ModelInfo->id */ ?>"
                                    data-toggle="modal">Send Mail
                            </button>
                            --><?php /*} */ ?>
                            <a href="<?= CommonHelper::getMailBoxUrl(1, $ModelInfo->Registration_Number) ?>"
                               class="btn btn-info pull-right">
                                <?= ($Value['MailTotalCount'] == 1) ? 'View conversation' : '+' . $Value['MailTotalCount'] . ' more conversation'; ?>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div></div>
                    </div>
                </li>

            </ul>
        <?php }
    } else { ?>
        <div class="list-group">
            <div class="list-group-item">
                <div class="notice kp_info"><p>There are no conversations with this
                        label.</p></div>
            </div>
        </div>
    <?php } ?>
</div>
