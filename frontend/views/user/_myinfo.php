<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
Pjax::begin(); 

if($form == true){

$form = ActiveForm::begin([
    'id' => 'form',
    'action' => ['edit-myinfo'],
    'enableClientValidation'=> true,
    'enableAjaxValidation'=> false,
    'options' => ['data-pjax' => true]
]);
?>
  <div class="box">
  <div class="small-col">
      <div class="required1"><!--<span class="text-danger">*</span>--></div>
    </div>
    <div class="mid-col">
      <div class="form-cont">

        <span class="input input--akira input--filled input-textarea">

          <textarea class="input__field input__field--akira" cols="50" rows="5" name="User[tYourSelf]" ><?= ($model->tYourSelf)?></textarea>
          <label class="input__label input__label--akira" for="input-22">
            <span class="input__label-content input__label-content--akira">Describe yourself in your own words</span> </label>
        </span>
      </div>
    </div>
    
  </div>
  <div class="row">
    <div class="">
      <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5','style' => 'padding:5px;font-size:14px;']) ?>
                      
      </div>
  </div>
<?php ActiveForm::end(); ?>

<? } else{
  ?>
  <p><?= $model->tYourSelf; ?></p>
  <?php 
}
Pjax::end(); ?>