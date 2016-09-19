<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MasterDistrict */

$this->title = $model->iDistrictID;
$this->params['breadcrumbs'][] = ['label' => 'Districts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
            <div class="box-body box-profile">
              <!--<img class="profile-user-img img-responsive img-circle" src="<?=Yii::getAlias('@web').'/images/'?>default.png" alt="User profile picture">-->

              <h3 class="profile-username text-center"><?php echo $this->title = ucwords($model->vName); ?></h3>

              <p class="text-muted text-center">District</p>
             </div>

               <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'iDistrictID',
            'vName',
            'eStatus',
        ],
    ]) ?>
        
             <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
             <div class="row">
                <div class="col-md-6">
                     <?= Html::a('Update', ['update', 'id' => $model->iDistrictID], ['class' => 'btn btn-block btn-primary']) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::a('Delete', ['delete', 'id' => $model->iDistrictID], ['class' => 'btn btn-danger btn-block',
                    'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                     ],
                    ]) ?>
                </div>
    
              </div>
            
            
            
            <!-- /.box-body -->
</div>

