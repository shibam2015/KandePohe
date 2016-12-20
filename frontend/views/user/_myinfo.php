<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use common\components\MessageHelper;

if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-myinfo'],
        'options' => ['data-pjax' => true],
        'validateOnChange' => true,
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
        <div class="col-md-4 col-md-offset-2">
            <div class="form-cont">
                <div class="form-cont">
                    <input type="hidden" name="save" value="1">
                    <?= Html::submitButton('save', ['class' => 'btn btn-primary  my-profile-sc-button preferences_submit', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="form-cont">
                <div class="form-cont">
                    <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_info', 'name' => 'cancel']) ?>
                </div>
            </div>
        </div>

    </div>
    <?php ActiveForm::end();
} else {
  ?>
        <?php if ($model->tYourSelf != '') { ?>
            <?= $model->tYourSelf; ?>
        <?php } else { ?>

        <div class="notice kp_info"><p>Information Not Available.</p></div>
        <?php } ?>

    <?php
    if ($popup) {
        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'CHANGE_YOURSELF_DETAIL');
        $this->registerJs(' 
            notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
        ');
    }
    ?>
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
