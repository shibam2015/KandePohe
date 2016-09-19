<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'created_at')->textInput() ?>
    <?= $form->field($model, 'updated_at')->textInput() ?>
    <?= $form->field($model, 'Registration_Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'completed_step')->textInput() ?>
    <?= $form->field($model, 'eEmailVerifiedStatus')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>
    <?= $form->field($model, 'ePhoneVerifiedStatus')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>
<?= $form->field($model, 'eFirstVerificationMailStatus')->dropDownList([ 'YES' => 'YES', 'NO' => 'NO', ], ['prompt' => '']) ?>
-->

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Mobile')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Profile_created_for')->dropDownList([ 'BRIDE' => 'BRIDE', 'GROOM' => 'GROOM', 'SELF' => 'SELF', ], ['prompt' => '']) ?>
    <?= $form->field($model, 'First_Name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Last_Name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Gender')->dropDownList([ 'MALE' => 'MALE', 'FEMALE' => 'FEMALE', ], ['prompt' => '']) ?>
    <?= $form->field($model, 'DOB')->textInput() ?>
    <?= $form->field($model, 'Time_of_Birth')->textInput() ?>
    <?= $form->field($model, 'Age')->textInput() ?>
    <?= $form->field($model, 'Birth_Place')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Marital_Status')->textInput() ?>
    <?= $form->field($model, 'iReligion_ID')->textInput() ?>

    <?= $form->field($model, 'iEducationLevelID')->textInput() ?>
    <?= $form->field($model, 'iEducationFieldID')->textInput() ?>
    <?= $form->field($model, 'iWorkingWithID')->textInput() ?>
    <?= $form->field($model, 'iWorkingAsID')->textInput() ?>
    <?= $form->field($model, 'iAnnualIncomeID')->textInput() ?>
    <?= $form->field($model, 'iCommunity_ID')->textInput() ?>
    <?= $form->field($model, 'toc')->dropDownList([ 'YES' => 'YES', ], ['prompt' => '']) ?>
    <?= $form->field($model, 'county_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'iSubCommunity_ID')->textInput() ?>
    <?= $form->field($model, 'iDistrictID')->textInput() ?>
    <?= $form->field($model, 'iGotraID')->textInput() ?>
    <?= $form->field($model, 'iMaritalStatusID')->textInput() ?>
    <?= $form->field($model, 'iTalukaID')->textInput() ?>
    <?= $form->field($model, 'iCountryId')->textInput() ?>
    <?= $form->field($model, 'iStateId')->textInput() ?>
    <?= $form->field($model, 'iCityId')->textInput() ?>
    <?= $form->field($model, 'noc')->textInput() ?>
    <?= $form->field($model, 'vAreaName')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'cnb')->dropDownList([ 'YES' => 'YES', 'NO' => 'NO', ], ['prompt' => '']) ?>
    <?= $form->field($model, 'iHeightID')->textInput() ?>
    <?= $form->field($model, 'vSkinTone')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vBodyType')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vSmoke')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vDrink')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vSpectaclesLens')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vDiet')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'tYourSelf')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vDisability')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'propic')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'pin_email_vaerification')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'iFatherStatusID')->textInput() ?>
    <?= $form->field($model, 'iMotherStatusID')->textInput() ?>
    <?= $form->field($model, 'iFatherWorkingAsID')->textInput() ?>
    <?= $form->field($model, 'iMotherWorkingAsID')->textInput() ?>
    <?= $form->field($model, 'nob')->textInput() ?>
    <?= $form->field($model, 'nos')->textInput() ?>
    <?= $form->field($model, 'eSameAddress')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>
    <?= $form->field($model, 'iCountryCAId')->textInput() ?>
    <?= $form->field($model, 'iStateCAId')->textInput() ?>
    <?= $form->field($model, 'iDistrictCAID')->textInput() ?>
    <?= $form->field($model, 'iTalukaCAID')->textInput() ?>
    <?= $form->field($model, 'vAreaNameCA')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'iCityCAId')->textInput() ?>
    <?= $form->field($model, 'vNativePlaceCA')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vParentsResiding')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vFamilyAffluenceLevel')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vFamilyType')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vFamilyProperty')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'vDetailRelative')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
