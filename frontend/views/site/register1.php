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
      echo $this->render('/layouts/parts/_leftsidebarregister.php');
    ?>
      <div class="col-md-9 col-sm-12">
        <div class="right-column"> <span class="welcome-note">
          <p><strong>Welcome <?= $model->First_Name; ?> !</strong> We need a few details that will get you started with registration.</p>
          </span>
          <div class="row no-gutter">
            <div class="col-lg-8 col-md-12 col-sm-12">
              <div class="white-section mrg-tp-20 mrg-bt-10">
                <h3>Basic Details</h3>
                <!-- <span class="error">Oops! Please ensure all fields are valid</span> -->
                <p><span class="text-danger">*</span> marked fields are mandatory</p>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'form-register1',
                    //'enableClientValidation'=> true,
                    //'enableAjaxValidation'=> false,
                    // 'validateOnSubmit' => false,
                    'validateOnChange' => false,
                ]);
                ?>
                <?= $form->errorSummary($model,['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iReligion_ID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
                          ['class' => 'cs-select cs-skin-border',
                              'prompt' => 'Religion'
                          ]

                      )->label(false)->error(false);?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your Religion"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iCommunity_ID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getCommunity(), 'iCommunity_ID', 'vName'),
                          ['class' => 'cs-select cs-skin-border',
                              'prompt' => 'Community'
                          ]

                      )->label(false)->error(false);?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your Community"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><!--<span class="text-danger">*</span>--></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iSubCommunity_ID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getSubCommunity(), 'iSubCommunity_ID', 'vName'),
                          ['class' => 'cs-select cs-skin-border',
                              'prompt' => 'Sub Community'
                          ]

                      )->label(false)->error(false);?>
                    </div>

                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your Sub Community"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col"><!--error-field-->
                    <div class="form-cont">
                      <?= $form->field($model, 'iMaritalStatusID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'),
                          ['class' => 'cs-select cs-skin-border',
                            'id' => 'iMaritalStatusID',
                              'prompt' => 'Maritial Status',
                            'onchange' => '
                            var iMaritalStatusID = $(this).val();
                            if(iMaritalStatusID == "4" || iMaritalStatusID == "5"){
                              $("#nocDiv").show();
                            }
                            else {
                              $("#nocDiv").hide();
                              $("#noc").val("0");
                            }
                            '
                          ]
                      )->label(false)->error(false);?>
                    </div>
                   </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your Maritial Status"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <?php

                  if($model->iMaritalStatusID == '4' || $model->iMaritalStatusID == '5'){
                    $style = "display:block";
                  }
                  else {
                    $style = "display:none";
                  }
                ?>
                <div class="box noc" id="nocDiv" style="<?=$style?>">
                  <div class="small-col">
                    <div class="required1"><!--<span class="text-danger">*</span>--></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'noc', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Number Of Children</span> </label></span>{error}'])->input('number',['id' => 'noc','class'=>'input__field input__field--akira form-control'])->error(false)?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your Number Of Children"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><!--<span class="text-danger">*</span>--></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iGotraID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getGotra(), 'iGotraID', 'vName'),
                          ['class' => 'cs-select cs-skin-border',
                              'prompt' => 'Gotra'
                          ]

                      )->label(false)->error(false);?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your Gotra"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>


                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iCountryId')->dropDownList(
                          ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
                          ['class' => 'cs-select cs-skin-border',
                              'prompt' => 'Country',
                              'onchange'=>'
                                $.post( "'.Yii::$app->urlManager->createUrl('ajax/getstate?id=').'"+$(this).val(), function( data ) {
                                  $( "select#iStateId" ).html( data );
                                  $("select#iStateId").niceSelect("update");
                                });'
                          ]

                      )->label(false)->error(false);?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your Country"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                    <?php
                      $stateList = [];
                      if($model->iCountryId!=""){
                        $stateList = ArrayHelper::map(CommonHelper::getState($model->iCountryId), 'iStateId', 'vStateName');
                      }
                      ?>
                      <?= $form->field($model, 'iStateId')->dropDownList(
                          $stateList,
                          ['class' => 'cs-select cs-skin-border',
                            'id' => 'iStateId',
                              'prompt' => 'State',
                              'onchange'=>'
                                $.post( "'.Yii::$app->urlManager->createUrl('ajax/getcity?id=').'"+$(this).val(), function( data ) {
                                  $( "select#iCityId" ).html( data );
                                  $("select#iCityId").niceSelect("update");
                                });'
                          ]

                      )->label(false)->error(false);?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your State"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont" id="cityDiv">
                      <?php
                      $cityList = [];
                      if($model->iStateId!=""){
                        $cityList = ArrayHelper::map(CommonHelper::getCity($model->iStateId), 'iCityId', 'vCityName');
                      }
                      ?>
                      <?= $form->field($model, 'iCityId')->dropDownList(
                          $cityList,
                          ['class' => 'cs-select cs-skin-border',
                              'id' => 'iCityId',
                              'prompt' => 'City'
                          ]

                      )->label(false)->error(false);?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your City"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iDistrictID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
                          ['class' => 'cs-select cs-skin-border',
                              'prompt' => 'District'
                          ]

                      )->label(false)->error(false);?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your District"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><span class="text-danger">*</span></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'iTalukaID')->dropDownList(
                          ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
                          ['class' => 'cs-select cs-skin-border',
                              'prompt' => 'Taluka'
                          ]

                      )->label(false)->error(false);?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your Taluka"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><!--<span class="text-danger">*</span>--></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'vAreaName', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Area Name</span> </label></span>{error}'])->input('text',['class'=>'input__field input__field--akira form-control'])?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Mention Your Area Name"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21','height' => 21,'alt' => 'help']); ?></a>
                  </div>
                </div>


                <div class="checkbox mrg-lt-30">
                  <input id="Remember" type="checkbox" name="User[cnb]" value="YES" <?php echo($model->cnb == 'YES') ? 'checked': '';?>>
                  <label for="Remember" class="control-label">Not particular about my partner’s community (Caste No Bar) </label>
                </div>

                <div class="row">
                  <div class="col-sm-10 col-sm-offset-1">
                    <?= Html::submitButton('CONTINUE', ['class' => 'btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left', 'name' => 'register1']) ?>
                    <!-- <a href="<?/*=$HOME_URL_SITE*/?>life-style" class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right">Skip</a>-->
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
    $("#form-register1").on("submit",function(e){
      var ireligion_id = $("#user-ireligion_id").val();
      var icommunity_id = $("#user-icommunity_id").val();
      var iMaritalStatusID = $("#iMaritalStatusID").val();
      var icountryid = $("#user-icountryid").val();
      var iStateId = $("#iStateId").val();
      var iCityId = $("#iCityId").val();
      var italukaid = $("#user-italukaid").val();
      var idistrictid = $("#user-idistrictid").val();

      $(".error-field").removeClass("error-field");
      $("#top-error").hide();
      var error_flag = true;
      if(ireligion_id == ""){
        $("#user-ireligion_id").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(icommunity_id == ""){
        $("#user-icommunity_id").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(iMaritalStatusID == ""){
        $("#iMaritalStatusID").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(icountryid == ""){
        $("#user-icountryid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(iStateId == ""){
        $("#iStateId").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(iCityId == ""){
        $("#iCityId").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(italukaid == ""){
        $("#user-italukaid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(idistrictid == ""){
        $("#user-idistrictid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }

      if(!error_flag){
        // $("#top-error").show();
        return false;
      }
    });
  ');
  ?>