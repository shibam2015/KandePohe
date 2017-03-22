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

<div class="col-sm-3 col-md-2" id="mailbox_sidebar">
    <!--<a href="javascript:void(0)"
       data-target="#compose_mail"
       data-toggle="modal" class="btn btn-danger btn-sm btn-block compose_mail" role="button">COMPOSE</a>-->
    <hr/>
    <ul class="nav nav-pills nav-stacked">
        <li  <?= ($MainMenu == '') ? 'class="active"' : ''; ?>>
            <a href="<?= CommonHelper::getMailBoxUrl() ?>">
                <!--<span class="badge pull-right"><? /*= $MailUnreadCount */ ?></span>-->
                Inbox
            </a>
        </li>
        <!--<li><a href="#">Starred</a></li>
        <li><a href="#">Important</a></li>-->
        <li  <?= ($MainMenu == 'SentBox') ? 'class="active"' : ''; ?>><a
                href="<?= CommonHelper::getMailBoxUrl(2, '') ?>">Sent Mail</a></li>
        <!--<li><a href="#"><span class="badge pull-right">3</span>Drafts</a></li>-->
    </ul>
</div>

<!-- send mail -->
<div class="modal fade" id="sendMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>
        <?php Pjax::begin(['id' => 'send_message', 'enablePushState' => false]); ?>
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
                            <i class="fa fa-spinner fa-spin pink"></i> Loading Information...
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>

    <!-- Compose mail -->
    <div class="modal fade" id="compose_mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10">
                <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
            </p>
            <?php Pjax::begin(['id' => 'new_mail_compose', 'enablePushState' => false]); ?>
            <div class="new_mail_compose">
                <div class="modal-content ">
                    <!--<div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> <span
                                class="sr-only">Close</span></button>
                        <h2 class="text-center">New Mail</h2>
                    </div>-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mrg-tp-20">
                                <i class="fa fa-spinner fa-spin pink"></i> Loading Information...
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>



<?php
$this->registerJs('
$(document).on("click",".compose_mail",function(e){
       getInlineDetail("' . Url::to(['mailbox/new-mail-compose']) . '","#new_mail_compose","0");
    });

  ');

?>