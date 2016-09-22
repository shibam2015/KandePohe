<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MasterHeight */

$this->title = 'Update Height: ' . $model->vName;
$this->params['breadcrumbs'][] = ['label' => 'Heights', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iHeightID, 'url' => ['view', 'id' => $model->iHeightID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-primary">
            <div class="box-header with-border">
              <!--<h3 class="box-title">Quick Example</h3>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body">
				<div class="master-height-update">

				    <h1><?= Html::encode($this->title) ?></h1>

				    <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>

				</div>
			</div>
</div>
