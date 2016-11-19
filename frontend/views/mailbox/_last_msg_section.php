<?php
use yii\helpers\Url;

#\common\components\CommonHelper::pr($LastMail);
#\common\components\CommonHelper::pr($Id);
#\common\components\CommonHelper::pr($ToUserID);
#exit;
?>
<div></div>
<div></div>

<?php if ($Id == $LastMail->to_user_id) { ?>
    <p><strong><?= $MailArray->FullName ?></strong></p>
    <div class="desc-mail">
        <p><strong><em><?= $MailArray->LastMailContent ?></em></strong></p>
        <!--<p><em><? /*= $LastMail->MailContent*/ ?></em></p>-->
    </div>
    <div class="text-right">
        <?php if ($LastMail->msg_type == 'SendInterest') {
            $TextMsg = Yii::$app->params['sendInterestMessageInbox'];
        } ?>
        <span><?= $TextMsg ?></span>
        <?php if ($LastMail->msg_type == 'SendInterest') { ?>
            <button class="btn btn-info accept_decline request_response1"
                    role="button" data-target="#accept_decline"
                    data-toggle="modal"
                    data-id="<?= $FromUserId->id ?>"
                    data-name="<?= $FromUserId->fullName ?>"
                    data-rgnumber="<?= $FromUserId->Registration_Number ?>"
                    data-type="Accept Interest">Yes
        </button>
            <button class="btn btn-secondary accept_decline request_response1"
                    role="button" data-target="#accept_decline"
                    data-toggle="modal"
                    data-id="<?= $FromUserId->id ?>"
                    data-name="<?= $FromUserId->fullName ?>"
                    data-rgnumber="<?= $FromUserId->Registration_Number ?>"
                    data-type="Decline Interest">No
            </button>
        <?php } ?>
    </div>

<?php } elseif ($Id == $LastMail->from_user_id) { ?>
    <p><strong><?= $MailArray->FullName ?></strong></p>
    <div class="desc-mail">
        <p><strong><em><?= $MailArray->LastMailContent ?></em></strong></p>
    </div>
    <div class="text-right">
        <?php if ($LastMail->msg_type == 'SendInterest') {
            $TextMsg = Yii::$app->params['sendInterestMessageInbox'];
        } ?>
        <span><?= $TextMsg ?></span>
        <button class="btn btn-primary sendmail" data-target="#sendMail"
                data-id="<?= $LastMail->MailId ?>"
                data-toggle="modal">Send Mail
        </button>
    </div>
<?php } else { ?>
    <p><?= $LastMail->MailContent ?></p>
    <div class="desc-mail">
        <!--<p><strong><em>Member Message</em></strong></p>
        <p><em>Hello, we have gone through ur profile, suitable to our daughter. If you are interested pls call us on 9218392199.</em></p>-->
        <!--<button class="btn btn-primary sendmail" data-target="#sendMail"
                data-id="<? /*= $LastMail->MailId */ ?>"
                data-toggle="modal">Send Mail
        </button>-->
    </div>
<?php } ?>


<!--if ($LastMail->send_request_status == 'Yes') {-->
<?php if (0) {

} else {
    $this->registerJs('
     //var formDataRequest = new FormData();
        $(document).on("click",".sendmail",function(e){
          var formData = new FormData();
          formData.append("ToUserId", $(this).data("id"));
          //sendRequest("' . Url::to(['mailbox/inbox-send-message']) . '",".send_message",formData);;
        });
  ');
}
?>
<?php
if ($LastMail->msg_type == 'SendInterest') {
    $this->registerJs('
     $(document).on("click",".a_b_d",function(e){
      Pace.restart();
      loaderStart();
      var formData = new FormData();
      formData.append("ToUserId", $(this).data("id"));
      formData.append("Name", $(".to_name").text());
      formData.append("RGNumber", $(".to_rg_number").text());
      formData.append("Action",  $(this).data("type"));
      formData.append("uk", $(".to_rg_number").text());
      sendRequestDashboard("' . Url::to(['user/user-request']) . '",".requests","MAILBOX",$(this).data("parentid"),formData);
       //sendRequest("' . Url::to(['mailbox/last-msg']) . '","#last_message_section",formData);
    });
  ');
} ?>
