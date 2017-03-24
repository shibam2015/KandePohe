<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SiteCms */

$this->title = 'Update Site Cms: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Site Cms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="box box-primary">

    <div class="box-body">

        <div class="blood-group-create">

            <!--<h1><? /*= Html::encode($this->title) */ ?></h1>-->

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
