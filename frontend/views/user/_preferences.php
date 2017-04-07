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
        <?= $form->errorSummary($UPP, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
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
                        }
                        if (count($PartenersReligionIDs) == 0) {
                            echo "selected";
                        } ?>><?= $V->vName ?></option>
                    <?php }
                    ?>
                </select>
                <?php #Todo : Please remove count()==0 condition.?>
            </div>
        </div>
        <?php
        $heightrange = range(134, 204);
        $range = range(18, 99);
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

        <div class="form-group field-partners_community-icommunity_id">
            <label class="control-label col-sm-3 col-xs-3" for="partners_community-icommunity_id">Community</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select Community" name="PartnersCommunity[iCommunity_ID][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getCommunity() as $K => $V) { ?>
                        <option
                            value="<?= $V->iCommunity_ID ?>" <?php if (in_array($V->iCommunity_ID, $PartnersCommunity)) {
                            echo "selected";
                        } ?>><?= $V->vName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partners_subcommunity-isub_community_id">
            <label class="control-label col-sm-3 col-xs-3" for="partners_subcommunity-isub_community_id">Sub
                Community</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select Sub Community" name="PartnersSubcommunity[iSub_Community_ID][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getSubCommunity() as $K => $V) { ?>
                        <option
                            value="<?= $V->iSubCommunity_ID ?>" <?php if (in_array($V->iSubCommunity_ID, $PartnersSubCommunity)) {
                            echo "selected";
                        } ?>><?= $V->vName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>


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
        <div class="form-group field-partnersdrink-drink_type">
            <label class="control-label col-sm-3 col-xs-3" for="partnersdrink-drink_type">Drink</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select Drink" name="PartnersDrink[drink_type][]"
                        size="4">
                    <?php
                    foreach (Yii::$app->params['drinkArray'] as $K => $V) { ?>
                        <option
                            value="<?= $V ?>" <?php if (in_array($V, $PartnersDrink)) {
                            echo "selected";
                        } ?>><?= $K ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnerssmoke-smoke_type">
            <label class="control-label col-sm-3 col-xs-3" for="partnerssmoke-smoke_type">Smoke</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select Smoke" name="PartnersSmoke[smoke_type][]"
                        size="4">
                    <?php
                    foreach (Yii::$app->params['smokeArray'] as $K => $V) { ?>
                        <option
                            value="<?= $V ?>" <?php if (in_array($V, $PartnersSmoke)) {
                            echo "selected";
                        } ?>><?= $K ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnersskintone-iskin_tone_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnersskintone-iskin_tone_id">Skin Tone</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select Skin Tone" name="PartnersSkinTone[iSkin_Tone_ID][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getSkinTone() as $K => $V) { ?>
                        <option
                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartnersSkinTone)) {
                            echo "selected";
                        } ?>><?= $V->Name ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnersbodytype-ibody_type_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnersbodytype-ibody_type_id">Body Type</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select Body Type" name="PartnersBodyType[iBody_Type_ID][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getBodyType() as $K => $V) { ?>
                        <option
                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartnersBodyType)) {
                            echo "selected";
                        } ?>><?= $V->Name ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnersdiet-diet_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnersdiet-diet_id">Diet</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select Diet" name="PartnersDiet[diet_id][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getDiet() as $K => $V) { ?>
                        <option
                            value="<?= $V->iDietID ?>" <?php if (in_array($V->iDietID, $PartnersDiet)) {
                            echo "selected";
                        } ?>><?= $V->vName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnersspectacles-type">
            <label class="control-label col-sm-3 col-xs-3" for="partnersspectacles-type">Spectacles</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clspreferences"
                        placeholder="Select a Spectacles" name="PartnersSpectacles[type][]"
                        size="4">
                    <?php
                    foreach (Yii::$app->params['eyesArray'] as $K => $V) { ?>
                        <option
                            value="<?= $V ?>" <?php if (in_array($V, $PartnersSpectacles)) {
                            echo "selected";
                        } ?>><?= $K ?></option>
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
           $(".edit_preferences").hide();
        ');
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

            <dt>Height To</dt>
            <dd><?= CommonHelper::setInputVal($UPP->heightTo->vName, 'text') ?>

            <dt>Marital Status</dt>
            <?php $PMaritalStatusArray = \common\models\MasterMaritalStatus::getPartnerMaritalStatus(CommonHelper::removeComma(implode(",", $PartnersMaritalPreferences))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PMaritalStatusArray, 'vName'), 'text') ?></dd>


            <dt>Mothertoungue</dt>
            <dd><?= CommonHelper::setInputVal($PartnersMothertongue->partnersMothertongueName->Name, 'text') ?>
            <dt>Raashi</dt>
            <dd><?= CommonHelper::setInputVal($PartnersRaashi->raashiName->Name, 'text') ?>
            <dt>Charan</dt>
            <dd><?= CommonHelper::setInputVal($PartnersCharan->charanName->Name, 'text') ?>
            <dt>Nakshtra</dt>
            <dd><?= CommonHelper::setInputVal($PartnersNakshtra->nakshtraName->Name, 'text') ?>
            <dt>Nadi</dt>
            <dd><?= CommonHelper::setInputVal($PartnersNadi->nadiName->Name, 'text') ?>

            <dt>Gotra</dt>
            <?php $PGotraArray = \common\models\MasterGotra::getPartnerGotraStatus(CommonHelper::removeComma(implode(",", $PartnersGotraPreferences))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PGotraArray, 'vName'), 'text') ?></dd>

            <dt>Mangalik</dt>
            <dd><?= CommonHelper::setInputVal($UPP->manglik, 'text') ?>

            <dt>Community</dt>
            <?php $PCommunityArray = \common\models\MasterCommunity::getCommunityNames(CommonHelper::removeComma(implode(",", $PartnersCommunity))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PCommunityArray, 'vName'), 'text') ?></dd>


            <dt>Sub Community</dt>
            <?php $PSubCommunityArray = \common\models\MasterCommunitySub::getSubCommunityNames(CommonHelper::removeComma(implode(",", $PartnersSubCommunity))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PSubCommunityArray, 'vName'), 'text') ?></dd>


            <dt>Drink</dt>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getValuesFromArray(Yii::$app->params['drinkArray'], $PartnersDrink, 1), 'text') ?></dd>
            <dt>Smoke</dt>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getValuesFromArray(Yii::$app->params['smokeArray'], $PartnersSmoke, 1), 'text') ?></dd>
            <dt>Skin Tone</dt>
            <?php $PBodyTypeArray = \common\models\BodyType::getPartnerBodyType(CommonHelper::removeComma(implode(",", $PartnersBodyType))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PBodyTypeArray, 'Name'), 'text') ?></dd>
            <dt>Diet</dt>
            <?php $PDietArray = \common\models\MasterDiet::getDietNames(CommonHelper::removeComma(implode(",", $PartnersDiet))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PDietArray, 'vName'), 'text') ?></dd>
            <dt>Spectacles</dt>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getValuesFromArray(Yii::$app->params['eyesArray'], $PartnersSpectacles, 1), 'text') ?></dd>
        </dl>
    <?php
        $this->registerJs('
           $(".edit_preferences").show();
        ');
    }
    ?>
</div>
