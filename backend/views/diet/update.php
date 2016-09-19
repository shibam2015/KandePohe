<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MasterDiet */

$this->title = 'Update Diet: ' . $model->vName;
$this->params['breadcrumbs'][] = ['label' => 'Diets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iDietID, 'url' => ['view', 'id' => $model->iDietID]];
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
				<div class="master-diet-update">

				    <!--<h1><?= Html::encode($this->title) ?></h1>-->

				    <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>

				</div>
			</div>
</div>
