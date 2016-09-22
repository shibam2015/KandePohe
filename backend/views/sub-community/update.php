<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MasterCommunitySub */

$this->title = 'Update Sub Community: ' . $model->vName;
$this->params['breadcrumbs'][] = ['label' => 'Sub Community', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iSubCommunity_ID, 'url' => ['view', 'id' => $model->iSubCommunity_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-primary">
            <div class="box-header with-border">
              <!--<h3 class="box-title">Quick Example</h3>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
            <div class="box-body">
				<div class="master-community-sub-update">

				    <h1><?= Html::encode($this->title) ?></h1>

				    <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>

				</div>
			</div>
</div>
