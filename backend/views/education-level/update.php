<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EducationLevel */

$this->title = $model->vEducationLevelName;
$this->params['breadcrumbs'][] = ['label' => 'Education Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vEducationLevelName, 'url' => ['view', 'id' => $model->iEducationLevelID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <!--<h3 class="box-title">Quick Example</h3>-->
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">

        <div class="education-level-update">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
