<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SiteCms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-cms-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <? /*= $form->field($model, 'type')->textInput(['maxlength' => true]) */ ?> -->

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>
<!--<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>-->
<?php
$this->registerJs('$(function(){
                    CKEDITOR.replace("sitecms-description");
});
');
?>
