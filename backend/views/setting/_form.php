<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'id')->textInput() ?>-->

    <?= $form->field($model, 'SettingName')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'UseFor')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'SettingValue')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'eStatus')->dropDownList(['Active' => 'Active', 'Inactive' => 'Inactive',], ['prompt' => '']) ?>

    <?= $form->field($model, 'ConfigType')->dropDownList(['SMS' => 'SMS', 'Payment' => 'Payment', 'Appereance' => 'Appereance',], ['prompt' => '']) ?>

    <?= $form->field($model, 'ElemetType')->dropDownList(['Inputbox' => 'Inputbox', 'Textbox' => 'Textbox', 'Radiobutton' => 'Radiobutton', 'Checkbox' => 'Checkbox',], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
