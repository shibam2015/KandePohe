<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

?>
<style>
    input[type="radio"], input[type="checkbox"] {
        display: inline-block;
    }

    input[type="radio"]:checked + label::before {
        content: "";
    }
</style>
<div class="div_preferences">
    <?php
    if ($show) {
        $form = ActiveForm::begin([
            'id' => 'form',
            'action' => ['edit-preferences-profession'],
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
        <?= $form->errorSummary([$PartnersEducationalLevel], ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
        <?= $form->field($PartnersEducationalLevel, 'iEducation_Level_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getEducationLevel(), 'iEducationLevelID', 'vEducationLevelName'),
            ['prompt' => 'Education Level']
        ); ?>

        <?= $form->field($PartnersEducationField, 'iEducation_Field_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getEducationField(), 'iEducationFieldID', 'vEducationFieldName'),
            ['prompt' => 'Education Field']
        ); ?>
        <?= $form->field($PW, 'iWorking_As_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getWorkingAS(), 'iWorkingAsID', 'vWorkingAsName'),
            ['prompt' => 'Working As']
        ); ?>
        <?= $form->field($WorkingW, 'iWorking_With_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getWorkingWith(), 'iWorkingWithID', 'vWorkingWithName'),
            ['prompt' => 'Working With']
        ); ?>
        <?= $form->field($AI, 'annual_income_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getAnnualIncome(), 'iAnnualIncomeID', 'vAnnualIncome'),
            ['prompt' => 'Annual Income']
        ); ?>


        <div class="row">
            <div class="">
                <input type="hidden" name="save" value="1">
                <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right preferences_submit', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_profession', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>
            </div>
        </div>
        <?php ActiveForm::end();
    } else {
        ?>

        <dl class="dl-horizontal">
            <dt>Education Level</dt>
            <dd><?= CommonHelper::setInputVal($PartnersEducationalLevel->educationLevelName->vEducationLevelName, 'text') ?>
            <dd>
            <dt>Education Field</dt>
            <dd><?= CommonHelper::setInputVal($PartnersEducationField->educationFieldName->vEducationFieldName, 'text') ?>
            <dd>
            <dt>Working As</dt>
            <dd><?= CommonHelper::setInputVal($PW->workingAsName->vWorkingAsName, 'text') ?>
            <dd>
            <dt>Working With</dt>
            <dd><?= CommonHelper::setInputVal($WorkingW->workingWithName->vWorkingWithName, 'text') ?>
            <dd>
            <dt>Annual Income</dt>
            <dd><?= CommonHelper::setInputVal($AI->annualIncomeName->vAnnualIncome, 'text') ?>
            <dd>
        </dl>

    <?php
    }
    ?>
</div>