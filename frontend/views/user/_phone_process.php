<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\models\User;

?>
    <div class="modal fade phone-change-model " id="phone-change-model" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 56%;" data-ng-app="userApp" data-ng-controller="userController">
            <!--<div class="modal-dialog" style="width: 56%;" >-->
            <p class="text-center mrg-bt-10"><img src="<?= CommonHelper::getLogo() ?>" width="157" height="61"
                                                  alt="logo">
            </p>

            <div class="modal-content">
                <div class="modal-header">
                    <!--<button type="button" class="close"
                            data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span>
                    </button>-->
                    <h2 class="text-center" id=""> <?= Yii::$app->params['multipleProfileMsg'] ?></h2>
                </div>
                <div class="modal-body">
                    <?php
                    $ModelPhoneProcess = User::findOne(Yii::$app->user->identity->id);
                    $form = ActiveForm::begin([
                        'id' => 'phone-process',
                        'action' => ['user/phone-process'],
                        'validateOnChange' => true,
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="box ">
                                <div class="mid1-col">
                                    <span class="text-danger"><?= Yii::$app->params['multipleProfile'] ?></span>
                                </div>
                                <div class="mid-col">
                                    <div class="required1 mrg-tp-0"><span class="text-notify"><h4>Please Choose an
                                                option to continue</h4> </span></div>
                                </div>
                                <div class="mid-col">
                                    <div class="form-cont">
                                        <div class="radio dl" id="IVA">
                                            <!--<dt>Smoke: </dt>-->
                                            <dd data-ng-init="multiple_profile_status=1">
                                                <?= $form->field($ModelPhoneProcess, 'multiple_profile_status')->RadioList(
                                                    Yii::$app->params['multipleProfileOption'],
                                                    [
                                                        'item' => function ($index, $label, $name, $checked, $value) {
                                                            $checked = ($label == 1) ? 'checked' : '';
                                                            $return = '<input data-ng-model="multiple_profile_status" type="radio" id="multiple_profile_status_' . $label . '" name="' . $name . '" value="' . ucwords($label) . '" ngValue="' . ucwords($label) . '" ' . $checked . '>';
                                                            $return .= '<label for="multiple_profile_status_' . $label . '" class="mrg-tb-lr ">' . ucwords($value) . '</label>';
                                                            return $return;
                                                        }
                                                    ]
                                                )->label(false)->error(false); ?>
                                            </dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="mid-col maxwd100">
                                    <div class="form-cont">
                					<span class="input input--akira input--filled input-textarea mrg-tp-10"
                                          data-ng-init="multiple_profile_reason=''">
                                            <textarea class="input__field input__field--akira col-md-12" cols="50"
                                                      data-ng-model="multiple_profile_reason"
                                                      rows="5" name="User[multiple_profile_reason]"
                                                      id="multiple_profile_reason"
                                                      placeholder="<?= Yii::$app->params['MultipleProfileTellUp'] ?>"></textarea>
                                                  <label class="input__label input__label--akira" for="input-22">
                                                     <span class="input__label-content input__label-content--akira">
                                                     </span>
                                                  </label>
                                    </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 text-left mrg-bt-10">
                            <?= Yii::$app->params['MultipleProfileContact'] ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <a href="javascript:void(0)"
                               class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left "
                               data-ng-click="multipleProfile()">
                                Continue > </a>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
<?= $this->registerJsFile(Yii::$app->request->baseUrl . '/js/angular/controller/userController.js', ['depends' => [\frontend\assets\AppAsset::className()], 'position' => \yii\web\View::POS_END]); ?>