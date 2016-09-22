<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EducationField */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="education-field-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vEducationFieldName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(['Active' => 'Active', 'Inactive' => 'Inactive',]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
