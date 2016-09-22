<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EducationField */

$this->title = $model->iEducationFieldID;
$this->params['breadcrumbs'][] = ['label' => 'Education Name', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-body box-profile">

        <h3 class="profile-username text-center"><?php echo $this->title = ucwords($model->vEducationFieldName); ?></h3>

        <p class="text-muted text-center">Education Name</p>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'iEducationFieldID',
            'vEducationFieldName',
            'status',
        ],
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= Html::a('Update', ['update', 'id' => $model->iEducationFieldID], ['class' => 'btn btn-block btn-primary']) ?>
        </div>
        <div class="col-md-6">
            <?= Html::a('Delete', ['delete', 'id' => $model->iEducationFieldID], ['class' => 'btn btn-danger btn-block',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>

    </div>


    <!-- /.box-body -->
</div>
