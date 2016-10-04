<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */

$this->title = $model->SettingName;
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body box-profile">
        <!--<img class="profile-user-img img-responsive img-circle" src="<?= Yii::getAlias('@web') . '/images/' ?>default.png" alt="User profile picture">-->

        <h3 class="profile-username text-center"><?php echo $this->title = ucwords($model->SettingName); ?></h3>

        <p class="text-muted text-center">SMS Setting</p>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'id',
            'SettingName:ntext',
            'UseFor:ntext',
            'SettingValue:ntext',
            'eStatus',
            'ConfigType',
            'ElemetType',
        ],
    ]) ?>
    <div class="row">
        <div class="col-md-6">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-block btn-primary']) ?>
        </div>
        <div class="col-md-6">
            <?= Html::a('Delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-block',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>

    </div>


    <!-- /.box-body -->
</div>



