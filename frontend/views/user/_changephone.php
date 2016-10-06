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
            'validateOnSubmit' => true,
            'fieldConfig' => [
                'template' => "{label}{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3 col-xs-3',
                    'offset' => '',
                    'wrapper' => 'col-sm-8 col-xs-8',
                    'error' => '',
                    'hint' => '',
                ]
            ]
        ]);
        ?>

        <div class="row">
            <div class="col-sm-2 col-xs-2">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= $form->field($model, 'county_code')->dropDownList(
                            ['+91' => '+91'],
                            ['class' => 'cs-select cs-skin-border', 'prompt' => 'Country Code']
                        )->label(false)->error(false); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-3">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= $form->field($model, 'Mobile', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Mobile No#</span> </label></span>{error}'])->input('number', ['class' => 'input__field input__field--akira form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-3">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'PHONE_NUMBER_CHANGE']) ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-primary', 'id' => 'cancel_change_phone', 'name' => 'cancel',]) ?>

            </div>

        </div>
        <?php ActiveForm::end(); ?>
        <?php
        if ($popup) {
            if ($flag) {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'CHANGE_PHONE_NUMBER');
                $this->registerJs('
                    $(".modal").on("hidden.bs.modal", function (e) {
                            getInlineDetail("' . Url::to(['user/phone-verification']) . '","#phone_verification","1");
                    })
                ');
            } else {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'CHANGE_PHONE_NUMBER');
            }
            $this->registerJs(' 
            notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
            ');

        } else {
            if ($flag) {
                $this->registerJs('
                            getInlineDetail("' . Url::to(['user/phone-verification']) . '","#phone_verification","1");
                ');
            }
        }
        $this->registerJs('
                 (function() { setDesign(); })();
        ');
    }
    ?>
</div>
