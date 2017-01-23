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
        <?= $form->errorSummary([$PartenersReligion], ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
        <?= $form->field($PartenersReligion, 'iReligion_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Religion']
        ); ?>
        <?php
        $heightrange = range(134, 204);
        $range = range(18, 100);
        ?>
        <?= $form->field($UPP, 'age_from')->dropDownList(
            array_combine($range, $range),
            ['class' => 'demo-default select-beast', 'prompt' => 'Age From']
        ); ?>

        <?= $form->field($UPP, 'age_to')->dropDownList(
            array_combine($range, $range),
            ['class' => 'demo-default select-beast', 'prompt' => 'Age To']
        ); ?>
        <?= $form->field($UPP, 'height_from')->dropDownList(
            ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Height From']
        ); ?>
        <?= $form->field($UPP, 'height_to')->dropDownList(
            ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Height To']
        ); ?>


        <!-- <?= $form->field($PartnersMaritalStatus, 'iMarital_Status_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'),
            ['prompt' => 'Maritial Status']
        ); ?>-->

        <?= $form->field($PartnersMaritalStatus, 'iMarital_Status_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Maritial Status']
        ); ?>

        <?= $form->field($PartnersMothertongue, 'iMothertongue_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getMotherTongue(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Mother Toungue']
        ); ?>

        <?= $form->field($PartnersCommunity, 'iCommunity_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getCommunity(), 'iCommunity_ID', 'vName'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Community']
        ); ?>
        <?= $form->field($PartnersSubCommunity, 'iSub_Community_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getSubCommunity(), 'iSubCommunity_ID', 'vName'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Sub Community']
        ); ?>

        <?= $form->field($PartnersRaashi, 'raashi_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getRaashi(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Raashi']
        ); ?>

        <?= $form->field($PartnersCharan, 'charan_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getCharan(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Charan']
        ); ?>
        <?= $form->field($PartnersNakshtra, 'nakshtra_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getNaksatra(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Nakshtra']
        ); ?>
        <?= $form->field($PartnersNadi, 'nadi_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getNadi(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Nadi']
        ); ?>
        <?= $form->field($PartnersGotra, 'iGotra_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getGotra(), 'iGotraID', 'vName'),
            ['class' => 'demo-default select-beast', 'prompt' => 'Gotra']
        ); ?>


        <?= $form->field($UPP, 'manglik')->RadioList(
            ['Yes' => 'Yes', 'No' => 'No'],
            [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $checked = ($checked) ? 'checked' : '';
                    $return = '<input type="radio" class = "mangalik" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                    $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                    return $return;
                }
            ]
        )
        ?>

        <?= $form->field($UPP, 'drink')->RadioList(
            ['Yes' => 'Yes', 'No' => 'No', 'Occasionally' => 'Occasionally'],
            [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $checked = ($checked) ? 'checked' : '';
                    $return = '<input type="radio" class = "drink" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                    $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                    return $return;
                }
            ]
        )
        ?>
        <?= $form->field($UPP, 'smoke')->RadioList(
            ['Yes' => 'Yes', 'No' => 'No', 'Occasionally' => 'Occasionally'],
            [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $checked = ($checked) ? 'checked' : '';
                    $return = '<input type="radio" class = "smoke" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                    $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                    return $return;
                }
            ]
        )
        ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="form-cont">
                    <div class="form-cont">
                        <input type="hidden" name="save" value="1">
                        <?= Html::submitButton('save', ['class' => 'btn btn-primary my-profile-sc-button preferences_submit', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= Html::Button('Cancel', ['class' => 'btn btn-primary my-profile-sc-button', 'id' => 'cancel_edit_preferences', 'name' => 'cancel']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();
        $this->registerJs('
          selectbox();
         ');
    } else {
        ?>

        <dl class="dl-horizontal">
            <dt>Religion</dt>
            <dd><?= CommonHelper::setInputVal($PartenersReligion->religionName->vName,'text') ?><dd>
            <dt>Age From</dt>
            <dd><?= CommonHelper::setInputVal($UPP->age_from,'age') ?><dd>
            <dt>Age To</dt>
            <dd><?= CommonHelper::setInputVal($UPP->age_to,'age') ?><dd>
            <dt>Height From</dt>
            <dd><?= CommonHelper::setInputVal($UPP->heightFrom->vName, 'text') ?>
            <dd>
            <dt>Height To</dt>
            <dd><?= CommonHelper::setInputVal($UPP->heightTo->vName, 'text') ?>
            <dd>
            <dt>Marital Status</dt>
            <dd><?= CommonHelper::setInputVal($PartnersMaritalStatus->maritalStatusName->vName,'text') ?><dd>

            <dt>Mothertoungue</dt>
            <dd><?= CommonHelper::setInputVal($PartnersMothertongue->partnersMothertongueName->Name, 'text') ?>
            <dd>
            <dt>Raashi</dt>
            <dd><?= CommonHelper::setInputVal($PartnersRaashi->raashiName->Name, 'text') ?>
            <dd>
            <dt>Charan</dt>
            <dd><?= CommonHelper::setInputVal($PartnersCharan->charanName->Name, 'text') ?>
            <dt>Nakshtra</dt>
            <dd><?= CommonHelper::setInputVal($PartnersNakshtra->nakshtraName->Name, 'text') ?>
            <dt>Nadi</dt>
            <dd><?= CommonHelper::setInputVal($PartnersNadi->nadiName->Name, 'text') ?>
            <dd>
            <dt>Gotra</dt>
            <dd><?= CommonHelper::setInputVal($PartnersGotra->gotraName->vName, 'text') ?>
            <dd>
            <dt>Mangalik</dt>
            <dd><?= CommonHelper::setInputVal($UPP->manglik, 'text') ?>
            <dd>

            <dt>Community</dt>
            <dd><?= CommonHelper::setInputVal($PartnersCommunity->communityName->vName, 'text') ?>
            <dd>
            <dt>Sub Community</dt>
            <dd><?= CommonHelper::setInputVal($PartnersSubCommunity->subCommunityName->vName, 'text') ?>
            <dd>
            <dt>Drink</dt>
            <dd><?= CommonHelper::setInputVal($UPP->drink, 'text') ?>
            <dd>
            <dt>Smoke</dt>
            <dd><?= CommonHelper::setInputVal($UPP->smoke, 'text') ?>
            <dd>
        </dl>

    <?php
    }
    ?>
</div>
