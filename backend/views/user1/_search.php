<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'auth_key') ?>

    <?= $form->field($model, 'password_hash') ?>

    <?= $form->field($model, 'password_reset_token') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'Registration_Number') ?>

    <?php // echo $form->field($model, 'Mobile') ?>

    <?php // echo $form->field($model, 'Profile_created_for') ?>

    <?php // echo $form->field($model, 'First_Name') ?>

    <?php // echo $form->field($model, 'Last_Name') ?>

    <?php // echo $form->field($model, 'Gender') ?>

    <?php // echo $form->field($model, 'DOB') ?>

    <?php // echo $form->field($model, 'Time_of_Birth') ?>

    <?php // echo $form->field($model, 'Age') ?>

    <?php // echo $form->field($model, 'Birth_Place') ?>

    <?php // echo $form->field($model, 'Marital_Status') ?>

    <?php // echo $form->field($model, 'iReligion_ID') ?>

    <?php // echo $form->field($model, 'eFirstVerificationMailStatus') ?>

    <?php // echo $form->field($model, 'iEducationLevelID') ?>

    <?php // echo $form->field($model, 'iEducationFieldID') ?>

    <?php // echo $form->field($model, 'iWorkingWithID') ?>

    <?php // echo $form->field($model, 'iWorkingAsID') ?>

    <?php // echo $form->field($model, 'iAnnualIncomeID') ?>

    <?php // echo $form->field($model, 'iCommunity_ID') ?>

    <?php // echo $form->field($model, 'toc') ?>

    <?php // echo $form->field($model, 'county_code') ?>

    <?php // echo $form->field($model, 'iSubCommunity_ID') ?>

    <?php // echo $form->field($model, 'iDistrictID') ?>

    <?php // echo $form->field($model, 'iGotraID') ?>

    <?php // echo $form->field($model, 'iMaritalStatusID') ?>

    <?php // echo $form->field($model, 'iTalukaID') ?>

    <?php // echo $form->field($model, 'iCountryId') ?>

    <?php // echo $form->field($model, 'iStateId') ?>

    <?php // echo $form->field($model, 'iCityId') ?>

    <?php // echo $form->field($model, 'noc') ?>

    <?php // echo $form->field($model, 'vAreaName') ?>

    <?php // echo $form->field($model, 'cnb') ?>

    <?php // echo $form->field($model, 'iHeightID') ?>

    <?php // echo $form->field($model, 'vSkinTone') ?>

    <?php // echo $form->field($model, 'vBodyType') ?>

    <?php // echo $form->field($model, 'vSmoke') ?>

    <?php // echo $form->field($model, 'vDrink') ?>

    <?php // echo $form->field($model, 'vSpectaclesLens') ?>

    <?php // echo $form->field($model, 'vDiet') ?>

    <?php // echo $form->field($model, 'tYourSelf') ?>

    <?php // echo $form->field($model, 'vDisability') ?>

    <?php // echo $form->field($model, 'propic') ?>

    <?php // echo $form->field($model, 'pin_email_vaerification') ?>

    <?php // echo $form->field($model, 'iFatherStatusID') ?>

    <?php // echo $form->field($model, 'iMotherStatusID') ?>

    <?php // echo $form->field($model, 'iFatherWorkingAsID') ?>

    <?php // echo $form->field($model, 'iMotherWorkingAsID') ?>

    <?php // echo $form->field($model, 'nob') ?>

    <?php // echo $form->field($model, 'nos') ?>

    <?php // echo $form->field($model, 'eSameAddress') ?>

    <?php // echo $form->field($model, 'iCountryCAId') ?>

    <?php // echo $form->field($model, 'iStateCAId') ?>

    <?php // echo $form->field($model, 'iDistrictCAID') ?>

    <?php // echo $form->field($model, 'iTalukaCAID') ?>

    <?php // echo $form->field($model, 'vAreaNameCA') ?>

    <?php // echo $form->field($model, 'iCityCAId') ?>

    <?php // echo $form->field($model, 'vNativePlaceCA') ?>

    <?php // echo $form->field($model, 'vParentsResiding') ?>

    <?php // echo $form->field($model, 'vFamilyAffluenceLevel') ?>

    <?php // echo $form->field($model, 'vFamilyType') ?>

    <?php // echo $form->field($model, 'vFamilyProperty') ?>

    <?php // echo $form->field($model, 'vDetailRelative') ?>

    <?php // echo $form->field($model, 'completed_step') ?>

    <?php // echo $form->field($model, 'eEmailVerifiedStatus') ?>

    <?php // echo $form->field($model, 'ePhoneVerifiedStatus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
