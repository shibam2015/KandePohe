<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->First_Name." ".$model->Last_Name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
#echo Yii::$app->urlManagerFrontend->baseUrl;
if($model->propic !='') {
    $PROPIC = "../../../frontend/web/uploads/" . $model->propic;
}else{
    $PROPIC = "../../../frontend/web/images/placeholder.jpg";
}
?>
<div class="user-view">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <p>
       <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this User?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        #    'id',
        #    'auth_key',
        #    'password_hash',
        #    'password_reset_token',
            'First_Name',
            'Last_Name',
            'email:email',
            'status',

            'created_at',
            'updated_at',
        #    'Registration_Number',
            'Mobile',
            'Profile_created_for',

            'Gender',
            'DOB',
            'Time_of_Birth',
            #'Age',
            'Birth_Place',
            #'Marital_Status',
            #'iReligion_ID',
            #'iEducationLevelID',
            #'iEducationFieldID',
            #'iWorkingWithID',
            #'iWorkingAsID',
            #'iAnnualIncomeID',

            'religionName.vName',
            'educationLevelName.vEducationLevelName',
            'educationFieldName.vEducationFieldName',
            'workingWithName.vWorkingWithName',
            'workingAsName.vWorkingAsName',
            'annualIncome.vAnnualIncome',

            'county_code',
            #'iCommunity_ID',
            #'iSubCommunity_ID',
            #'iDistrictID',
            #'iGotraID',
            #'iMaritalStatusID',
            #'iTalukaID',
            #'iCountryId',
            #'iStateId',
            #'iCityId',

            'communityName.vName',
            'subCommunityName.vName',
            'districtName.vName',
            'gotraName.vName',
            'maritalStatusName.vName',
            'talukaName.vName',


            'countryName.vCountryName',
            'stateName.vStateName',
            'cityName.vCityName',
            'noc',
            'vAreaName:ntext',
            'cnb',
            #'iHeightID',
            'height.vName',
            'vSkinTone:ntext',
            'vBodyType:ntext',
            'vSmoke:ntext',
            'vDrink:ntext',
            'vSpectaclesLens:ntext',
            'vDiet:ntext',
            'dietName.vName',
            'tYourSelf:ntext',
            'vDisability:ntext',
            'propic:ntext',
            [
                'attribute'=>'photo',
                #'value'=>$model->propic,
                'value'=>$PROPIC,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],
            'pin_email_vaerification:ntext',
            'iFatherStatusID',
            'fatherStatus.vName',

            'iMotherStatusID',
            'iFatherWorkingAsID',
            'iMotherWorkingAsID',
            'nob',
            'nos',
            'eSameAddress',
            'countryNameCA.vCountryName',
            'stateNameCA.vStateName',
            'cityNameCA.vCityName',
            'cityNameCA.vCityName',
            'districtNameCA.vName',
            'talukaNameCA.vName',
            'vAreaNameCA:ntext',
            #'iDistrictCAID',
            #'iTalukaCAID',

            #'iCityCAId',
            #'vNativePlaceCA:ntext',
            'vParentsResiding:ntext',
            'vFamilyAffluenceLevel:ntext',
            'vFamilyType:ntext',
            'vFamilyProperty:ntext',
            'vDetailRelative:ntext',
            'completed_step',
            'eEmailVerifiedStatus:email',
            'ePhoneVerifiedStatus',
            'eFirstVerificationMailStatus',
            #'toc',
        ],
    ]) ?>

</div>


