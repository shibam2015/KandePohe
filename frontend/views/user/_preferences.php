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
        'action' => ['edit-preferences'],
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
    <?= $form->errorSummary([$PartenersReligion],['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
        <?= $form->field($PartenersReligion, 'iReligion_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
            ['prompt' => 'Religion']
        ); ?>
        <?php
            $range = range(18, 100);
        ?>
        <?= $form->field($UPP, 'age_from')->dropDownList(
            array_combine($range, $range),
            ['prompt' => 'Age From']
        ); ?>

        <?= $form->field($UPP, 'age_to')->dropDownList(
            array_combine($range, $range),
            ['prompt' => 'Age To']
        ); ?>

        <?= $form->field($PartnersMaritalStatus, 'iMarital_Status_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'),
            ['prompt' => 'Maritial Status']
        ); ?>
        <?= $form->field($PartnersGotra, 'iGotra_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getGotra(), 'iGotraID', 'vName'),
            ['prompt' => 'Gotra']
        ); ?>
        <?= $form->field($PartnersFathersStatus, 'iFather_Status_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
            ['prompt' => 'Father Status']
        ); ?>
        <?= $form->field($PartnersMothersStatus, 'iMother_Status_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
            ['prompt' => 'Mother Status']
        ); ?>
        <?= $form->field($PartnersEducationalLevel, 'iEducation_Level_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getEducationLevel(), 'iEducationLevelID', 'vEducationLevelName'),
            ['prompt' => 'Education Level']
        ); ?>

        <?= $form->field($PartnersEducationField, 'iEducation_Field_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getEducationField(), 'iEducationFieldID', 'vEducationFieldName'),
            ['prompt' => 'Education Field']
        ); ?>

    <div class="row">
        <div class="">
            <input type="hidden" name="save" value="1">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
            <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_preferences', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>
        </div>
    </div>
    <?php ActiveForm::end();
} else {
    ?>
   
        <dl class="dl-horizontal">
            <dt>Religion</dt>
            <dd><?= CommonHelper::setInputVal($PartenersReligion->religionName->vName,'text') ?><dd>
            <dt>Age From</dt>
            <dd><?= CommonHelper::setInputVal($UPP->age_from,'age') ?><dd>
            <dt>Age To</dt>
            <dd><?= CommonHelper::setInputVal($UPP->age_to,'age') ?><dd>
            <dt>Marital Status</dt>
            <dd><?= CommonHelper::setInputVal($PartnersMaritalStatus->maritalStatusName->vName,'text') ?><dd>
            <dt>Gotra</dt>
            <dd><?= CommonHelper::setInputVal($PartnersGotra->gotraName->vName,'text') ?><dd>
            <dt>Father Status</dt>
            <dd><?= CommonHelper::setInputVal($PartnersFathersStatus->fatherStatus->vName,'text') ?><dd>
            <dt>Mother Status</dt>
            <dd><?= CommonHelper::setInputVal($PartnersMothersStatus->motherStatus->vName,'text') ?><dd>
            <dt>Education Level</dt>
            <dd><?= CommonHelper::setInputVal($PartnersEducationalLevel->educationLevelName->vEducationLevelName,'text') ?><dd>
            <dt>Education Field</dt>
            <dd><?= CommonHelper::setInputVal($PartnersEducationField->educationFieldName->vEducationFieldName,'text') ?><dd>
        </dl>
  
    <?php
}
?>
  </div>