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
    $heightrange = range(134, 204);
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
    <?= $form->field($UPP, 'height_from')->dropDownList(
        ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
        ['prompt' => 'Height From']
    ); ?>
    <?= $form->field($UPP, 'height_to')->dropDownList(
        ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
        ['prompt' => 'Height To']
    ); ?>


    <!-- <?= $form->field($PartnersMaritalStatus, 'iMarital_Status_ID')->dropDownList(
        ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'),
        ['prompt' => 'Maritial Status']
    ); ?>-->

        <?= $form->field($PartnersMaritalStatus, 'iMarital_Status_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'),
            ['prompt' => 'Maritial Status']
        ); ?>
        <?= $form->field($PartnersGotra, 'iGotra_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getGotra(), 'iGotraID', 'vName'),
            ['prompt' => 'Gotra']
        ); ?>
    <?= $form->field($PartnersMothertongue, 'iMothertongue_ID')->dropDownList(
        ArrayHelper::map(CommonHelper::getMotherTongue(), 'ID', 'Name'),
        ['prompt' => 'Mother Toungue']
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
    <?= $form->field($PartnersCommunity, 'iCommunity_ID')->dropDownList(
        ArrayHelper::map(CommonHelper::getCommunity(), 'iCommunity_ID', 'vName'),
        ['prompt' => 'Community']
        ); ?>
    <?= $form->field($PartnersSubCommunity, 'iSub_Community_ID')->dropDownList(
        ArrayHelper::map(CommonHelper::getSubCommunity(), 'iSubCommunity_ID', 'vName'),
        ['prompt' => 'Sub Community']
        ); ?>
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
        <div class="">
            <input type="hidden" name="save" value="1">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right preferences_submit', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
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
            <dt>Height From</dt>
            <dd><?= CommonHelper::setInputVal($UPP->heightFrom->vName, 'text') ?>
            <dd>
            <dt>Height To</dt>
            <dd><?= CommonHelper::setInputVal($UPP->heightTo->vName, 'text') ?>
            <dd>
            <dt>Marital Status</dt>
            <dd><?= CommonHelper::setInputVal($PartnersMaritalStatus->maritalStatusName->vName,'text') ?><dd>
            <dt>Gotra</dt>
            <dd><?= CommonHelper::setInputVal($PartnersGotra->gotraName->vName,'text') ?><dd>
            <dt>Mothertoungue</dt>
            <dd><?= CommonHelper::setInputVal($PartnersMothertongue->partnersMothertongueName->Name, 'text') ?>
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
