<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

#\common\components\CommonHelper::pr($model['modelUser']);
$ModelUser = $model['modelUser'];
$model = $model['model'];
#\common\components\CommonHelper::pr($ModelUser[0]->from_user_id);
#$STATUS = $MESSAGE = $TITLE = '';

?>
<?php
if (count($ModelUser) == 0) { ?>
    <div class="profile-control requests">
        <button type="button" class="btn active sendInterest" data-target="#sendInterest"
                data-toggle="modal"> Send Interest <i class="fa fa-heart-o"></i>
        </button>
        <button type="button" class="btn"> Shortlist <i class="fa fa-list-ul"></i>
        </button>
        <button type="button" class="btn"> Block <i class="fa fa-ban"></i></button>
        <!--<button type="button" class="btn"> No <i class="fa fa-thumbs-o-down"></i></button>-->
    </div>
<?php } else {
    /* Reques TIme */
    if ($ModelUser[0]->from_user_id == $model->id && $ModelUser[0]->send_request_status == 'Yes') {
        ?>
        <div class="name-panel">
            <p>Waiting for a response? Send <?= ($model->Gender != 'MALE') ? 'her' : 'his'; ?> a Reminder...</p>
        </div>
        <div class="profile-control requests">
            <button type="button" class="btn active"> Send Reminder</button>
            <button type="button" class="btn"> cancel Invitation</button>
        </div>
    <?php
    } else if ($ModelUser[0]->to_user_id == $model->id && $ModelUser[0]->send_request_status == 'Yes') { ?>
        <div class="name-panel">
            <p><?= ($model->Gender != 'MALE') ? 'He' : 'She'; ?>  has invited you to Connect! Respond Now.. </p>
        </div>
        <div class="profile-control requests">
            <button type="button" class="btn active"> Accept</button>
            <button type="button" class="btn"> Decline</button>
            <button type="button" class="btn"> Block <i class="fa fa-ban"></i></button>
        </div>

    <?php
    }
    if (count($temp)) {
        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'SEND_INTEREST');
        #echo " st => ".$STATUS." me ".$MESSAGE;
        $this->registerJs('
          (function() {
            alert("B");
            notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
          })();
         ');

    }

} ?>

<?php
/*$this->registerJs('
          (function() {

            alert("A");

          })();
         ');*/
?>