<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BloodGroup */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Charan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Name, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="blood-group-update">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
