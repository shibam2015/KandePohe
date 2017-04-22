<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\helpers\ArrayHelper;

?>
<div class="main-section">
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
                                <li><?= html::a('<i class="fa fa-angle-left"></i> My Profile ', ['/my-profile']) ?></li>
                                <li><?= html::a('Dashboard <i class="fa fa-angle-right"></i></a>', ['/dashboard']) ?></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </main>
</div>
