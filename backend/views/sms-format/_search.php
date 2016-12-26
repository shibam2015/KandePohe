<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SmsFormatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sms-format-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iSmsFormatId') ?>

    <?= $form->field($model, 'vSmsFormatType') ?>

    <?= $form->field($model, 'vSmsInformation') ?>

    <?= $form->field($model, 'vSmsMessage') ?>

    <?= $form->field($model, 'vComment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
