<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\States */

$this->title = 'Update States: ' . $model->iStateId;
$this->params['breadcrumbs'][] = ['label' => 'States', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iStateId, 'url' => ['view', 'id' => $model->iStateId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="states-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
