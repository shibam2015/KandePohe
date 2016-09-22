<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MasterCommunitySub */

$this->title = 'Create Sub Community';
$this->params['breadcrumbs'][] = ['label' => 'Sub Community', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
            <div class="box-header with-border">
              <!--<h3 class="box-title">Quick Example</h3>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
            <div class="box-body">
				<div class="master-community-sub-create">

				    <h1><?= Html::encode($this->title) ?></h1>

				    <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>

				</div>
			</div>
</div>
