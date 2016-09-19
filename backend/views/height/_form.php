<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MasterHeight */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-height-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vName')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'eStatus')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
