<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SiteMessages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-messages-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'id')->textInput() ?>-->

    <?= $form->field($model, 'message_action')->textInput(['readonly' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'message_type')->dropDownList(['S' => 'SUCCESS', 'E' => 'ERROR', 'I' => 'INFORMATION', 'T' => 'TITLE',]) ?>

    <?= $form->field($model, 'message_value')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'Subject')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
