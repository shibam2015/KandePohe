<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
#use frontend\components\CommonHelper;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

?>


<main>
    <div class="container-fluid">
        <div class="row no-gutter bg-dark">
            <div class="col-md-9 col-sm-12 col-md-offset-2">
                <div class="right-column">
                    <div class="row no-gutter">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="white-section mrg-tp-20 mrg-bt-10">
                                <h3><?= $SiteCMSModel->title ?></h3>

                                <div class="box">
                                    <?= (html_entity_decode($SiteCMSModel->description)) ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <aside>
                                <div class="aside-header text-center">
                                    <h3><span class="font-light">Try Our</span><br>
                                        Premium Membership</h3>
                                    <?= Html::img('@web/images/member.png', ['width' => '80', 'height' => 45, 'alt' => 'MemberShip']); ?>
                                </div>

                                <div class="aside-content">
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="no">1</div>
                                            <div class="list-cont"><strong>Promote yourself to matches</strong> Drive
                                                responses via emails,
                                                chats, phones &amp; SMS
                                            </div>
                                        </li>
                                        <li>
                                            <div class="no">2</div>
                                            <div class="list-cont"><strong>Get featured, get noticed!</strong> Standout
                                                even more with bold
                                                listing and spotlight
                                            </div>
                                        </li>
                                        <li>
                                            <div class="no">3</div>
                                            <div class="list-cont"><strong>View additional profile details</strong> view
                                                additional profile
                                                details and select better matches
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="aside-footer  mrg-bt-10">
                                    <input type="button" name="I want a Premium Plan" value="I want a Premium Plan"
                                           class="btn btn-primary mrg-tp-20">
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    p {
        margin: inherit !important;
    }
</style>