<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Religion */

$this->title = 'Create Religion';
$this->params['breadcrumbs'][] = ['label' => 'Religions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="religion-create">
            <!--<h1><?= Html::encode($this->title) ?></h1>-->
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>