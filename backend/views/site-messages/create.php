<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SiteMessages */

$this->title = 'Create Site Messages';
$this->params['breadcrumbs'][] = ['label' => 'Site Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="blood-group-create">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
