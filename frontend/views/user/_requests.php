<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

$ModelUser = $model['modelUser'];
$ToUserInfo = $model['ToUserInfo'];
$model = $model['model'];
$Id = Yii::$app->user->identity->id;
?>

<?php

if (($Id == $ModelUser->from_user_id && $ModelUser->send_request_status_from_to == 'No' && $ModelUser->send_request_status_to_from == 'No') || ($Id == $ModelUser->to_user_id && $ModelUser->send_request_status_to_from == 'No' && $ModelUser->send_request_status_from_to == 'No')) { ?>
    <div class="profile-control requests">
        <button type="button" class="btn active sendInterest" data-target="#sendInterest"
                data-toggle="modal"> Send Interest <i class="fa fa-heart-o"></i>
        </button>
        <!--<button type="button" class="btn active sendInterest send_request1"> Send Interest <i class="fa fa-heart-o"></i> </button>-->
        <button type="button"
                class="btn active <?php if ($ModelUser->short_list_status_from_to == 'No') { ?>shortlistUser<?php } ?>"
                data-name="<?= $ToUserInfo->fullName ?>">
            Shortlist<?php if ($ModelUser->short_list_status_from_to != 'No') { ?>ed <?php } ?> <i
                class="fa fa-list-ul"></i></button>
        <button type="button" class="btn active "> Block <i class="fa fa-ban"></i></button>
        <!--<button type="button" class="btn"> No <i class="fa fa-thumbs-o-down"></i></button>-->
    </div>
    <?php if ($ModelUser->short_list_status_from_to != 'No') { ?>
        <div class="name-panel inblock-msg mrg-tp-20">
            <p> You have added this member to Shortlist. <a>View More</a>.</p>
        </div>
    <?php } ?>
<?php } else if (($Id == $ModelUser->from_user_id && $ModelUser->send_request_status_from_to == 'Yes' && $ModelUser->send_request_status_to_from != 'Yes') || ($Id == $ModelUser->to_user_id && $ModelUser->send_request_status_to_from == 'Yes' && $ModelUser->send_request_status_from_to != 'Yes')) {
    ?>
    <div class="name-panel inblock-msg mrg-tp-20">
        <p>Waiting for a response? Send <?= ($model->Gender == 'MALE') ? 'her' : 'his'; ?> a Reminder...</p>
    </div>
    <div class="profile-control requests">
        <button type="button" class="btn active"> Send Reminder</button>
        <button type="button" class="btn active accept_decline" data-target="#accept_decline" data-toggle="modal"
                data-id="<?= $ToUserInfo->id ?>"
                data-name="<?= $ToUserInfo->fullName ?>"
                data-rgnumber="<?= $ToUserInfo->Registration_Number ?>" data-type="Cancel Interest"> Cancel Invitation
        </button>
    </div>
<?php } else if (($Id == $ModelUser->to_user_id && $ModelUser->send_request_status_from_to == 'Yes' && $ModelUser->send_request_status_to_from != 'Yes') || ($Id == $ModelUser->from_user_id && $ModelUser->send_request_status_to_from == 'Yes' && $ModelUser->send_request_status_from_to != 'Yes')) {
    ?>
    <div class="name-panel">
        <p><?= ($model->Gender != 'MALE') ? 'He' : 'She'; ?>  has invited you to Connect! Respond Now.. </p>
    </div>
    <div class="profile-control requests">
        <button type="button" class="btn active accept_decline" data-target="#accept_decline" data-toggle="modal"
                data-id="<?= $ToUserInfo->id ?>"
                data-name="<?= $ToUserInfo->fullName ?>"
                data-rgnumber="<?= $ToUserInfo->Registration_Number ?>" data-type="Accept Interest"> Accept
        </button>
        <button type="button" class="btn active accept_decline" data-target="#accept_decline" data-toggle="modal"
                data-id="<?= $ToUserInfo->id ?>"
                data-name="<?= $ToUserInfo->fullName ?>"
                data-rgnumber="<?= $ToUserInfo->Registration_Number ?>" data-type="Decline Interest"> Decline
        </button>
        <button type="button" class="btn active"> Block <i class="fa fa-ban"></i></button>
    </div>
<?php } else if ($ModelUser->send_request_status_from_to == 'Accepted' || $ModelUser->send_request_status_to_from == 'Accepted') {
    ?>
    <a href="javascript:void(0)" class="btn active" role="button"
       data-target="#" data-toggle="modal" data-id="<?= $ToUserInfo->id ?>"
       data-name="<?= $ToUserInfo->fullName ?>"
       data-rgnumber="<?= $ToUserInfo->Registration_Number ?>" data-type="Connected">Connected
        <i class="fa fa-heart"></i> </a>
    <?php
} else if ($ModelUser->send_request_status_from_to == 'Rejected' || $ModelUser->send_request_status_to_from == 'Rejected') {
    ?>
    <a href="javascript:void(0)" class="btn active" role="button"
       data-target="#" data-toggle="modal" data-id="<?= $ToUserInfo->id ?>"
       data-name="<?= $ToUserInfo->fullName ?>"
       data-rgnumber="<?= $ToUserInfo->Registration_Number ?>" data-type="Rejected">Rejected
        <i class="fa fa-close"></i> </a>
    <?php
} ?>
<?php
if (count($temp)) {
    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification($temp['STATUS'], $temp['Action']);
    $this->registerJs('
    $( document ).ready(function() {
              notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
        });
    ');
}
?>