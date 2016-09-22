<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmailFormat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-format-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'iEmailFormatId')->textInput() ?>-->

    <?= $form->field($model, 'vEmailFormatTitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vEmailFormatType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vEmailFormatSubject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tEmailFormatDesc')->textarea(['rows' => 6]) ?>

    <!--<?= $form->field($model, 'vDescriptionDisplay')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vTags')->textarea(['rows' => 6]) ?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<?php
$this->registerJs('$(function(){
                    CKEDITOR.replace("emailformat-temailformatdesc");
});
');
?>


<!-- Bootstrap WYSIHTML5 -->

<!--<script>
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
    });
</script>-->
