<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

$ModelUser = $model['modelUser'];
$model = $model['model'];
$Id = Yii::$app->user->identity->id;

//count($ModelUser) == 0 ||
if (($Id == $ModelUser->from_user_id && $ModelUser->send_request_status_from_to == 'No' && $ModelUser->send_request_status_to_from != 'Yes') || ($Id == $ModelUser->to_user_id && $ModelUser->send_request_status_to_from == 'No' && $ModelUser->send_request_status_from_to == 'No')) { ?>
    <div class="profile-control requests">
        <button type="button" class="btn active sendInterest" data-target="#sendInterest"
                data-toggle="modal"> Send Interest <i class="fa fa-heart-o"></i>
        </button>
        <!--<button type="button" class="btn active sendInterest send_request1"> Send Interest <i class="fa fa-heart-o"></i> </button>-->
        <button type="button" class="btn"> Shortlist <i class="fa fa-list-ul"></i></button>
        <button type="button" class="btn"> Block <i class="fa fa-ban"></i></button>
        <!--<button type="button" class="btn"> No <i class="fa fa-thumbs-o-down"></i></button>-->
    </div>
<?php } else if (($Id == $ModelUser->from_user_id && $ModelUser->send_request_status_from_to == 'Yes' && $ModelUser->send_request_status_to_from != 'Yes') || ($Id == $ModelUser->to_user_id && $ModelUser->send_request_status_to_from == 'Yes' && $ModelUser->send_request_status_from_to != 'Yes')) {
    ?>
    <div class="name-panel">
        <p>Waiting for a response? Send <?= ($model->Gender != 'MALE') ? 'her' : 'his'; ?> a Reminder...</p>
    </div>
    <div class="profile-control requests">
        <button type="button" class="btn active"> Send Reminder</button>
        <button type="button" class="btn"> cancel Invitation</button>
    </div>
<?php } else if (($Id == $ModelUser->to_user_id && $ModelUser->send_request_status_from_to == 'Yes' && $ModelUser->send_request_status_to_from != 'Yes') || ($Id == $ModelUser->from_user_id && $ModelUser->send_request_status_to_from == 'Yes' && $ModelUser->send_request_status_from_to != 'Yes')) {
    ?>
    <div class="name-panel">
        <p><?= ($model->Gender != 'MALE') ? 'He' : 'She'; ?>  has invited you to Connect! Respond Now.. </p>
    </div>
    <div class="profile-control requests">
        <button type="button" class="btn active"> Accept</button>
        <button type="button" class="btn"> Decline</button>
        <button type="button" class="btn"> Block <i class="fa fa-ban"></i></button>
    </div>
<?php } else {
    echo " Loading Data....";
    #if ($ModelUser->from_user_id == $model->id && $ModelUser->send_request_status == 'Yes') {
    ?>
    <!--<div class="name-panel">
            <p>Waiting for a response? Send <? /*= ($model->Gender != 'MALE') ? 'her' : 'his'; */ ?> a Reminder...</p>
        </div>
        <div class="profile-control requests">
            <button type="button" class="btn active"> Send Reminder</button>
            <button type="button" class="btn"> cancel Invitation</button>
        </div>-->
    <?php
    #} else if ($ModelUser->to_user_id == $model->id && $ModelUser->send_request_status == 'Yes') { ?>
    <!--<div class="name-panel">
            <p><? /*= ($model->Gender != 'MALE') ? 'He' : 'She'; */ ?>  has invited you to Connect! Respond Now.. </p>
        </div>
        <div class="profile-control requests">
            <button type="button" class="btn active"> Accept</button>
            <button type="button" class="btn"> Decline</button>
            <button type="button" class="btn"> Block <i class="fa fa-ban"></i></button>
        </div>-->

    <?php
    #}

} ?>
<?php
if (count($temp)) {
    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification($temp['STATUS'], 'SEND_INTEREST');
    $this->registerJs('
    $( document ).ready(function() {
            console.log( "ready!" );
              notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
        });
         ');
}
?>