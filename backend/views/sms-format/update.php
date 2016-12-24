<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SmsFormat */

$this->title = 'Update Sms Format: ' . $model->vSmsFormatType;
$this->params['breadcrumbs'][] = ['label' => 'Sms Formats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vSmsFormatType, 'url' => ['view', 'id' => $model->iSmsFormatId]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <!--<h3 class="box-title">Quick Example</h3>-->
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">
        <div class="sms-format-update">


            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
