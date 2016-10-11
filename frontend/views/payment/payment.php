<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\helpers\ArrayHelper;

?>
<div class="main-section">
    <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
    <main>
        <div class="container">
            <div class="padd-xs  mrg-tp-10">
            </div>
            <div class="white-section border-sharp">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="name-panel">
                            <div class="ad-title"><h3>Upgrade Your Profile</h3></div>
                            <div class="clearfix"></div>
                            <div class="ad-title"><h1> Plans are coming soon... </h1></div>


                            <ul class="list-inline pull-right">
                                <li><a href="<?= Yii::$app->homeUrl ?>user/my-profile"><i
                                            class="fa fa-angle-left"></i> My Profile </a></li>
                                <li><a href="<?= Yii::$app->homeUrl ?>user/dashboard">My Dashboard <i
                                            class="fa fa-angle-right"></i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </main>
</div>
