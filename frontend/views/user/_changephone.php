<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

?>
<div id="phone_verification">
    <?php
    if (!$show) {
        $form = ActiveForm::begin([
            'id' => 'form',
            'action' => ['phone-number-change'],
            'options' => ['data-pjax' => true],
            #'layout' => 'horizontal',
            'validateOnChange' => false,
            'validateOnSubmit' => true
        ]);
        ?>
        <!--<div class="row">
            <div class="col-sm-3 col-xs-3">
                <div class="form-cont center pw" style="display:none">
                    <p> Please wait...</p>
                </div>
            </div>
        </div>-->
        <div class="row">
            <div class="col-md-2">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= $form->field($model, 'county_code')->dropDownList(
                            ['+91' => '+91'],
                            ['class' => 'cs-select cs-skin-border', 'prompt' => 'Country Code']
                        )->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= $form->field($model, 'Mobile', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Mobile No#</span> </label></span>{error}'])->input('number', ['class' => 'input__field input__field--akira form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary phone_submit', 'name' => 'save', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'value' => 'PHONE_NUMBER_CHANGE']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= Html::Button('Cancel', ['class' => 'btn btn-primary', 'id' => 'cancel_change_phone', 'name' => 'cancel',]) ?>
                    </div>
                </div>
            </div>

        </div>
        <?php ActiveForm::end(); ?>
        <?php
        if ($popup) {
            if ($flag) {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'CHANGE_PHONE_NUMBER');
                $this->registerJs('
                        loaderStop();
                    $(".modal").on("hidden.bs.modal", function (e) {
                            getInlineDetail("' . Url::to(['user/phone-verification']) . '","#phone_verification","1");
                    })
                ');
            } else {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'CHANGE_PHONE_NUMBER');
            }
            $this->registerJs(' 
            notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
                                        $(".pw").hide();
            ');

        } else {
            if ($flag) {
                $this->registerJs('
                            getInlineDetail("' . Url::to(['user/phone-verification']) . '","#phone_verification","1");
                                                        $(".pw").hide();
                ');
            }
        }
        $this->registerJs('
          setDesign();
          (function() { 
              $(".phone_submit").click(function(){
                $(".pw").show();            
                })
 
          
          })();
          $(".phone_submit").on("click", function() {
        var $this = $(this);
        $this.button("loading");
        setTimeout(function() {
            $this.button("reset");
        }, 4000);
    });
         ');

    }
    ?>
</div>
<style>
    .btn-primary.disabled, .btn-primary.disabled.active, .btn-primary.disabled.focus, .btn-primary.disabled:active, .btn-primary.disabled:focus, .btn-primary.disabled:hover, .btn-primary[disabled], .btn-primary[disabled].active, .btn-primary[disabled].focus, .btn-primary[disabled]:active, .btn-primary[disabled]:focus, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary, fieldset[disabled] .btn-primary.active, fieldset[disabled] .btn-primary.focus, fieldset[disabled] .btn-primary:active, fieldset[disabled] .btn-primary:focus, fieldset[disabled] .btn-primary:hover {
        background-color: #ee1845;
        border-color: #ee1845;
    }
</style>