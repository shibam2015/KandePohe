<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = 'Update Admin: ' . $model->iAdminId;
$this->title = ucwords($model->vFirstName." ".$model->vLastName);
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->iAdminId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-primary">
            <div class="box-header with-border">
              <!--<h3 class="box-title">Quick Example</h3>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
            <div class="box-body">
				<div class="admin-update">

    			<!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    			<?= $this->render('_form', [
        		'model' => $model,
    			]) ?>

			</div>
		</div>
 </div>
