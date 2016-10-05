<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

?>

<!--<div class="mrg-tp-10 mrg-bt-10">
    <p>We have sent a 4 digit PIN to your given <strong>mobile number</strong> via SMS/Text message</p>
</div>-->
<?php
if ($model->ePhoneVerifiedStatus == 'No') {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['phone-verification'],
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
        <div class="col-sm-4 col-xs-6">
            <div class="form-cont">
                <div class="form-cont">
                    <?= $form->field($model, 'phone_pin', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Enter Mobile PIN number</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control'], ['maxlength' => 4]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-6">
            <?= Html::submitButton('Verify', ['class' => 'btn btn-primary', 'name' => 'register8']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="mrg-tp-20 mrg-bt-10">
        <span class="phone_status"></span>
        <p>Didn't get PIN? <a href="javascript:void(0)" class="phone_verification"
                              data-name="phone"> Resend PIN </a>to my mobile number
            <strong><?= $model->DisplayMobile ?></strong>
            <a href="javascript:void(0)"
               data-target="#modelmobilenumber"
               data-toggle="modal" class="btn btn-default btn-xs"><span
                    class="glyphicon glyphicon-pencil"></span> Edit</a></p>
    </div>


<?php } else { ?>
    <div class="mrg-tp-20 mrg-bt-10">
        <span class="phone_status"></span>
        <p> Your <strong><?= $model->DisplayMobile ?></strong> mobile number is verified.
            <a href="javascript:void(0)"
               data-target="#modelmobilenumber"
               data-toggle="modal" class="btn btn-default btn-xs"><span
                    class="glyphicon glyphicon-pencil"></span> Edit</a></p>
    </div>
<?php } ?>


