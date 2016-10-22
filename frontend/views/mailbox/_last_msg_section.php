<div></div>

<div></div>
<?php if ($MailArray[$model->id]['MsgCount'] == 1 || $model->send_request_status == 'Yes') { ?>
    <p><?= $MailArray[$model->id]['LastMsg'] ?></p>
    <div class="desc-mail">
        <!--<p><strong><em>Member Message</em></strong></p>
        <p><em>Hello, we have gone through ur profile, suitable to our daughter. If you are interested pls call us on 9218392199.</em></p>-->
    </div>
    <div class="text-right">
        <span>Would you like to communicate further</span>
        <button class="btn btn-info request_response"
                data-target="#request_response"
                data-id="<?= $model->fromUserInfo->id ?>" data-name="Yes"
                data-toggle="modal">Yes
        </button>
        <button class="btn btn-secondary request_response" data-target="#request_response"
                data-id="<?= $model->fromUserInfo->id ?>" data-name="No"
                data-toggle="modal">No
        </button>
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


