<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use common\components\MailHelper;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$HOME_PAGE_URL = Yii::getAlias('@web') . "/";
?>

    <div class="main-section">
        <main data-ng-app="privacyApp" data-ng-controller="privacyController">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-sm-12 col-md-offset-1">
                            <div class="row">
                                <div class="white-section">
                                    <h3><p class="mrg-bt-10"><i class="fa fa-lock text-danger"></i> Privacy Settings</p>
                                    </h3>
                                    <div class="two-column">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="nav nav-pills bg-white my-profile tab-width" role="tablist">
                                                    <li role="presentation" <?= ($tab == '') ? 'class="active"' : ''; ?> >
                                                        <a
                                                            href="#tab1" aria-controls="home"
                                                            role="tab" data-toggle="tab">Phone Number Privacy</a>
                                                    </li>
                                                    <li role="presentation" <?= ($tab == 'EP') ? 'class="active"' : ''; ?> >
                                                        <a
                                                            href="#tab2" aria-controls="profile" role="tab"
                                                            data-toggle="tab">Photo Privacy</a></li>
                                                    <li role="presentation"><a href="#tab3" aria-controls="profile"
                                                                               role="tab"
                                                                               data-toggle="tab"> Visitor Settings</a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content my-profile tab-width">
                                                    <div role="tabpanel"
                                                         class="tab-pane <?= ($tab == '') ? 'active' : ''; ?> "
                                                         id="tab1">
                                                        <div class="profile-edit pull-right">
                                                        </div>
                                                        <div class="inner-block ">
                                                            <div class="row">
                                                                <?php $form = ActiveForm::begin(); ?>
                                                                <div class="col-md-10 mrg-tp-20">
                                                                    <div class="mid-col ">
                                                                        <div class="form-cont">
                                                                            <div class="radio dl" id="IVA">
                                                                                <dd data-ng-init="phone_privacy=<?= $UserModel->phone_privacy ?>">
                                                                                    <?= $form->field($UserModel, 'phone_privacy')->RadioList(
                                                                                        Yii::$app->params['privacyPhone'],
                                                                                        [
                                                                                            'item' => function ($index, $label, $name, $checked, $value) {
                                                                                                $checked = ($label == 1) ? 'checked' : '';
                                                                                                $return = '<input data-ng-model="phone_privacy" type="radio" id="phone_privacy_' . $label . '" name="' . $name . '" value="' . ucwords($label) . '" ngValue="' . ucwords($label) . '" ' . $checked . '>';
                                                                                                $return .= '<label for="phone_privacy_' . $label . '" class="mrg-tb-lr col-md-12">' . ucwords($value) . '</label>';
                                                                                                return $return;
                                                                                            }
                                                                                        ]
                                                                                    )->label(false)->error(false); ?>
                                                                                </dd>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right "
                                                                       id="privacysetting"
                                                                       data-ng-click="savePhonePrivacy()">
                                                                        Save </a>
                                                                </div>
                                                                <?php ActiveForm::end(); ?>

                                                            </div>
                                                        </div>
                                                        <!--<div class="divider"></div>-->
                                                    </div>

                                                    <div role="tabpanel"
                                                         class="tab-pane <?= ($tab == 'EP') ? 'active' : ''; ?> "
                                                         id="tab2">
                                                        <div class="profile-edit pull-right">
                                                        </div>
                                                        <div class="inner-block">
                                                            <div class="row">
                                                                <?php $form = ActiveForm::begin(); ?>
                                                                <div class="col-md-10  mrg-tp-20">
                                                                    <div class="mid-col">
                                                                        <div class="form-cont">
                                                                            <div class="radio dl" id="IVA">
                                                                                <dd data-ng-init="photo_privacy=<?= $UserModel->photo_privacy ?>">
                                                                                    <?= $form->field($UserModel, 'photo_privacy')->RadioList(
                                                                                        Yii::$app->params['privacyPhoto'],
                                                                                        [
                                                                                            'item' => function ($index, $label, $name, $checked, $value) {
                                                                                                $checked = ($label == 1) ? 'checked' : '';
                                                                                                $return = '<input data-ng-model="photo_privacy" type="radio" id="photo_privacy_' . $label . '" name="' . $name . '" value="' . ucwords($label) . '" ngValue="' . ucwords($label) . '" ' . $checked . '>';
                                                                                                $return .= '<label for="photo_privacy_' . $label . '" class="mrg-tb-lr col-md-11 ">' . ucwords($value) . '</label>';
                                                                                                return $return;
                                                                                            }
                                                                                        ]
                                                                                    )->label(false)->error(false); ?>
                                                                                </dd>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right "
                                                                       data-ng-click="savePhotoPrivacy()"> Save </a>
                                                                </div>
                                                                <?php ActiveForm::end(); ?>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 col-md-offset-1">
                                                                    <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, "200" . Yii::$app->user->identity->propic, 200, '', 'Yes'), ['class' => 'img-responsive photo-main mainpropic ', 'width' => '200', 'alt' => 'Profile Photo']); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane" id="tab3">
                                                        <div class="profile-edit pull-right">
                                                        </div>
                                                        <div class="inner-block">
                                                            <div class="row">
                                                                <?php $form = ActiveForm::begin(); ?>
                                                                <div class="col-md-10  mrg-tp-20    ">
                                                                    <div class="mid-col">
                                                                        <div class="form-cont">
                                                                            <div class="radio dl" id="IVA">
                                                                                <dd data-ng-init="visitor_setting=<?= $UserModel->visitor_setting ?>">
                                                                                    <?= $form->field($UserModel, 'visitor_setting')->RadioList(
                                                                                        Yii::$app->params['privacyVisitor'],
                                                                                        [
                                                                                            'item' => function ($index, $label, $name, $checked, $value) {
                                                                                                $checked = ($label == 1) ? 'checked' : '';
                                                                                                $return = '<input data-ng-model="visitor_setting" type="radio" id="visitor_setting_' . $label . '" name="' . $name . '" value="' . ucwords($label) . '" ngValue="' . ucwords($label) . '" ' . $checked . '>';
                                                                                                $return .= '<label for="visitor_setting_' . $label . '" class="mrg-tb-lr ">' . ucwords($value) . '</label>';
                                                                                                return $return;
                                                                                            }
                                                                                        ]
                                                                                    )->label(false)->error(false); ?>
                                                                                </dd>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right "
                                                                       data-ng-click="saveVisitorPrivacy()"> Save </a>
                                                                </div>
                                                                <?php ActiveForm::end(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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


<?= $this->registerJsFile(Yii::$app->request->baseUrl . '/js/angular/controller/privacyController.js', ['depends' => [\frontend\assets\AppAsset::className()], 'position' => \yii\web\View::POS_END]); ?>