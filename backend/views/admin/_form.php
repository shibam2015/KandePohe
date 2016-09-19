<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vFirstName')->input(['rows' => 6]) ?>

    <?= $form->field($model, 'vLastName')->input(['rows' => 6]) ?>

    <?= $form->field($model, 'vEmail')->input(['rows' => 6]) ?>

    <?= $form->field($model, 'vPassword')->input(['rows' => 6]) ?>

    <?= $form->field($model, 'eStatus')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
