<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WorkingWith */

$this->title = $model->vWorkingWithName;
$this->params['breadcrumbs'][] = ['label' => 'Working Withs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vWorkingWithName, 'url' => ['view', 'id' => $model->iWorkingWithID]];
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
