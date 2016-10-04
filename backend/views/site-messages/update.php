<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SiteMessages */

$this->title = $model->message_action;
$this->params['breadcrumbs'][] = ['label' => 'Site Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->message_action, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="blood-group-update">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
