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
<div class="main-section">
        <?= $this->render('/layouts/parts/_headerafterlogin'); ?>
    <main data-ng-app="main-App">
            <section class="inbox">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3 col-md-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"> Mail
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Mail</a></li>
                                    <li><a href="#">Contacts</a></li>
                                    <li><a href="#">Tasks</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <?php
                        require_once __DIR__ . '/_sidebar.php'; ?>
                        <div class="col-sm-9 col-md-10">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active nav-tabs-menu all"><a href="#all" data-toggle="tab">All</a></li>
                                <li class="nav-tabs-menu new"><a href="#new" data-toggle="tab">New</a></li>
                                <li><a href="#read" data-toggle="tab"> Read &amp; Not Replied</a></li>
                                <li><a href="#accepted" data-toggle="tab">Accepted</a></li>
                                <li><a href="#replied" data-toggle="tab">Replied</a></li>
                                <li><a href="#notinterested" data-toggle="tab">Not Interested</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-page">
                                <div class="tab-content" id="tab-content">
                                    <div class="tab-pane fade in active page-wrap-tab" id="all">
                                        <div class="text-center mrg-tp-20 mrg-lt-20" ng-show="showLoader">
                                            <p><i class="fa fa-spinner fa-spin pink"></i> Loading...</p>
                                        </div>
                                        <ng-view></ng-view>
                                    </div>

                                    <div class="tab-pane fade in" id="read">
                                        <div class="list-group">
                                            <div class="list-group-item">
                                                <div class="notice kp_info"><p>There are no conversations with this
                                                        label.</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in" id="accepted">
                                        <div class="list-group">
                                            <div class="list-group-item">
                                                <div class="notice kp_info"><p>There are no conversations with this
                                                        label.</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in" id="replied">
                                        <div class="list-group">
                                            <div class="list-group-item">
                                                <div class="notice kp_info"><p>There are no conversations with this
                                                        label.</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in" id="notinterested">
                                        <div class="list-group">
                                            <div class="list-group-item">
                                                <div class="notice kp_info"><p>There are no conversations with this
                                                        label.</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="<?= Yii::$app->homeUrl ?>js/jquery.js" type="text/javascript"></script>
    <script src="<?= Yii::$app->homeUrl ?>js/selectFx.js"></script>

<?= $this->registerJsFile('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js', ['depends' => [\frontend\assets\AppAsset::className()], 'position' => \yii\web\View::POS_END]); ?>
<?= $this->registerJsFile(Yii::$app->request->baseUrl . '/js/angular/packages/dirPagination.js', ['depends' => [\frontend\assets\AppAsset::className()], 'position' => \yii\web\View::POS_END]); ?>
<?= $this->registerJsFile(Yii::$app->request->baseUrl . '/js/angular/routes.js', ['depends' => [\frontend\assets\AppAsset::className()], 'position' => \yii\web\View::POS_END]); ?>
<?= $this->registerJsFile(Yii::$app->request->baseUrl . '/js/angular/services/myServices.js', ['depends' => [\frontend\assets\AppAsset::className()], 'position' => \yii\web\View::POS_END]); ?>
<?= $this->registerJsFile(Yii::$app->request->baseUrl . '/js/angular/helper/myHelper.js', ['depends' => [\frontend\assets\AppAsset::className()], 'position' => \yii\web\View::POS_END]); ?>
<?= $this->registerJsFile(Yii::$app->request->baseUrl . '/js/angular/controller/ItemController.js', ['depends' => [\frontend\assets\AppAsset::className()], 'position' => \yii\web\View::POS_END]); ?>

