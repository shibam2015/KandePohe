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
      <div class="col-md-9 col-sm-12">
        <div class="right-column"> <span class="welcome-note">
            <?php
            if ($model->Profile_created_for !== "SELF") {
              ?>
              <p><strong>Welcome ,</strong> please give us few details about
                <strong><?= $model->First_Name; ?> </strong>.</p>
            <?php } else {
              ?>
              <p><strong>Welcome <?= $model->First_Name; ?> ,</strong> please give us few details about yourself.</p>

            <?php
            }
            ?>

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
                          ['class' => 'demo-default select-beast',
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
                          ['class' => 'demo-default select-beast',
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
                          ['class' => 'demo-default select-beast',
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
                          ['class' => 'demo-default select-beast',
                            'id' => 'iMaritalStatusID',
                              'prompt' => 'Maritial Status',
                            'onchange' => '
                            var iMaritalStatusID = $(this).val();
                            if(iMaritalStatusID == "4" || iMaritalStatusID == "5" || iMaritalStatusID == "6"){
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
                          ['class' => 'demo-default select-beast',
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
                          ['class' => 'demo-default select-beast',
                              'prompt' => 'Country',
                              'onchange'=>'
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax/getstatenew?id=') . '"+$(this).val(), function( data ) {
                                 var htmldata = "";
                                                            jsondata = data.state;
                                                                    var new_value_options   = "[";
                                                                    for (var key in jsondata) {
                                                                    //console.log(jsondata[key].vStateName);
                                                                        htmldata += "<option value=\'"+jsondata[key].iStateId+"\'>"+jsondata[key].vStateName+"</option>";

                                                                        var keyPlus = parseInt(key) + 1;
                                                                        if (keyPlus == jsondata.length) {
                                                                            new_value_options += "{text: \'"+jsondata[key].vStateName+"\', value: "+jsondata[key].iStateId+"}";
                                                                        } else {
                                                                            new_value_options += "{text: \'"+jsondata[key].vStateName+"\', value: "+jsondata[key].iStateId+"},";
                                                                        }
                                                                    }
                                                                    new_value_options   += "]";

                                                            new_value_options = eval("(" + new_value_options + ")");
                                                            if (new_value_options[0] != undefined) {
                                                                        // re-fill html select option field
                                                                        $("select#iStateId").html(htmldata);
                                                                        // re-fill/set the selectize values
                                                                        var selectize = $("select#iStateId")[0].selectize;
                                                                        selectize.clear();
                                                                        selectize.clearOptions();
                                                                        selectize.renderCache["option"] = {};
                                                                        selectize.renderCache["item"] = {};

                                                                        selectize.addOption(new_value_options);
                                                                        //selectize.setValue(iStateId);
                                                            }
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
                        ['class' => 'demo-default select-beast',
                            'id' => 'iStateId',
                              'prompt' => 'State',
                              'onchange'=>'
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax/getcitynew?id=') . '"+$(this).val(), function( data ) {
                                  //$( "select#iCityId" ).html( data );
                                  //$("select#iCityId").niceSelect("update");
                                  var htmldata = "";
                                                            jsondata = data.city;
                                                                    var new_value_options   = "[";
                                                                    for (var key in jsondata) {
                                                                        htmldata += "<option value=\'"+jsondata[key].iCityId+"\'>"+jsondata[key].vCityName+"</option>";
                                                                        var keyPlus = parseInt(key) + 1;
                                                                        if (keyPlus == jsondata.length) {
                                                                            new_value_options += "{text: \'"+jsondata[key].vCityName+"\', value: "+jsondata[key].iCityId+"}";
                                                                        } else {
                                                                            new_value_options += "{text: \'"+jsondata[key].vCityName+"\', value: "+jsondata[key].iCityId+"},";
                                                                        }
                                                                    }
                                                                    new_value_options   += "]";

                                                            new_value_options = eval("(" + new_value_options + ")");
                                                            if (new_value_options[0] != undefined) {
                                                                        // re-fill html select option field
                                                                        $("select#iCityId").html(htmldata);
                                                                        // re-fill/set the selectize values
                                                                        var selectize = $("select#iCityId")[0].selectize;
                                                                        selectize.clear();
                                                                        selectize.clearOptions();
                                                                        selectize.renderCache["option"] = {};
                                                                        selectize.renderCache["item"] = {};

                                                                        selectize.addOption(new_value_options);
                                                                       // selectize.setValue(iCityId);
                                                            }
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
                          ['class' => 'demo-default select-beast',
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
                          ['class' => 'demo-default select-beast',
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
                          ['class' => 'demo-default select-beast',
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
                        <?= $form->field($model, 'vAreaName', ["template" => '<span class="input input--akira input--filled dobcl">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Area Name</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control vareaname', 'placeholder' => 'e.g.
Koregaon Park',

                            'onchange' => ' $(".dobcl").addClass("input--filled");',
                            //'onkeydown' => ' $(".vareaname").val("");',

                        ]) ?>
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
                    <div class="small-col">
                        <div class="required1"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-cont">
                            <div class="form-cont">
                                <?= Html::submitButton('CONTINUE', ['class' => 'btn btn-primary mrg-tp-10 ', 'name' => 'register1']) ?>
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
   var iMaritalStatusID = $("#iMaritalStatusID").val();
   if(iMaritalStatusID==""){
    $("select#iMaritalStatusID").prop("selectedIndex", 1);
    $("select#iMaritalStatusID").niceSelect("update");
   }

  ');
  ?>