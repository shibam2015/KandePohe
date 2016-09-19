<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Wightege */

$this->title = $model->vWightegeName;
$this->params['breadcrumbs'][] = ['label' => 'Wighteges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vWightegeName, 'url' => ['view', 'id' => $model->iWightege]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-primary">
            <div class="box-header with-border">
              <!--<h3 class="box-title">Quick Example</h3>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
            <div class="box-body">
				<div class="wightege-update">

    			<!--<h1><?= Html::encode($this->title) ?></h1>-->

    			<?= $this->render('_form', [
        		'model' => $model,
    			]) ?>


				</div>
 			</div>
 </div>

