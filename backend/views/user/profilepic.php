<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use common\components\CommonHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->First_Name." ".$model->Last_Name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//echo Yii::$app->urlManagerFrontend->baseUrl;
if ($model->propic != '') {
    $PROPIC = CommonHelper::getPhotosBackend('USER', $model->id, "200" . $model->propic, 200, '', 'Yes', 1);
} else {
    $PROPIC = CommonHelper::getPhotosBackend('USER', $model->id, "200" . '', 200, '', 'Yes', 2);
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
            'Mobile',
            'Profile_created_for',

            'Gender',
            'DOB',
            'Time_of_Birth',
            'eStatusPhotoModify',

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
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">User Profile Photo</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body ">
                    <?php
                    if (count($PHOTO_LIST) > 0) {
                        foreach ($PHOTO_LIST as $K => $V) {
                            ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php //$PROPIC = CommonHelper::getPhotosBackend('USER', $model->id, "200" . $model->propic, 200, '', 'Yes',1);?>

                                            <?php if ($V['Is_Profile_Photo'] == 'YES') { ?>
                                                <?= Html::img(CommonHelper::getPhotosBackend('USER', $model->id, "200" . $model->propic, 200, '', 'Yes', 1), ['class' => 'img-responsive ', 'height' => '140', 'alt' => 'Photo' . $K]); ?>
                                                <span class="btn btn-block btn-success">
                                            Profile Photo
                                            </span>
                                            <?php } else { ?>
                                                <?= Html::img(CommonHelper::getPhotosBackend('USER', $model->id, Yii::$app->params['thumbnailPrefix'] . "200_" . $V['File_Name'], 200, '', 'No', 1), ['class' => 'img-responsive ', 'height' => '140', 'alt' => 'Photo' . $K]); ?>
                                            <?php } ?>

                                        </div>
                                        <div class="col-md-3">
                                            <?php if ($V['eStatus'] == 'Approve') { ?>
                                                <span class="btn btn-block btn-success">
                                        Approve
                                    </span>
                                            <?php } else if ($V['eStatus'] == 'Disapprove') { ?>
                                                <span class="btn btn-block btn-danger">
                                        Disapprove
                                    </span>
                                            <?php } else { ?>
                                                <span class="btn btn-block btn-warning">
                                        Pending
                                    </span>
                                            <?php } ?>
                                        </div>
                            </div>
                            <div class="col-md-6">
                                <?php $form = ActiveForm::begin(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'commentAdmin')->textArea(['rows' => '6', 'cols' => '50']) ?>
                                        <input type="hidden" name="User[iPhoto_ID]" value="<?= $V->iPhoto_ID ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <?= Html::submitButton('Approve', ['class' => 'btn btn-block btn-success', 'name' => 'submit', 'value' => 'Approve']) ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?= Html::submitButton('Disapprove', ['class' => 'btn btn-block btn-danger', 'name' => 'submit', 'value' => 'Disapprove']) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                            </div>

                        <?php }
                    } else {
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <p> No Photos Available</p>
                        </div>
                    <?php } ?>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
