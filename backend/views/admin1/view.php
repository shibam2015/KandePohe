<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = ucwords($model->vFirstName." ".$model->vLastName);
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?=Yii::getAlias('@web').'/images/'?>default.png" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $this->title = ucwords($model->vFirstName." ".$model->vLastName); ?></h3>

              <p class="text-muted text-center">Admin</p>
             </div>

              <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'iAdminId',
            'vFirstName:ntext',
            'vLastName:ntext',
            'vEmail:ntext',
            #'vPassword:ntext',
            'eStatus',
            ],
              ]) ?>

             <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
             <div class="row">
                <div class="col-md-6">
                     <?= Html::a('Update', ['update', 'id' => $model->iAdminId], ['class' => 'btn btn-block btn-primary']) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::a('Delete', ['delete', 'id' => $model->iAdminId], ['class' => 'btn btn-danger btn-block',
                    'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                     ],
                    ]) ?>
                </div>
    
              </div>
            
            
            
            <!-- /.box-body -->
</div>
       
<div class="admin-view">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

  <!--  <p>
        <?= Html::a('Update', ['update', 'id' => $model->iAdminId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->iAdminId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>-->
        
  <!--  <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'iAdminId',
            'vFirstName:ntext',
            'vLastName:ntext',
            'vEmail:ntext',
            #'vPassword:ntext',
            'eStatus',
        ],
    ]) ?>-->

</div>
