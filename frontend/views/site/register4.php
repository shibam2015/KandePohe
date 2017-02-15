<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

?>
<main>
    <div class="container-fluid">
        <div class="row no-gutter bg-dark">
            <?php
            echo $this->render('/layouts/parts/_leftsidebarregister.php', ['CurrentStep' => $CurrentStep]);
            ?>
            <div class="col-sm-9">
                <div class="right-column">
                        <span class="welcome-note">
                              <?php
                              if ($model->Profile_created_for !== "SELF") {
                                  ?>
                                  <p>Some details about <strong><?= $model->First_Name; ?>'s</strong> family …</p>
                              <?php } else {
                                  ?>
                                  <p><strong><?= $model->First_Name; ?> ,</strong> Some details about your family …</p>
                              <?php } ?>
                        </span>

                    <div class="row no-gutter">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="white-section mrg-tp-20 mrg-bt-10">
                                <h3>Family</h3>

                                <p><span class="text-danger">*</span> marked fields are mandatory</p>
                                <?php
                                $form = ActiveForm::begin([
                                    'id' => 'form-register4',
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
                                            <?= $form->field($model, 'iFatherStatusID')->dropDownList(
                                                ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
                                                ['class' => 'demo-default select-beast',
                                                    'prompt' => 'Father Status'
                                                ]

                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Father Status "><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><!--<span class="text-danger">*</span>--></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'iFatherWorkingAsID')->dropDownList(
                                                ArrayHelper::map(CommonHelper::getWorkingas(), 'iWorkingAsID', 'vWorkingAsName'),
                                                ['class' => 'demo-default select-beast',
                                                    'prompt' => 'Father Working AS'
                                                ]
                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Father Working"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><span class="text-danger">*</span></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'iMotherStatusID')->dropDownList(
                                                ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
                                                ['class' => 'demo-default select-beast',
                                                    'prompt' => 'Mother Status'
                                                ]
                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Mother Status"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><!--<span class="text-danger">*</span>--></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'iMotherWorkingAsID')->dropDownList(
                                                ArrayHelper::map(CommonHelper::getWorkingAS(), 'iWorkingAsID', 'vWorkingAsName'),
                                                ['class' => 'demo-default select-beast',
                                                    'prompt' => 'Mother Working AS'
                                                ]
                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Mother Working AS"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><span class="text-danger">*</span></div>
                                    </div>
                                    <div class="mid-col"><!--error-field-->
                                        <div class="form-cont">
                                            <?= $form->field($model, 'nob', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">No of Brothers</span> </label></span>'])->input('number', ['class' => 'input__field input__field--akira form-control', 'min' => '0',
                                                    'onchange' => '
                                                            var nob = $(this).val();
                                                            if(nob == 0){
                                                            $("#nobmDiv").hide();
                                                             // $("#NobM").val("0");
                                                            }
                                                            else {
                                                              $("#nobmDiv").show();
                                                            }
                                                            '
                                                ]
                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your no Of Brother"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <?php

                                if ($model->nob == '0') {
                                    $style = "display:none";
                                } else {
                                    $style = "display:block";
                                }
                                ?>
                                <div class="box NobM" id="nobmDiv" style="<?= $style ?>">
                                    <div class="small-col">
                                        <div class="required1"><!--<span class="text-danger">*</span>--></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'NobM', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Number Of Brothers Married</span> </label></span>{error}'])->input('number', ['id' => 'NobM', 'class' => 'input__field input__field--akira form-control', 'min' => '0'])->error(false) ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Number Of Brother Married"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>


                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><span class="text-danger">*</span></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'nos', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">No of Sisters</span> </label></span>'])->input('number', ['class' => 'input__field input__field--akira form-control', 'min' => '0', 'onchange' => '
                                                    var nos = $(this).val();
                                                    if(nos == 0){
                                                    $("#nosmDiv").hide();
                                                      $("#NosM").val("0");
                                                    }
                                                    else {
                                                      $("#nosmDiv").show();
                                                    }
                                                     '
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your No of Sisters"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <?php
                                if ($model->nos == '0') {
                                    $style = "display:none";
                                } else {
                                    $style = "display:block";
                                }
                                ?>
                                <div class="box NosM" id="nosmDiv" style="<?= $style ?>">
                                    <div class="small-col">
                                        <div class="required1"><!--<span class="text-danger">*</span>--></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'NosM', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Number Of Sisters Married</span> </label></span>{error}'])->input('number', ['id' => 'NosM', 'class' => 'input__field input__field--akira form-control', 'min' => '0'])->error(false) ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Number Sister Married"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <label for="Remember" class="control-label" id="Presiding">Your Permanent
                                            Address</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="checkbox col-sm-10 col-sm-offset-1">
                                        <input id="sameaddress" type="checkbox" name="User[eSameAddress]"
                                               value="Yes" <?php echo ($model->eSameAddress == 'Yes') ? 'checked' : ''; ?>>
                                        <label for="sameaddress" class="control-label">Same as my Current Address
                                            mentioned above</label>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><span class="text-danger">*</span></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">

                                            <?= $form->field($model, 'iCountryCAId')->dropDownList(
                                                ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
                                                ['class' => 'demo-default select-beast',
                                                    'prompt' => 'Country',
                                                    'onchange' => '
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
                                                                        $("select#iStateCAId").html(htmldata);
                                                                        // re-fill/set the selectize values
                                                                        var selectize = $("select#iStateCAId")[0].selectize;
                                                                        selectize.clear();
                                                                        selectize.clearOptions();
                                                                        selectize.renderCache["option"] = {};
                                                                        selectize.renderCache["item"] = {};

                                                                        selectize.addOption(new_value_options);
                                                                        //selectize.setValue(iStateId);
                                                            }

                                                        });'
                                                ]
                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Country"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
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
                                            if ($model->iCountryCAId != "") {
                                                $stateList = ArrayHelper::map(CommonHelper::getState($model->iCountryCAId), 'iStateId', 'vStateName');
                                            }
                                            ?>
                                            <?= $form->field($model, 'iStateCAId')->dropDownList(
                                                $stateList,
                                                ['class' => 'demo-default select-beast',
                                                    'id' => 'iStateCAId',
                                                    'prompt' => 'State',
                                                    'onchange' => '
                                                        $.post( "' . Yii::$app->urlManager->createUrl('ajax/getcitynew?id=') . '"+$(this).val(), function( data ) {
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
                                                                        $("select#iCityCAId").html(htmldata);
                                                                        // re-fill/set the selectize values
                                                                        var selectize = $("select#iCityCAId")[0].selectize;
                                                                        selectize.clear();
                                                                        selectize.clearOptions();
                                                                        selectize.renderCache["option"] = {};
                                                                        selectize.renderCache["item"] = {};

                                                                        selectize.addOption(new_value_options);
                                                                       // selectize.setValue(iCityId);
                                                            }

                                                        });'
                                                ]
                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your State"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><span class="text-danger">*</span></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?php
                                            $cityList = [];
                                            if ($model->iStateCAId != "") {
                                                $cityList = ArrayHelper::map(CommonHelper::getCity($model->iStateCAId), 'iCityId', 'vCityName');
                                            }
                                            ?>
                                            <?= $form->field($model, 'iCityCAId')->dropDownList(
                                                $cityList,
                                                ['class' => 'demo-default select-beast',
                                                    'id' => 'iCityCAId',
                                                    'prompt' => 'City'
                                                ]
                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your City"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><span class="text-danger">*</span></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'iDistrictCAID')->dropDownList(
                                                ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
                                                ['class' => 'demo-default select-beast',
                                                    'prompt' => 'District'
                                                ]
                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your District"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><span class="text-danger">*</span></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'iTalukaCAID')->dropDownList(
                                                ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
                                                ['class' => 'demo-default select-beast',
                                                    'prompt' => 'Taluka'
                                                ]
                                            )->label(false)->error(false); ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Taluka"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><!--<span class="text-danger">*</span>--></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'vAreaNameCA', ["template" => '<span class="input input--akira input--filled">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Area Name</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control', 'placeholder' => 'e.g.
Koregaon Park']) ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Area Name"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>


                                <div class="box">
                                    <div class="small-col">
                                        <div class="required1"><!--<span class="text-danger">*</span>--></div>
                                    </div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <?= $form->field($model, 'vNativePlaceCA', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Your Native Place</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control']) ?>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Native Place"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <?php

                                if ($model->eSameAddress == 'Yes') {
                                    #$style = "display:none";
                                } else {
                                    #$style = "display:block";
                                }
                                ?>
                                <!--
                                    <div class="row Paddress" style="<?= $style ?>">
                                        <div class="col-sm-10">
                                            <label for="Remember" class="control-label required1"> <span
                                                    class="text-danger">*</span> Parents Residing At :</label>
                                        </div>
                                    </div>

                                    <div class="box Paddress" style="<?= $style ?>">
                                        <div class="small-col">&nbsp;</div>
                                        <div class="mid-col">
                                            <div class="form-cont">
                                                <div class="radio dl radio_step4" id="IVA">

                                                    <?= $form->field($model, 'vParentsResiding')->RadioList(
                                    ['Current_Address' => 'Current Address', 'Permanent_Address' => 'Permanent Address'],
                                    [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            $checked = ($checked) ? 'checked' : '';
                                            $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                            $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                                            return $return;
                                        }
                                    ]
                                )->label(false)->error(false); ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="small-col tp ">
                                            <a href="#" data-toggle="tooltip" data-placement="right"
                                               title="Mention Your Parents Residing"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                        </div>
                                    </div>
                                    -->
                                <div class="row">
                                    <div class="col-sm-10">
                                        <label for="Remember" class="control-label">Family Affluence Level :</label>
                                    </div>
                                </div>

                                <div class="box">
                                    <div class="small-col">&nbsp;</div>
                                    <div class="mid-col ">
                                        <div class="form-cont">
                                            <div class="radio dl radio_step4" id="IVA">
                                                <!--<dt></dt>
                                                <dd>-->

                                                <?= $form->field($model, 'vFamilyAffluenceLevel')->RadioList(
                                                    ArrayHelper::map(CommonHelper::getFamilyAffulenceLevel(), 'ID', 'Name'),
                                                    ['item' => function ($index, $label, $name, $checked, $value) {
                                                        $checked = ($checked) ? 'checked' : '';
                                                        $return = '<input type="radio" id="vFamilyAffluenceLevel_' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                        $return .= '<label for="vFamilyAffluenceLevel_' . $value . '">' . ucwords($label) . '</label>';
                                                        return $return;
                                                    }
                                                    ]
                                                )->label(false)->error(false); ?>
                                                <!--</dd>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Family Affluence Level"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <label for="Remember" class="control-label">Family Type :</label>
                                    </div>
                                </div>

                                <div class="box">
                                    <div class="small-col">&nbsp;</div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <div class="radio dl radio_step4" id="IVA">
                                                <!--<dt></dt>
                                                <dd>-->
                                                <?= $form->field($model, 'vFamilyType')->RadioList(
                                                    ['Joint' => 'Joint', 'Nuclear' => 'Nuclear'],
                                                    [
                                                        'item' => function ($index, $label, $name, $checked, $value) {
                                                            $checked = ($checked) ? 'checked' : '';
                                                            $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                            $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                                                            return $return;
                                                        }
                                                    ]
                                                )->label(false)->error(false); ?>
                                                <!--</dd>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Family Type"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <label for="Remember" class="control-label">Property Details :</label>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="small-col">&nbsp;</div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <div class="checkbox">
                                                <?php global $ABC;
                                                $ABC = $model->vFamilyProperty; ?>

                                                <?= $form->field($model, 'vFamilyProperty')->checkboxList(
                                                    ArrayHelper::map(CommonHelper::getFamilyPropertyDetail(), 'ID', 'Name'),
                                                    ['item' => function ($index, $label, $name, $checked, $value) {
                                                        global $ABC;
                                                        //if (in_array($value, explode(",",$model->vFamilyProperty))) { $checked='checked="checked"'; }else{$checked='';}
                                                        $checked = (in_array($value, explode(",", $ABC))) ? 'checked' : '';
                                                        $return = '<input type="checkbox" id="vFamilyProperty' . $label . '" name="' . $name . '" value="' . $value . '"' . $checked . '>';
                                                        $return .= '<label for="vFamilyProperty' . $label . '" class="control-label toccl">' . $label . '</label>';
                                                        return $return;
                                                    }
                                                    ]

                                                )->label(false)->error(false); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your Property Details"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="col-sm-"><span><label class="control-label">Details about
                                            Relatives:</label></span></div>
                                <div class="box">

                                    <div class="small-col">&nbsp;</div>
                                    <div class="mid-col">
                                        <div class="form-cont">
                                            <div class=""></div>

					<span class="input input--akira input--filled input-textarea mrg-tp-10">
                          <textarea class="input__field input__field--akira" cols="50" rows="5" name="User[vDetailRelative]" ><?= ($model->vDetailRelative)?></textarea>
                          <label class="input__label input__label--akira" for="input-22">
                              <span class="input__label-content input__label-content--akira">You can enter your relative surnames etc...</span>
                          </label>
                        </span>

                                        </div>
                                    </div>
                                    <div class="small-col tp ">
                                        <a href="#" data-toggle="tooltip" data-placement="right"
                                           title="Mention Your relative surnames"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-col">
                                        <div class="required1"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-cont">
                                            <div class="form-cont">
                                                <?= Html::submitButton('CONTINUE', ['class' => 'btn btn-primary mrg-tp-10 ', 'name' => 'register4']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-cont">
                                            <div class="form-cont">
                                                <a href="<?= $HOME_URL_SITE ?>about-yourself"
                                                   class="btn btn-primary mrg-tp-10 ">Skip</a>
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
  $("#sameaddress").change(function(){
      if($(this).is(":checked")) {
            sameAsAboveAddress();
        }
  });
  $("#sameaddress").change(function () {
        if (!this.checked)
            //  ^
            $(".Paddress").fadeIn("fast");
        else
            $(".Paddress").fadeOut("fast");
    });
  function sameAsAboveAddress(){
      var iCountryId = "'.$model->iCountryId.'";
      var iStateId = "'.$model->iStateId .'";
      var iCityId = "'.$model->iCityId .'";
      var iDistrictID = "'.$model->iDistrictID .'";
      var iTalukaID = "'.$model->iTalukaID .'";
      var vAreaName = "'.$model->vAreaName .'";

      $.ajax({
        url:"'.Url::to(['ajax/sameasaboveaddress']).'", 
        type: "post",
        dataType: "JSON",
        data: {
                iCountryId:iCountryId,
                iStateId:iStateId,
                iCityId:iCityId,
                iDistrictID:iDistrictID,
                iTalukaID:iTalukaID,
                vAreaName:vAreaName,
              },
        success: function(res){
       // console.log(res.state );

            var $select = $("select#user-icountrycaid").selectize();
            var control = $select[0].selectize;
            control.setValue(iCountryId);
            //control.clear();

        setTimeout(function(){
            var htmldata = "";
            jsondata = res.state;
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
                        $("select#iStateCAId").html(htmldata);
                        // re-fill/set the selectize values
                        var selectize = $("select#iStateCAId")[0].selectize;
                        selectize.clear();
                        selectize.clearOptions();
                        selectize.renderCache["option"] = {};
                        selectize.renderCache["item"] = {};

                        selectize.addOption(new_value_options);
                        selectize.setValue(iStateId);
            }
            setTimeout(function(){
                var htmldata = "";
                jsondata = res.city;
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
                            $("select#iCityCAId").html(htmldata);
                            // re-fill/set the selectize values
                            var selectize = $("select#iCityCAId")[0].selectize;
                            selectize.clear();
                            selectize.clearOptions();
                            selectize.renderCache["option"] = {};
                            selectize.renderCache["item"] = {};

                            selectize.addOption(new_value_options);
                            selectize.setValue(iCityId);
                }
            }, 500);
        }, 1000);




            var htmldata = "";
            jsondata =  res.district;
                    var new_value_options   = "[";
                    for (var key in jsondata) {
                        htmldata += "<option value=\'"+jsondata[key].iDistrictID+"\'>"+jsondata[key].vName+"</option>";
                        var keyPlus = parseInt(key) + 1;
                        if (keyPlus == jsondata.length) {
                            new_value_options += "{text: \'"+jsondata[key].vName+"\', value: "+jsondata[key].iDistrictID+"}";
                        } else {
                            new_value_options += "{text: \'"+jsondata[key].vName+"\', value: "+jsondata[key].iDistrictID+"},";
                        }
                    }
                    new_value_options   += "]";

            new_value_options = eval("(" + new_value_options + ")");
            if (new_value_options[0] != undefined) {
                        // re-fill html select option field
                        $("select#user-idistrictcaid").html(htmldata);
                        // re-fill/set the selectize values
                        var selectize = $("select#user-idistrictcaid")[0].selectize;
                        selectize.clear();
                        selectize.clearOptions();
                        selectize.renderCache["option"] = {};
                        selectize.renderCache["item"] = {};

                        selectize.addOption(new_value_options);
                        selectize.setValue(iDistrictID);
            }
            var htmldata = "";
            jsondata = res.taluka;
                    var new_value_options   = "[";
                    for (var key in jsondata) {
                        htmldata += "<option value=\'"+jsondata[key].iTalukaID+"\'>"+jsondata[key].vName+"</option>";
                        var keyPlus = parseInt(key) + 1;
                        if (keyPlus == jsondata.length) {
                            new_value_options += "{text: \'"+jsondata[key].vName+"\', value: "+jsondata[key].iTalukaID+"}";
                        } else {
                            new_value_options += "{text: \'"+jsondata[key].vName+"\', value: "+jsondata[key].iTalukaID+"},";
                        }
                    }
                    new_value_options   += "]";

            new_value_options = eval("(" + new_value_options + ")");
            if (new_value_options[0] != undefined) {
                        // re-fill html select option field
                        $("select#user-italukacaid").html(htmldata);
                        // re-fill/set the selectize values
                        var selectize = $("select#user-italukacaid")[0].selectize;
                        selectize.clear();
                        selectize.clearOptions();
                        selectize.renderCache["option"] = {};
                        selectize.renderCache["item"] = {};

                        selectize.addOption(new_value_options);
                        selectize.setValue(iTalukaID);
            }


            /*var $select1 = $("select#iStateCAId").selectize();
            var control1 = $select1[0].selectize;
            control1.clear();
            control1.clearOptions();
                $("select#iStateCAId").selectize(res.state)*/
            //control1.refreshItems();

            //$("select#user-icountrycaid").clear();
            //$("select#user-icountrycaid").selectize(res.country);
            /*$(".select-beast").selectize({
                 //create: true,
                 sortField: {
                     field: "text",
                     direction: "asc"
                 }
             });*/
            //$("select#user-icountrycaid").niceSelect("update");
/*
            $( "select#iStateCAId" ).html( res.state );
            //$("select#iStateCAId").niceSelect("update");

            $( "select#iCityCAId" ).html( res.city );
            //$("select#iCityCAId").niceSelect("update");

            $( "select#user-idistrictcaid" ).html( res.district );
            //$("select#user-idistrictcaid").niceSelect("update");

            $( "select#user-italukacaid" ).html( res.taluka );
            //$("select#user-italukacaid").niceSelect("update");*/

            $("#user-vareanameca").val(res.areaname );
        }
      });
    }
', View::POS_END);
?>
<?php
$this->registerJs('
    $("#form-register4").on("submit",function(e){
      var ifatherstatusid = $("#user-ifatherstatusid").val();
      var imotherstatusid = $("#user-imotherstatusid").val();
      var icountrycaid = $("#user-icountrycaid").val();
      var iCityCAId = $("#iCityCAId").val();
      var iStateCAId = $("#iStateCAId").val();
      var idistrictcaid = $("#user-idistrictcaid").val();
      var italukacaid = $("#user-italukacaid").val();
      var nob = $("#user-nob").val();
      var nos = $("#user-nos").val();
      //var vParentsResiding = $(\'input:radio[name="User[vParentsResiding]"]:checked\').val()

      $(".error-field").removeClass("error-field");
      var error_flag = true;
      if(ifatherstatusid == ""){
        $("#user-ifatherstatusid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(imotherstatusid == ""){
        $("#user-imotherstatusid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }

      if(iStateCAId == ""){
        $("#iStateCAId").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }

      if(icountrycaid == ""){
        $("#user-icountrycaid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }

      if(iCityCAId == ""){
        $("#iCityCAId").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }

      if(idistrictcaid == ""){
        $("#user-idistrictcaid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }

      if(italukacaid == ""){
        $("#user-italukacaid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }

      if(nob == ""){
        $("#user-nob").addClass("error-field");
        error_flag = false;
      }

      if(nos == ""){
        $("#user-nos").addClass("error-field");
        error_flag = false;
      }

      /*if(vParentsResiding == "" || typeof vParentsResiding === "undefined"){
        $(\'input:radio[name="User[vParentsResiding]"]\').closest(".mid-col").addClass("error-field");
        error_flag = false;
      }*/

      if(!error_flag){
        return false;
      }
    });
  ', View::POS_END);
?>
