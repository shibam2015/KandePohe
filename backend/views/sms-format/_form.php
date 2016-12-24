<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SmsFormat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sms-format-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'vSmsFormatType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vSmsInformation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vSmsMessage')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vComment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
