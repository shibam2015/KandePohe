<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmailFormatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-format-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iEmailFormatId') ?>

    <?= $form->field($model, 'vEmailFormatTitle') ?>

    <?= $form->field($model, 'vEmailFormatType') ?>

    <?= $form->field($model, 'vEmailFormatSubject') ?>

    <?= $form->field($model, 'tEmailFormatDesc') ?>

    <?php // echo $form->field($model, 'vDescriptionDisplay') ?>

    <?php // echo $form->field($model, 'vTags') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
