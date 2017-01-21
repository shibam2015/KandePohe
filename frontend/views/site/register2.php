<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
?>

<?php
echo $this->render('/layouts/parts/_headerregister.php');
?>
<main>
  <div class="container-fluid">
    <div class="row no-gutter bg-dark">
      <?php
      echo $this->render('/layouts/parts/_leftsidebarregister.php', ['CurrentStep' => $CurrentStep]);
      ?>
      <div class="col-sm-9">
        <div class="right-column"> <span class="welcome-note">
            <?php
            if ($model->Profile_created_for !== "SELF") {
              ?>
              <p>Add <strong><?= $model->First_Name; ?>'s,</strong> educational and occupational details to help us
                build a good profile…</p>
            <?php } else {
              ?>
              <p><strong><?= $model->First_Name; ?> ,</strong> add your educational and occupational details to help us
                build a good profile…</p>
            <?php } ?>
          </span>
          <div class="row no-gutter">
            <div class="col-lg-8 col-md-12 col-sm-12">
              <div class="white-section mrg-tp-20 mrg-bt-10">
                <h3>Educational & Occupational</h3>
                <p><span class="text-danger">*</span> marked fields are mandatory</p>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'form-register2',
                  //'action' => ['/site/register'],
                  //'enableClientValidation'=> true,
                  //'enableAjaxValidation'=> false,
                  // 'validateOnSubmit' => false,
                    'validateOnChange' => false,

                ]);
                ?>
                <?= $form->errorSummary($model, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iEducationLevelID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getEducationLevel(), 'iEducationLevelID', 'vEducationLevelName'),
                          ['class' => 'demo-default select-beast',
                              'prompt' => 'Education Level'
                          ]

                      )->label(false)->error(false); ?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right"
                       title="Mention Your Education Level"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iEducationFieldID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getEducationField(), 'iEducationFieldID', 'vEducationFieldName'),
                          ['class' => 'demo-default select-beast',
                              'prompt' => 'Education Field'
                          ]

                      )->label(false)->error(false); ?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right"
                       title="Mention Your Education Fields"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iWorkingWithID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getWorkingWith(), 'iWorkingWithID', 'vWorkingWithName'),
                          ['class' => 'demo-default select-beast',
                              'prompt' => 'Working with'
                          ]

                      )->label(false)->error(false); ?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right"
                       title="Mention Your Working with"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iWorkingAsID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getWorkingAS(), 'iWorkingAsID', 'vWorkingAsName'),
                          ['class' => 'demo-default select-beast',
                              'prompt' => 'Working As'
                          ]

                      )->label(false)->error(false); ?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right"
                       title="Mention Your Designation"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iAnnualIncomeID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getAnnualIncome(), 'iAnnualIncomeID', 'vAnnualIncome'),
                          ['class' => 'demo-default select-beast',
                              'prompt' => 'Annual Income'
                          ]

                      )->label(false)->error(false); ?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right"
                       title="Mention Your Annual Income"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="row">
                  <div class="small-col">
                    <div class="required1"></div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-cont">
                      <div class="form-cont">
                        <?= Html::submitButton('CONTINUE', ['class' => 'btn btn-primary mrg-tp-10 ', 'name' => 'register2']) ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-cont">
                      <div class="form-cont">
                        <!--<a href="<? /*=$HOME_URL_SITE*/ ?>life-style" class="btn btn-primary mrg-tp-10 ">Skip</a>-->
                        <a href="life-style" class="btn btn-primary mrg-tp-10 ">Skip</a>
                      </div>
                    </div>
                  </div>
                </div>
                <?php ActiveForm::end(); ?>
              </div>
            </div>
            <?php
            echo $this->render('/layouts/parts/_rightbarregister.php');
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php
$this->registerJs('
    $("#form-register2").on("submit",function(e){
      var ieducationlevelid = $("#user-ieducationlevelid").val();
      var ieducationfieldid = $("#user-ieducationfieldid").val();
      var iworkingwithid = $("#user-iworkingwithid").val();
      var iworkingasid = $("#user-iworkingasid").val();
      var iannualincomeid = $("#user-iannualincomeid").val();

      $(".error-field").removeClass("error-field");
      $("#top-error").hide();
      var error_flag = true;
      if(ieducationlevelid == ""){
        $("#user-ieducationlevelid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(ieducationfieldid == ""){
        $("#user-ieducationfieldid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(iworkingwithid == ""){
        $("#user-iworkingwithid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(iworkingasid == ""){
        $("#user-iworkingasid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(iannualincomeid == ""){
        $("#user-iannualincomeid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }

      if(!error_flag){
        // $("#top-error").show();
        return false;
      }
    });
  ');
?>
