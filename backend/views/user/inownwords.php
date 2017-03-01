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
$PROPIC = CommonHelper::getPhotosBackend('USER', $model->id, "200" . $model->propic, 200, '', 'Yes', 1);
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
            'eStatusInOwnWord',

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
                <div class="box-header with-border">
                    <!--<h3 class="box-title">About Yourself</h3>-->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="text-muted">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'tYourSelf:html',    // description attribute in HTML
                            ],
                        ]) ?>
                    </p>
                    <!--<div class="row">
                        <div class="col-md-6">
                            <?= Html::a('Approve', ['approve', 'id' => $model->id], ['class' => 'btn btn-block btn-success']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= Html::a('Disapprove', ['disapprove', 'id' => $model->id], ['class' => 'btn btn-danger btn-block',
                                'data' => [
                                    'confirm' => 'Are you sure you want to disapprove this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>

                    </div>-->
                    <?php $form = ActiveForm::begin(); ?>



                        <div class="row">
                            <div class="col-md-12">
                            <?= $form->field($model, 'commentInOwnWordsAdmin')->textArea(['rows' => '6','cols'=>'50']) ?>
                            </div>
                            </div>
                        <div class="row">
                            <div class="col-md-6">

                            <?= Html::submitButton('Approve', ['class' => 'btn btn-block btn-success','name'=>'submit', 'value'=>'APPROVE']) ?>
                            </div>
                                <div class="col-md-6">
                        <?= Html::submitButton('Disapprove', ['class' => 'btn btn-block btn-danger' ,'name'=>'submit', 'value'=>'DISAPPROVE']) ?>
                            </div>


                        </div>


                    <?php ActiveForm::end(); ?>


                </div>
                <!-- /.box-body -->
            </div>
        </div>

    </div>

</div>
<div class="user-view">
</div>
