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
            'validateOnChange' => true,
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
        <div class="form-group field-partnerseducationallevel-ieducation_level_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnerseducationallevel-ieducation_level_id">Education
                Level</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clsprofession"
                        placeholder="Select Education Level" name="PartnersEducationalLevel[iEducation_Level_ID][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getEducationLevel() as $K => $V) { ?>
                        <option
                            value="<?= $V->iEducationLevelID ?>" <?php if (in_array($V->iEducationLevelID, $PartenersEduLevelArray)) {
                            echo "selected";
                        } ?>><?= $V->vEducationLevelName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnerseducationfield-ieducation_field_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnerseducationfield-ieducation_field_id">Education
                Field</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clsprofession"
                        placeholder="Select Education Field" name="PartnersEducationField[iEducation_Field_ID][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getEducationField() as $K => $V) { ?>
                        <option
                            value="<?= $V->iEducationFieldID ?>" <?php if (in_array($V->iEducationFieldID, $PartenersEduFieldArray)) {
                            echo "selected";
                        } ?>><?= $V->vEducationFieldName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnerworkingas-iworking_as_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnerworkingas-iworking_as_id">Working As</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clsprofession"
                        placeholder="Select Working As" name="PartnerWorkingAs[iWorking_As_ID][]" size="4">
                    <?php
                    foreach (CommonHelper::getWorkingAS() as $K => $V) { ?>
                        <option
                            value="<?= $V->iWorkingAsID ?>" <?php if (in_array($V->iWorkingAsID, $PartenersWorkingAsArray)) {
                            echo "selected";
                        } ?>><?= $V->vWorkingAsName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnerworkingwith-iworking_with_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnerworkingwith-iworking_with_id">Working
                With</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clsprofession"
                        placeholder="Select Working With" name="PartnerWorkingWith[iWorking_With_ID][]" size="4">
                    <?php
                    foreach (CommonHelper::getWorkingWith() as $K => $V) { ?>
                        <option
                            value="<?= $V->iWorkingWithID ?>" <?php if (in_array($V->iWorkingWithID, $PartenersWorkingWithArray)) {
                            echo "selected";
                        } ?>><?= $V->vWorkingWithName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <?= $form->field($AI, 'annual_income_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getAnnualIncome(), 'iAnnualIncomeID', 'vAnnualIncome'),
            ['class' => 'demo-default select-beast clsprofession', 'prompt' => 'Annual Income']
        ); ?>


        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="form-cont">
                    <div class="form-cont">
                        <input type="hidden" name="save" value="1">
                        <?= Html::submitButton('save', ['class' => 'btn btn-primary preferences_submit my-profile-sc-button', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_profession', 'name' => 'cancel']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();
        $this->registerJs('
          selectboxClassWise("clsprofession");
         ');
    } else {
        ?>

        <dl class="dl-horizontal">
            <dt>Education Level</dt>
            <?php $PEducationLevelArray = \common\models\EducationLevel::getEducationLevelNames(CommonHelper::removeComma(implode(",", $PartenersEduLevelArray))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PEducationLevelArray, 'vEducationLevelName'), 'text') ?></dd>
            <dd>
            <dt>Education Field</dt>
            <?php $PEducationFieldArray = \common\models\EducationField::getEducationFieldNames(CommonHelper::removeComma(implode(",", $PartenersEduFieldArray))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PEducationFieldArray, 'vEducationFieldName'), 'text') ?></dd>
            <dd>
            <dt>Working As</dt>
            <?php $PWorkingAsArray = \common\models\WorkingAS::getWorkingAsNames(CommonHelper::removeComma(implode(",", $PartenersWorkingAsArray))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PWorkingAsArray, 'vWorkingAsName'), 'text') ?></dd>
            <dd>
            <dt>Working With</dt>
            <?php $PWorkingWithArray = \common\models\WorkingWith::getWorkingWithNames(CommonHelper::removeComma(implode(",", $PartenersWorkingWithArray))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PWorkingWithArray, 'vWorkingWithName'), 'text') ?></dd>
            <dd>
            <dt>Annual Income</dt>
            <dd><?= CommonHelper::setInputVal($AI->annualIncomeName->vAnnualIncome, 'text') ?>
            <dd>
        </dl>

    <?php
    }
    ?>
</div>