<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->First_Name." ".$model->Last_Name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//echo Yii::$app->urlManagerFrontend->baseUrl;
if($model->propic !='') {
    $PROPIC = "../../../frontend/web/uploads/users/" . $model->id . "/140_" . $model->propic;
}else{
    $PROPIC = "../../../frontend/web/images/placeholder.jpg";
}



?>


<!--<h1><?/*= Html::encode($this->title) */?></h1>-->
<div class="box box-primary">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="<?= $PROPIC ?>" alt="User profile picture">
        <!-- <?= Html::img(CommonHelper::getPhotos('USER', $model->id, $model->propic, 200), ['class' => 'profile-user-img img-responsive img-circle', 'width' => '200', 'height' => '200', 'alt' => 'User profile picture']); ?>
        -->
        <h3 class="profile-username text-center"><?php echo $this->title = ucwords($model->First_Name." ".$model->Last_Name); ?></h3>

        <p class="text-muted text-center">User</p>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'First_Name',
            'Last_Name',
            'email:email',
            'Mobile',
            'Profile_created_for',
            'Gender',
            'Age',
            'motherTongue.Name',
            'DOB',
            'Time_of_Birth',
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
                            'formatter' => [
                                'class' => 'yii\i18n\Formatter',
                                'nullDisplay' => '-',
                            ],
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
                            'formatter' => [
                                'class' => 'yii\i18n\Formatter',
                                'nullDisplay' => '-',
                            ],
                            'attributes' => [
                                //'fatherStatus.vName',
                                //'fatherStatusId.vWorkingAsName',
                                //'motherStatus.vName',
                                //'motherStatusId.vWorkingAsName',
                                'nob',
                                'NobM',
                                'nos',
                                'NosM',
                                'eSameAddress',
                                'countryNameCA.vCountryName',
                                'stateNameCA.vStateName',
                                'cityNameCA.vCityName',
                                'districtNameCA.vName',
                                'talukaNameCA.vName',
                                'vAreaNameCA:ntext',
                                'vNativePlaceCA:ntext',
                                'vParentsResiding:ntext',
                                'familyAffluenceLevelName.Name',
                                'vFamilyType:ntext',
                                [
                                    'attribute' => 'familyPropertyName',
                                    'value' => CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue(\common\models\PropertyDetails::getPropertyDetails(CommonHelper::removeComma($model->vFamilyProperty)), 'Name'), 'text')
                                ],
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
                            'formatter' => [
                                'class' => 'yii\i18n\Formatter',
                                'nullDisplay' => '-',
                            ],
                            'attributes' => [
                                'height.vName',
                                'vSkinTone:ntext',
                                'vBodyType:ntext',
                                'vSmoke:ntext',
                                'vDrink:ntext',
                                'vSpectaclesLens:ntext',
                                'dietName.vName',
                                'weight'
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
                    <h3 class="box-title">Horoscope Detail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="text-muted">
                        <?= DetailView::widget([
                            'model' => $model,
                            'formatter' => [
                                'class' => 'yii\i18n\Formatter',
                                'nullDisplay' => '-',
                            ],
                            'attributes' => [
                                'raashiName.Name',
                                'nakshtraName.Name',
                                'gotraName.vName',
                                'charanName.Name',
                                'nadiName.Name',
                                'ganName.Name',
                                'Mangalik:ntext'

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
                    <h3 class="box-title">Hobby/Interest</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="text-muted">
                        <?= DetailView::widget([
                            'model' => $model,
                            'formatter' => [
                                'class' => 'yii\i18n\Formatter',
                                'nullDisplay' => '-',
                            ],
                            'attributes' => [
                                //'interestName.Name',
                                [
                                    'attribute' => 'interestName',
                                    'value' => CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue(\common\models\Interests::getInterestNames(CommonHelper::removeComma($model->InterestID)), 'Name'), 'text')
                                ],
                                [                      //  the owner name of the model
                                    'attribute' => 'favouriteReadsName',
                                    'value' => CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue(\common\models\FavouriteReads::getReadsNames(CommonHelper::removeComma($model->FavioriteReadID)), 'Name'), 'text')
                                ],
                                [                      //  the owner name of the model
                                    'attribute' => 'favouriteMusicName',
                                    'value' => CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue(\common\models\FavouriteMusic::getMusicNames(CommonHelper::removeComma($model->FaviouriteMusicID)), 'Name'), 'text')
                                ],
                                [                      //  the owner name of the model
                                    'attribute' => 'favouriteCousinesName',
                                    'value' => CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue(\common\models\FavouriteCousines::getCousinesNames(CommonHelper::removeComma($model->FavouriteCousinesID)), 'Name'), 'text')
                                ],
                                [                      //  the owner name of the model
                                    'attribute' => 'sportsFittnessName',
                                    'value' => CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue(\common\models\SportsFitnActivities::getSportsNames(CommonHelper::removeComma($model->SportsFittnessID)), 'Name'), 'text')
                                ],
                                [                      //  the owner name of the model
                                    'attribute' => 'preferredDressStyleName',
                                    'value' => CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue(\common\models\PreferredDressStyle::getDressNames(CommonHelper::removeComma($model->PreferredDressID)), 'Name'), 'text')
                                ],
                                [                      //  the owner name of the model
                                    'attribute' => 'preferredMoviesName',
                                    'value' => CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue(\common\models\PreferredMovies::getMovieNames(CommonHelper::removeComma($model->PreferredMovieID)), 'Name'), 'text')
                                ],
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
