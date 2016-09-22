<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BloodGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blood-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'created_on')->textInput() ?>

    <?= $form->field($model, 'modified_on')->textInput() ?>
-->
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
