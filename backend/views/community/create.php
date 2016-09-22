<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MasterCommunity */

$this->title = 'Create Community';
$this->params['breadcrumbs'][] = ['label' => 'Community', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
            <div class="box-header with-border">
              <!--<h3 class="box-title">Quick Example</h3>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body">
                <div class="master-community-create">
				
				 <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>


				</div>
 			</div>
 </div>
