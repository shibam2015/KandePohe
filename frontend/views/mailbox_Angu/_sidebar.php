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
    <a href="#" class="btn btn-danger btn-sm btn-block" role="button">COMPOSE</a>
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
                href="<?= CommonHelper::getMailBoxUrl('', 2) ?>">Sent Mail</a></li>
        <!--<li><a href="#"><span class="badge pull-right">3</span>Drafts</a></li>-->
    </ul>
</div>
