<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MasterCommunity */

$this->title = 'Update Community: ' . $model->vName;
$this->params['breadcrumbs'][] = ['label' => 'Community', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iCommunity_ID, 'url' => ['view', 'id' => $model->iCommunity_ID]];
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
				<div class="master-community-update">

				    <!--<h1><?= Html::encode($this->title) ?></h1>-->

				    <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>


			</div>
 			</div>
 </div>
