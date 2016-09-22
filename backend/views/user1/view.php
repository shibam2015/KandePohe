<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->First_Name." ".$model->Last_Name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//echo Yii::$app->urlManagerFrontend->baseUrl;
if($model->propic !='') {
    $PROPIC = "../../../frontend/web/uploads/" . $model->propic;
}else{
    $PROPIC = "../../../frontend/web/images/placeholder.jpg";
}



?>


<!--<h1><?/*= Html::encode($this->title) */?></h1>-->
<div class="box box-primary">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="<?=$PROPIC?>" alt="User profile picture">

        <h3 class="profile-username text-center"><?php echo $this->title = ucwords($model->First_Name." ".$model->Last_Name); ?></h3>

        <p class="text-muted text-center">User</p>
    </div>

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
            #'status',

            #'created_at',
            #'updated_at',
            #    'Registration_Number',
            'Mobile',
            'Profile_created_for',

            'Gender',
            'DOB',
            'Time_of_Birth',
            #'Age',
            #'Birth_Place',
            #'Marital_Status',
            #'iReligion_ID',
            #'iEducationLevelID',
            #'iEducationFieldID',
            #'iWorkingWithID',
            #'iWorkingAsID',
            #'iAnnualIncomeID',

            #'religionName.vName',
            #'educationLevelName.vEducationLevelName',
            #'educationFieldName.vEducationFieldName',
            #'workingWithName.vWorkingWithName',
            #'workingAsName.vWorkingAsName',
            #'annualIncome.vAnnualIncome',

            #'county_code',
            #'iCommunity_ID',
            #'iSubCommunity_ID',
            #'iDistrictID',
            #'iGotraID',
            #'iMaritalStatusID',
            #'iTalukaID',
            #'iCountryId',
            #'iStateId',
            #'iCityId',

            #'communityName.vName',
            #'subCommunityName.vName',
            #'districtName.vName',
            #'gotraName.vName',
            #'maritalStatusName.vName',
            #'talukaName.vName',


            #'countryName.vCountryName',
            #'stateName.vStateName',
            #'cityName.vCityName',
            #'noc',
            #'vAreaName:ntext',
            #'cnb',
            #'iHeightID',
            #'height.vName',
            #'vSkinTone:ntext',
            #'vBodyType:ntext',
            #'vSmoke:ntext',
            #'vDrink:ntext',
            #'vSpectaclesLens:ntext',
            #'vDiet:ntext',
            #'dietName.vName',
            #'tYourSelf:ntext',
            #'vDisability:ntext',

            #'propic:ntext',

            #'pin_email_vaerification:ntext',
            #'iFatherStatusID',
            ###'iMotherStatusID',
            ###'iFatherWorkingAsID',
            ####'iMotherWorkingAsID',
            ###'nob',
            ##'nos',
            #'eSameAddress',
            #'countryNameCA.vCountryName',
            #'stateNameCA.vStateName',
            #'cityNameCA.vCityName',
            #'cityNameCA.vCityName',
            ##'districtNameCA.vName',
            #'talukaNameCA.vName',
            #'vAreaNameCA:ntext',
            #'iDistrictCAID',
            #'iTalukaCAID',

            #'iCityCAId',
            #'vNativePlaceCA:ntext',
            ##'vParentsResiding:ntext',
            #'vFamilyAffluenceLevel:ntext',
            #'vFamilyType:ntext',
            #'vFamilyProperty:ntext',
            #'vDetailRelative:ntext',
            ##'eEmailVerifiedStatus:email',
            #'ePhoneVerifiedStatus',
            #'eFirstVerificationMailStatus',
            #'toc',
        ],
    ]) ?>
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
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Basic Detail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">


                    <p class="text-muted">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'religionName.vName',
                                'communityName.vName',
                                'subCommunityName.vName',
                                'maritalStatusName.vName',
                                'gotraName.vName',
                                'countryName.vCountryName',
                                'stateName.vStateName',
                                'cityName.vCityName',
                                'districtName.vName',
                                'talukaName.vName',
                                'vAreaName:ntext',
                            ],
                        ]) ?>
                    </p>

                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Education & Occupation</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="text-muted">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'educationLevelName.vEducationLevelName',
                                'educationFieldName.vEducationFieldName',
                                'workingWithName.vWorkingWithName',
                                'workingAsName.vWorkingAsName',
                                'annualIncome.vAnnualIncome',
                            ],
                        ]) ?>
                    </p>
                </div>
                <!-- /.box-body -->
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Family Detail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="text-muted">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                #'iFatherStatusID',
                                #'iMotherStatusID',
                                #'iFatherWorkingAsID',
                                #'iMotherWorkingAsID',
                                'nob',
                                'nos',
                                'eSameAddress',
                                'countryNameCA.vCountryName',
                                'stateNameCA.vStateName',
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
                            ],
                        ]) ?>
                    </p>


                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lifestyle</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="text-muted">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'height.vName',
                                'vSkinTone:ntext',
                                'vBodyType:ntext',
                                'vSmoke:ntext',
                                'vDrink:ntext',
                                'vSpectaclesLens:ntext',

                                'dietName.vName',
                            ],
                        ]) ?>
                    </p>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

    </div>

</div>
<div class="user-view">
</div>
