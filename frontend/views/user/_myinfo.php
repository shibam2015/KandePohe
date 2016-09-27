<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-myinfo'],
        'options' => ['data-pjax' => true],
        'validateOnChange' => false,
        'validateOnSubmit' => true,
    ]);
    ?>
    <?= $form->errorSummary($model,['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
    <div class="box">
        <div class="small-col">
            <div class="required1"><!--<span class="text-danger">*</span>--></div>
        </div>
        <div class="mid-col">
            <div class="form-cont">
              <?= $form->field($model, 'tYourSelf',["template" => '<span class="input input--akira input--filled input-textarea">{input}<label class="input__label input__label--akira" for="input-22"><span class="input__label-content input__label-content--akira">Describe yourself in your own words</span> </label></span>'])->textArea(['rows' => '5','cols' => '50', 'class' => "input__field input__field--akira", 'id' => 'tYourSelf'])->error(false) ?>
            </div>
      </div>

    </div>
    <div class="row">
        <div class="">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
            <?= Html::submitButton('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_myinfo', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>

        </div>
    </div>
    <?php ActiveForm::end();
} else {
  ?>
    <p class="dis_my_info"><?= $model->tYourSelf; ?></p>
  <?php 
}
?>

<?php
  $this->registerJs('
    $("#form").on("submit",function(e){
      var tYourSelf = $("#tYourSelf").val();
      

      $(".error-field").removeClass("error-field");
      
      var error_flag = true;
      if(tYourSelf == ""){
        $("#tYourSelf").addClass("error-field");
        error_flag = false;
      }

      if(!error_flag){
         $("#top-error").show();
        return false;
      }
    });
  ');
  ?>

