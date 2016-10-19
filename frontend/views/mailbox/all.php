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
    <?php if (count($model)) {
        foreach ($model as $Key => $Value) {
            ?>
            <ul class="list-group" id="list_all_<?= $Value->fromUserInfo->id ?>">
                <li class="list-group-item">
                    <div class="thread-control">
                        <p class="text-muted"><?= CommonHelper::DateTime($Value->date_send_request, 26); ?>
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
                            <?= Html::img(CommonHelper::getPhotos('USER', $Value->fromUserInfo->id, $Value->fromUserInfo->propic, 140), ['width' => '80', 'height' => '80', 'alt' => 'Profile', 'class' => '']); ?>
                        </div>
                        <div class="box-inbox3 pull-right">
                            <p class="name">
                                <a href="<?= CommonHelper::getUserUrl($Value->fromUserInfo->Registration_Number); ?>">
                                    <strong><?= $Value->fromUserInfo->fullName; ?></strong>
                                </a>
                                (Last online
                                : <?= CommonHelper::DateTime($Value->fromUserInfo->LastLoginTime, 7); ?>
                                )</p>
                            <ul class="list-inline pull-left">
                                <li><?= CommonHelper::getAge($Value->fromUserInfo->DOB); ?>
                                    YRS
                                    <?= ($Value->fromUserInfo->height->vName != '') ? "," . $Value->fromUserInfo->height->vName : ''; ?></li>
                                <li>
                                    <strong>Religion:</strong> <?= $Value->fromUserInfo->religionName->vName; ?>
                                    , Caste
                                    : <?= $Value->fromUserInfo->communityName->vName; ?>
                                </li>
                                <li>
                                    <strong>Location:</strong> <?= $Value->fromUserInfo->cityName->vCityName; ?>
                                    <?= ($Value->fromUserInfo->stateName->vStateName != '') ? "," . $Value->fromUserInfo->stateName->vStateName : ''; ?>
                                    <?= ($Value->fromUserInfo->countryName->vCountryName != '') ? "," . $Value->fromUserInfo->countryName->vCountryName : ''; ?>
                                </li>
                                <li>
                                    <strong>Education:</strong> <?= $Value->fromUserInfo->educationLevelName->vEducationLevelName; ?>
                                </li>
                                <li>
                                    <strong>Occupation:</strong> <?= $Value->fromUserInfo->educationFieldName->vEducationFieldName; ?>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                            <hr>
                            <p class="mrg-bt-20">
                                <?= $MailArray[$Value->id]['LastMsg'] ?>
                            </p>

                            <button class="btn btn-primary sendmail" data-target="#sendMail"
                                    data-id="<?= $Value->fromUserInfo->id ?>"
                                    data-toggle="modal">Send Mail
                            </button>

                            <a href="<?= CommonHelper::getMailBoxUrl($Value->fromUserInfo->Registration_Number, 1) ?>"
                               class="btn btn-info pull-right">
                                <?= ($MailArray[$Value->id]['MsgCount'] == 1) ? 'View conversation' : '+' . $MailArray[$Value->id]['MsgCount'] . ' more conversation'; ?>
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
