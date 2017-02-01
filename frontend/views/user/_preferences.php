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
        <div class="form-group field-partenersreligion-ireligion_id">
            <label class="control-label col-sm-3 col-xs-3" for="partenersreligion-ireligion_id">Religion</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select a Religion" name="PartenersReligion[iReligion_ID][]" size="4">
                    <?php
                    $ReligionArray = CommonHelper::getReligion();
                    foreach ($ReligionArray as $K => $V) { ?>
                        <option
                            value="<?= $V->iReligion_ID ?>" <?php if (in_array($V->iReligion_ID, $PartenersReligionIDs)) {
                            echo "selected";
                        } ?>><?= $V->vName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>
        <?php
        $heightrange = range(134, 204);
        $range = range(18, 100);
        ?>
        <?= $form->field($UPP, 'age_from')->dropDownList(
            array_combine($range, $range),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Age From']
        ); ?>

        <?= $form->field($UPP, 'age_to')->dropDownList(
            array_combine($range, $range),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Age To']
        ); ?>
        <?= $form->field($UPP, 'height_from')->dropDownList(
            ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Height From']
        ); ?>
        <?= $form->field($UPP, 'height_to')->dropDownList(
            ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Height To']
        ); ?>

        <div class="form-group field-partnersmaritalstatus-imarital_status_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnersmaritalstatus-imarital_status_id">Marital
                Status</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select a Marital Status" name="PartnersMaritalStatus[iMarital_Status_ID][]"
                        size="4">
                    <?php
                    $MaritalStatusArray = CommonHelper::getMaritalStatus();
                    foreach ($MaritalStatusArray as $K => $V) { ?>
                        <option
                            value="<?= $V->iMaritalStatusID ?>" <?php if (in_array($V->iMaritalStatusID, $PartnersMaritalPreferences)) {
                            echo "selected";
                        } ?>><?= $V->vName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>



        <?= $form->field($PartnersMothertongue, 'iMothertongue_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getMotherTongue(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Mother Toungue']
        ); ?>

        <?= $form->field($PartnersCommunity, 'iCommunity_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getCommunity(), 'iCommunity_ID', 'vName'),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Community']
        ); ?>
        <?= $form->field($PartnersSubCommunity, 'iSub_Community_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getSubCommunity(), 'iSubCommunity_ID', 'vName'),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Sub Community']
        ); ?>

        <?= $form->field($PartnersRaashi, 'raashi_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getRaashi(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Raashi']
        ); ?>

        <?= $form->field($PartnersCharan, 'charan_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getCharan(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Charan']
        ); ?>
        <?= $form->field($PartnersNakshtra, 'nakshtra_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getNaksatra(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Nakshtra']
        ); ?>
        <?= $form->field($PartnersNadi, 'nadi_id')->dropDownList(
            ArrayHelper::map(CommonHelper::getNadi(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast clspreferences', 'prompt' => 'Nadi']
        ); ?>

        <div class="form-group field-partnersgotra-igotra_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnersgotra-igotra_id">Gotra</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select Gotra" name="PartnersGotra[iGotra_ID][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getGotra() as $K => $V) { ?>
                        <option
                            value="<?= $V->iGotraID ?>" <?php if (in_array($V->iGotraID, $PartnersGotraPreferences)) {
                            echo "selected";
                        } ?>><?= $V->vName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>


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

        <div class="form-group field-partnersskintone-iskin_tone_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnersskintone-iskin_tone_id">Skin Tone</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select Skin Tone" name="PartnersGotra[iSkin_Tone_ID][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getGotra() as $K => $V) { ?>
                        <option
                            value="<?= $V->iGotraID ?>" <?php if (in_array($V->iGotraID, $PartnersGotraPreferences)) {
                            echo "selected";
                        } ?>><?= $V->vName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

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
          selectboxClassWise("clspreferences");
         ');
    } else {
        ?>
        <dl class="dl-horizontal">
            <dt>Religion</dt>
            <?php $PReligionArray = \common\models\Religion::getReligionNames(CommonHelper::removeComma(implode(",", $PartenersReligionIDs))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PReligionArray, 'vName'), 'text') ?></dd>

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
            <?php $PMaritalStatusArray = \common\models\MasterMaritalStatus::getPartnerMaritalStatus(CommonHelper::removeComma(implode(",", $PartnersMaritalPreferences))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PMaritalStatusArray, 'vName'), 'text') ?></dd>


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
            <?php
            #CommonHelper::pr($PartnersGotraPreferences);exit;
            $PGotraArray = \common\models\MasterGotra::getPartnerGotraStatus(CommonHelper::removeComma(implode(",", $PartnersGotraPreferences))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PGotraArray, 'vName'), 'text') ?></dd>

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
