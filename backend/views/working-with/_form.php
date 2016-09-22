<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WorkingWith */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="working-with-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vWorkingWithName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'eStatus')->dropDownList(['Active' => 'Active', 'Inactive' => 'Inactive',]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
