<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
#use frontend\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\CommonHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<style>
    input[type="radio"], input[type="checkbox"] {
        display: inline-block;
    }

    input[type="radio"]:checked + label::before {
        content: "";
    }

    .div_preferences {
        padding: 0px 25px;
    }
</style>
<main>
    <div class="main-section">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-section">
                            <h3> Partner Preferences
                                <!--<a href="<? /*= Yii::$app->homeUrl */ ?>user/dashboard" class="pull-right"><span
                                        class="link_small">( I will do this later )</span> </a>-->
                            </h3>

                            <div class="row no-gutter">
                                <div class="col-lg-8 col-md-12 col-sm-12">


                                    <!--<h3>Partner Details</h3>
            <!- <span class="error">Oops! Please ensure all fields are valid</span> -->
                                    <!--<p><span class="text-danger">*</span> marked fields are mandatory</p>-->
                                    <?php

                                    $form = ActiveForm::begin([
                                        'id' => 'form-preferences',
                                        'action' => ['partner-preferences'],
                                        //'options' => ['data-pjax' => true],
                                        'layout' => 'horizontal',
                                        'validateOnChange' => false,
                                        // 'validateOnSubmit' => true,
                                        //'enableClientValidation'=> true,
                                        //'enableAjaxValidation'=> false,
                                        // 'validateOnSubmit' => false,
                                        // 'validateOnSubmit' => true,
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

                                    <div class="div_preferences">
                                        <div class="fb-profile-text padd-xs padd-tp-0">
                                            <h1><span class="heading-icons icon2"></span> My Preferences</h1>
                                        </div>
                                        <?= $form->errorSummary($model, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
                                        <div class="form-group field-partenersreligion-ireligion_id required">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partenersreligion-ireligion_id">Religion</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state-ireligion_id" multiple
                                                        class="demo-default select-beast clspreferences"
                                                        placeholder="Select a Religion"
                                                        name="PartenersReligion[iReligion_ID][]" size="4">
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersmaritalstatus-imarital_status_id">Marital
                                                Status</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
                                                        placeholder="Select a Marital Status"
                                                        name="PartnersMaritalStatus[iMarital_Status_ID][]"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partners_community-icommunity_id">Community</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
                                                        placeholder="Select Community"
                                                        name="PartnersCommunity[iCommunity_ID][]"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partners_subcommunity-isub_community_id">Sub
                                                Community</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
                                                        placeholder="Select Sub Community"
                                                        name="PartnersSubcommunity[iSub_Community_ID][]"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersgotra-igotra_id">Gotra</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersdrink-drink_type">Drink</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnerssmoke-smoke_type">Smoke</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersskintone-iskin_tone_id">Skin Tone</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
                                                        placeholder="Select Skin Tone"
                                                        name="PartnersSkinTone[iSkin_Tone_ID][]"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersbodytype-ibody_type_id">Body Type</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
                                                        placeholder="Select Body Type"
                                                        name="PartnersBodyType[iBody_Type_ID][]"
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
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersspectacles-type">Spectacles</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspreferences"
                                                        placeholder="Select a Spectacles"
                                                        name="PartnersSpectacles[type][]"
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


                                    </div>

                                    <div class="div_preferences">
                                        <div class="fb-profile-text padd-xs padd-tp-0">
                                            <h1><span class="heading-icons icon6"></span>Profession Preferences
                                            </h1>
                                        </div>

                                        <div class="form-group field-partnerseducationallevel-ieducation_level_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnerseducationallevel-ieducation_level_id">Education
                                                Level</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clsprofession"
                                                        placeholder="Select Education Level"
                                                        name="PartnersEducationalLevel[iEducation_Level_ID][]"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnerseducationfield-ieducation_field_id">Education
                                                Field</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clsprofession"
                                                        placeholder="Select Education Field"
                                                        name="PartnersEducationField[iEducation_Field_ID][]"
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnerworkingas-iworking_as_id">Working As</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clsprofession"
                                                        placeholder="Select Working As"
                                                        name="PartnerWorkingAs[iWorking_As_ID][]" size="4">
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
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnerworkingwith-iworking_with_id">Working
                                                With</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clsprofession"
                                                        placeholder="Select Working With"
                                                        name="PartnerWorkingWith[iWorking_With_ID][]" size="4">
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

                                        <?= $form->field($UPP, 'annual_income_from')->dropDownList(
                                            ArrayHelper::map(CommonHelper::getAnnualIncome(), 'iAnnualIncomeID', 'vAnnualIncome'),
                                            ['class' => 'demo-default select-beast clsprofession', 'prompt' => 'Annual Income From']
                                        ); ?>
                                        <?= $form->field($UPP, 'annual_income_to')->dropDownList(
                                            ArrayHelper::map(CommonHelper::getAnnualIncome(), 'iAnnualIncomeID', 'vAnnualIncome'),
                                            ['class' => 'demo-default select-beast clsprofession', 'prompt' => 'Annual Income To']
                                        ); ?>

                                    </div>
                                    <div class="div_preferences">
                                        <div class="fb-profile-text padd-xs padd-tp-0">
                                            <h1><span class="heading-icons icon2"></span> Location Preferences
                                            </h1>
                                        </div>
                                        <div class="form-group field-partners_countries-country_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partners_countries-country_id">Country</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clselocation"
                                                        placeholder="Select Country"
                                                        name="PartnersCountries[country_id][]"
                                                        size="4">
                                                    <?php
                                                    foreach (CommonHelper::getCountry() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->iCountryId ?>" <?php if (in_array($V->iCountryId, $PartnersCountries)) {
                                                            echo "selected";
                                                        } ?>><?= $V->vCountryName ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group field-partnersstates-state_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersstates-state_id">State</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clselocation"
                                                        placeholder="Select State" name="PartnersStates[state_id][]"
                                                        size="4">
                                                    <?php
                                                    #echo "====>".$CountryIDs;exit;
                                                    foreach (CommonHelper::getState() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->iStateId ?>" <?php if (in_array($V->iStateId, $PartnersStates)) {
                                                            echo "selected";
                                                        } ?>><?= $V->vStateName ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group field-partnerscities-city_id">
                                            <label class="control-label col-sm-3 col-xs-3" for="partnerscities-city_id">City</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clselocation"
                                                        placeholder="Select City" name="PartnersCities[city_id][]"
                                                        size="4">
                                                    <?php
                                                    foreach (CommonHelper::getCity() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->iCityId ?>" <?php if (in_array($V->iCityId, $PartnersCities)) {
                                                            echo "selected";
                                                        } ?>><?= $V->vCityName ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="div_preferences">
                                        <div class="fb-profile-text padd-xs padd-tp-0">
                                            <h1><span
                                                    class="heading-icons icon5"></span>
                                                Family Preferences
                                            </h1>
                                        </div>
                                        <div
                                            class="form-group field-partners_family_affluence_level-family_affluence_level_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partners_family_affluence_level-family_affluence_level_id">Family
                                                Affluence Level</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspartnersfamily"
                                                        placeholder="Select Family Affluence Level"
                                                        name="PartnersFamilyAffluenceLevel[family_affluence_level_id][]"
                                                        size="4">
                                                    <?php
                                                    foreach (CommonHelper::getFamilyAffulenceLevel() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartnersFamilyALevel)) {
                                                            echo "selected";
                                                        } ?>><?= $V->Name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group field-partners_family_type-family_type">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partners_family_type-family_type">Family
                                                Type</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspartnersfamily"
                                                        placeholder="Select Family Type"
                                                        name="PartnersFamilyType[family_type][]"
                                                        size="4">
                                                    <?php
                                                    foreach (Yii::$app->params['familyTypeArray'] as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V ?>" <?php if (in_array($V, $PartnersFamilyTypeS)) {
                                                            echo "selected";
                                                        } ?>><?= $K ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="div_preferences">
                                        <div class="fb-profile-text padd-xs padd-tp-0">
                                            <h1><span
                                                    class="heading-icons icon7"></span>
                                                Hobby/Interest Preferences
                                            </h1>
                                        </div>

                                        <div class="form-group field-partnersinterest-interest_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersinterest-interest_id">Interest</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspartnerhobby"
                                                        placeholder="Select an Interest"
                                                        name="PartnersInterest[interest_id][]" size="4">
                                                    <?php
                                                    foreach (CommonHelper::getInterests() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersInterestArray)) {
                                                            echo "selected";
                                                        } ?>><?= $V->Name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group field-partnersfavouritereads-read_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersfavouritereads-read_id">Favourite
                                                Reads</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspartnerhobby "
                                                        placeholder="Select a Favourite Reads"
                                                        name="PartnersFavouriteReads[read_id][]" size="4">
                                                    <?php
                                                    foreach (CommonHelper::getFavouriteReads() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersFavReadsArray)) {
                                                            echo "selected";
                                                        } ?>><?= $V->Name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group field-partnersfavouritemusic-music_name_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersfavouritemusic-music_name_id">Favourite
                                                Music</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspartnerhobby"
                                                        placeholder="Select a Favourite Music"
                                                        name="PartnersFavouriteMusic[music_name_id][]"
                                                        size="4">
                                                    <?php
                                                    foreach (CommonHelper::getFavouriteMusic() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersMusicArray)) {
                                                            echo "selected";
                                                        } ?>><?= $V->Name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group field-partnersfavouritecousines-cousines_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersfavouritecousines-cousines_id">Favourite
                                                Cousines</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspartnerhobby"
                                                        placeholder="Select a Favourite Cousine"
                                                        name="PartnersFavouriteCousines[cousines_id][]"
                                                        size="4">
                                                    <?php
                                                    foreach (CommonHelper::getFavouriteCousines() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersCousinsArray)) {
                                                            echo "selected";
                                                        } ?>><?= $V->Name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group field-partnersfitnessactivities-fitness_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnersfitnessactivities-fitness_id">Sports Fitness
                                                Activities</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspartnerhobby"
                                                        placeholder="Select a Sports Fitness Activities"
                                                        name="PartnersFitnessActivities[fitness_id][]" size="4">
                                                    <?php
                                                    foreach (CommonHelper::getSportsFitnActivities() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersFitnessArray)) {
                                                            echo "selected";
                                                        } ?>><?= $V->Name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group field-partnerspreferreddresstype-dress_style_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnerspreferreddresstype-dress_style_id">Preferred
                                                Dress Style</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspartnerhobby"
                                                        placeholder="Select a Preferred Dress Style"
                                                        name="PartnersPreferredDressType[dress_style_id][]" size="4">
                                                    <?php
                                                    foreach (CommonHelper::getPreferredDressStyle() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersDressStyleArray)) {
                                                            echo "selected";
                                                        } ?>><?= $V->Name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group field-partnerspreferredmovies-movie_id">
                                            <label class="control-label col-sm-3 col-xs-3"
                                                   for="partnerspreferredmovies-movie_id">Preferred
                                                Movie</label>

                                            <div class="col-sm-8 col-xs-8">
                                                <select id="select-state" multiple
                                                        class="demo-default select-beast clspartnerhobby"
                                                        placeholder="Select a Preferred Movie"
                                                        name="PartnersPreferredMovies[movie_id][]" size="4">
                                                    <?php
                                                    foreach (CommonHelper::getPreferredMovies() as $K => $V) { ?>
                                                        <option
                                                            value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersMoviesArray)) {
                                                            echo "selected";
                                                        } ?>><?= $V->Name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="div_preferences">
                                        <div class="fb-profile-text padd-xs padd-tp-0">
                                            <h1><span
                                                    class="heading-icons <?= ($model->Gender == 'MALE') ? 'icon1' : 'icon9'; ?>"></span>
                                                What I am looking for
                                            </h1>
                                        </div>
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
                                    </div>
                                    <div class="row">
                                        <div class="small-col">
                                            <div class="required1"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-cont">
                                                <div class="form-cont">
                                                    <?= Html::submitButton('CONTINUE', ['class' => 'btn btn-primary mrg-tp-10 ', 'name' => 'register11']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>

                            </div>
                        </div>
                        <div class="privacy-promo">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="promo">
                                        <figure>
                                            <?= Html::img('@web/images/icon1.jpg', ['width' => '51', 'height' => '65', 'alt' => 'Phone Privacy']); ?>
                                        </figure>
                                        <figcaption>
                                            <h4>100% Phone Privacy</h4>

                                            <p>Options Available </p>
                                        </figcaption>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="promo">
                                        <figure>
                                            <?= Html::img('@web/images/icon2.jpg', ['width' => '53', 'height' => '65', 'alt' => 'Phone Control']); ?>
                                        </figure>
                                        <figcaption>
                                            <h4>Privacy Control</h4>

                                            <p>You can control the viewership of your number </p>
                                        </figcaption>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="promo">
                                        <figure>
                                            <?= Html::img('@web/images/icon3.jpg', ['width' => '46', 'height' => '67', 'alt' => 'Sharing']); ?>
                                        </figure>
                                        <figcaption>
                                            <h4>Sharing</h4>

                                            <p>You can control the privacy of your number </p>
                                        </figcaption>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
</main>



