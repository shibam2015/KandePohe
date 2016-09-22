<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EmailFormat */

$this->title = $model->vEmailFormatTitle;
$this->params['breadcrumbs'][] = ['label' => 'Email Format', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vEmailFormatTitle, 'url' => ['view', 'id' => $model->iEmailFormatId]];
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
