<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

?>
<div class="looking_for">
    <?php
    if ($show) {
        $form = ActiveForm::begin([
            'id' => 'form',
            'action' => ['edit-looking-for'],
            'options' => ['data-pjax' => true],
            'layout' => 'horizontal',
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
        <?= $form->errorSummary([$UPP], ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
        <div class="box">
            <div class="small-col">
                <div class="required1"><!--<span class="text-danger">*</span>--></div>
            </div>
            <div class="mid-col">
                <div class="form-cont">
                    <?= $form->field($UPP, 'LookingFor', ["template" => '<span class="input input--akira input--filled input-textarea">{input}<label class="input__label input__label--akira" for="input-22"><span class="input__label-content input__label-content--akira">Looking for</span> </label></span>'])->textArea(['rows' => '5', 'cols' => '50', 'class' => "input__field input__field--akira", 'id' => 'tYourSelf'])->error(false) ?>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="">
                <input type="hidden" name="save" value="1">
                <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_looking', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>
            </div>
        </div>
        <?php ActiveForm::end();
    } else {
        ?>

        <dl class="dl-horizontal">
            <dt>Own Words</dt>
            <dd><?= CommonHelper::setInputVal($UPP->LookingFor, 'text') ?>
            <dd>
        </dl>

    <?php
    }
    ?>
</div>