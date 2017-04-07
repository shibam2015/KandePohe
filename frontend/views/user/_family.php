<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
?>
    <style>
        input[type="radio"], input[type="checkbox"] {
            display: inline-block;
        }

        input[type="radio"]:checked + label::before {
            content: "";
        }
    </style>
    <div class="div_personal_info">
<?php
if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-family'],
        'options' => ['data-pjax' => true],
        'validateOnChange' => false,
        'validateOnSubmit' => true,
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4 col-xs-4',
                'offset' => '',
                'wrapper' => 'col-sm-8 col-xs-8',
                'error' => '',
                'hint' => '',
            ]
            ]
    ]);
    ?>
    <?= $form->errorSummary($model,['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
    <?= $form->field($model, 'iFatherStatusID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
        ['class' => 'demo-default select-beast clsfamily', 'prompt' => 'Father Status',
            'onchange' => '
                                                    var wArray = ' . json_encode(Yii::$app->params['fatherWorkingAsNot']) . ';
                                                                if(wArray.indexOf($(this).val())!=-1){ //.trim()
                                                                       $(".user_ifatherworkingasid_div").hide();
                                                                            var selectize = $("select#user-ifatherworkingasid")[0].selectize;
                                                                            selectize.clear();
                                                                            selectize.setValue(0);
                                                                }else{
                                                                    $(".user_ifatherworkingasid_div").show();
                                                                }
                                                    '
        ]
    ); ?>
    <?php
    if (in_array($model->iFatherStatusID, Yii::$app->params['fatherWorkingAsNot'])) {
        $Ft = 'style="display:none;"';
    }
    ?>
    <div class="user_ifatherworkingasid_div" <?= $Ft ?>>
    <?= $form->field($model, 'iFatherWorkingAsID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getWorkingas(), 'iWorkingAsID', 'vWorkingAsName'),
        ['class' => 'demo-default select-beast clsfamily', 'prompt' => 'Father Working AS']
    ); ?>
    </div>
    <?= $form->field($model, 'iMotherStatusID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
        ['class' => 'demo-default select-beast clsfamily', 'prompt' => 'Mother Status',
            'onchange' => '
                                                      var wArray = ' . json_encode(Yii::$app->params['motherWorkingAsNot']) . ';
                                                                if(wArray.indexOf($(this).val().trim())!=-1){
                                                                       $(".user_imotherworkingasid_div").hide();
                                                                            var selectize = $("select#user-imotherworkingasid")[0].selectize;
                                                                            selectize.clear();
                                                                            selectize.setValue(0);
                                                                }else{
                                                                    $(".user_imotherworkingasid_div").show();
                                                                }
                                                    '
        ]
    ); ?>
    <?php
    if (in_array($model->iMotherStatusID, Yii::$app->params['motherWorkingAsNot'])) {
        $Mt = 'style="display:none;"';
    }
    ?>
    <div class="user_imotherworkingasid_div" <?= $Mt ?>>
    <?= $form->field($model, 'iMotherWorkingAsID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getWorkingAS(), 'iWorkingAsID', 'vWorkingAsName'),
        ['class' => 'demo-default select-beast clsfamily', 'prompt' => 'Mother Working AS']
    ); ?>
    </div>

    <?= $form->field($model, 'nob', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
])->input('number', ['min' => '0',
    'onkeyup' => '
                                                            var nob = $(this).val();
                                                            if(nob == 0){
                                                            $("#nobmDiv").hide();
                                                               // $("#NobM").val("0");
                                                            }
                                                            else {
                                                              $("#nobmDiv").show();
                                                            }
                                                            '
]) ?>
    <?php

    if ($model->nob == '0') {
        $style = "display:none";
    } else {
        $style = "display:block";
    }
    ?>
    <div class="box NobM" id="nobmDiv" style="<?= $style ?>">
        <?= $form->field($model, 'NobM', [
            'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger"> </span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
            'labelOptions' => ['class' => ''],
        ])->input('number') ?>
    </div>

    <?= $form->field($model, 'nos', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
])->input('number', ['min' => '0', 'onkeyup' => '
                                                    var nos = $(this).val();
                                                    if(nos == 0){
                                                    $("#nosmDiv").hide();
                                                      $("#NosM").val("0");
                                                    }
                                                    else {
                                                      $("#nosmDiv").show();
                                                    }
                                                     '
]) ?>

    <?php
    if ($model->nos == '0') {
        $style = "display:none";
    } else {
        $style = "display:block";
    }
    ?>
    <div class="box NosM" id="nosmDiv" style="<?= $style ?>">
        <?= $form->field($model, 'NosM', [
            'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger"></span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
            'labelOptions' => ['class' => ''],
        ])->input('number') ?>
    </div>

    <?= $form->field($model, 'iCountryCAId', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
        ['class' => 'demo-default select-beast clsfamily',
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
                                                                        //selectize.setValue(iStateCAId);

                                                                        var selectize = $("select#iCityCAId")[0].selectize;
                                                                        selectize.clear();
                                                                        selectize.clearOptions();


                                                                        if(data.CountryId == 101){
                                                                           $(".user_idistrictid_div").show();
                                                                            $(".user_iTalukaID_div").show();
                                                                            var selectize = $("select#user-idistrictcaid")[0].selectize;
                                                                            selectize.clear();
                                                                            var selectize = $("select#user-italukacaid")[0].selectize;
                                                                            selectize.clear();
                                                                        }else{
                                                                            $(".user_idistrictid_div").hide();
                                                                            var selectize = $("select#user-idistrictcaid")[0].selectize;
                                                                            selectize.clear();
                                                                            selectize.setValue(1);
                                                                            $(".user_iTalukaID_div").hide();
                                                                            var selectize = $("select#user-italukacaid")[0].selectize;
                                                                            selectize.clear();
                                                                            selectize.setValue(1);
                                                                        }
                                                            }
                                });'
        ]

    ); ?>
    <?php
    $stateList = [];
    if ($model->iCountryCAId != "") {
        $stateList = ArrayHelper::map(CommonHelper::getState($model->iCountryCAId), 'iStateId', 'vStateName');
    }
    ?>
    <?= $form->field($model, 'iStateCAId', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        $stateList,
        ['class' => 'demo-default select-beast clsfamily',
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
                                                            }
                                });'
        ]

    ); ?>
    <?php
    $cityList = [];
    if ($model->iStateCAId != "") {
        $cityList = ArrayHelper::map(CommonHelper::getCity($model->iStateCAId), 'iCityId', 'vCityName');
    }
    ?>
    <?= $form->field($model, 'iCityCAId', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        $cityList,
        ['class' => 'demo-default select-beast clsfamily',
            'id' => 'iCityCAId',
            'prompt' => 'City'
        ]

    ); ?>
    <?php $hide = '';
    if ($model->iCountryCAId != 101) {
        $hide = "display: none; ";
    } ?>
    <div class="user_idistrictid_div"
         style="<?= $hide ?>">
    <?= $form->field($model, 'iDistrictCAID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
        ['class' => 'demo-default select-beast clsfamily',
            'prompt' => 'District'
        ]
    ); ?>
    </div>
    <!--<div class="box user_iTalukaID_div"
         style="<? /*= $hide */ ?>">
    <? /*= $form->field($model, 'iTalukaCAID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
        ['class' => 'demo-default select-beast clsfamily',
            'prompt' => 'Taluka'
        ]
    ); */ ?>
    </div>-->
    <?= $form->field($model, 'vAreaNameCA', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->input('text', ['class' => 'form-control']) ?>

    <?= $form->field($model, 'vNativePlaceCA', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->input('text', ['class' => 'form-control']) ?>

    <?= $form->field($model, 'vParentsResiding', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->RadioList(
        ['Current_Address' => 'Current Address', 'Permanent_Address' => 'Permanent Address'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                return $return;
            }
        ]
    ); ?>

    <?= $form->field($model, 'vFamilyAffluenceLevel', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->RadioList(
         ArrayHelper::map(CommonHelper::getFamilyAffulenceLevel(), 'ID', 'Name'),
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                return $return;
            }
        ]
    ); ?>

    <?= $form->field($model, 'vFamilyType', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->RadioList(
        Yii::$app->params['familyTypeArray'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $label . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                $return .= '<label for="' . $label . '">' . ucwords($value) . '</label>';
                return $return;
            }
        ]
    ); ?>

    <?php global $ABC;
    $ABC = $model->vFamilyProperty; ?>
    <?= $form->field($model, 'vFamilyProperty', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->checkboxList(
        ArrayHelper::map(CommonHelper::getFamilyPropertyDetail(), 'ID', 'Name'),
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                global $ABC;
                
                $checked = (in_array($value, explode(",", $ABC))) ? 'checked' : '';
                $return = '<input type="checkbox" id="vFamilyProperty' . $label . '" name="' . $name . '" value="' . $value . '"' . $checked . '>';
                $return .= '<label for="vFamilyProperty' . $label . '" class="control-label no-content">' . $label . '</label>';
                return $return;
            }
        ]
    ); ?>

    <div class="box">
        <div class="small-col">
            <div class="required1"><!--<span class="text-danger">*</span>--></div>
        </div>
        <div class="mid-col">
            <div class="form-cont">

          <span class="input input--akira input--filled input-textarea">

            <textarea class="input__field input__field--akira" cols="50" rows="5" style="resize:none"
                      name="User[vDetailRelative]"><?= ($model->vDetailRelative) ?></textarea>
            <label class="input__label input__label--akira" for="input-22">
              <span
                  class="input__label-content input__label-content--akira">You can enter your relative surnames etc...</span> </label>
          </span>
        </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="form-cont">
                <div class="form-cont">
                    <input type="hidden" name="save" value="1">
                    <?= Html::submitButton('save', ['class' => 'btn btn-primary preferences_submit  my-profile-sc-button', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-cont">
                <div class="form-cont">
                    <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_family', 'name' => 'cancel']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end();

    $this->registerJs('
          selectboxClassWise("clsfamily");
         ');
    if ($model->iCountryCAId == 101) {
        if ($model->iDistrictCAID == 1) {
            $this->registerJs('
                    var selectize = $("select#user-idistrictcaid")[0].selectize;
                    selectize.clear();
                 ');
        }
        if ($model->iTalukaCAID == 1) {
            $this->registerJs('
                    var selectize = $("select#user-italukacaid")[0].selectize;
                    selectize.clear();
                 ');
        }

    }
} else {
    ?>
    
        <dl class="dl-horizontal">
            <dt>Father Status</dt>
            <dd><?= CommonHelper::setInputVal($model->fatherStatus->vName, 'text') ?>
            <dd>
                <?php if (!in_array($model->iFatherStatusID, Yii::$app->params['fatherWorkingAsNot'])) { ?>
            <dt>Father Working As</dt>
            <dd><?= CommonHelper::setInputVal($model->fatherStatusId->vWorkingAsName, 'text') ?></dd>
            <?php } ?>
            <dt>Mother Status</dt>
            <dd><?= CommonHelper::setInputVal($model->motherStatus->vName, 'text') ?>
            <dd>
                <?php if (!in_array($model->iMotherStatusID, Yii::$app->params['motherWorkingAsNot'])) { ?>
            <dt>Mother Working As</dt>
            <dd><?= CommonHelper::setInputVal($model->motherStatusId->vWorkingAsName, 'text') ?></dd>
        <?php } ?>
            <dt>No of Brothers</dt>
            <dd><?= $model->nob ?></dd>
            <?php if ($model->nob > 0) { ?>
                <dt>Number Of Merried Brothers</dt>
                <dd><?= $model->NobM ?></dd>
            <?php } ?>
            <dt>No of Sisters</dt>
            <dd><?= $model->nos; ?></dd>
            <?php if ($model->nos > 0) { ?>
                <dt>Number Of Merried Sisters</dt>
                <dd><?= $model->NosM ?></dd>
            <?php } ?>
            <dt>Country</dt>
            <dd><?= CommonHelper::setInputVal($model->countryNameCA->vCountryName, 'text') ?></dd>
            <dt>State</dt>
            <dd><?= CommonHelper::setInputVal($model->stateNameCA->vStateName, 'text') ?></dd>
            <dt>City</dt>
            <dd><?= CommonHelper::setInputVal($model->cityNameCA->vCityName, 'text') ?></dd>
            <?php $hide = '';
            if ($model->iCountryCAId != 101) {
                $hide = "display: none; ";
            } ?>

            <div style="<?= $hide ?>">
            <dt>Distict</dt>
            <dd><?= CommonHelper::setInputVal($model->districtNameCA->vName, 'text') ?></dd>
                <!-- <dt>Taluks</dt>
            <dd><?/*= CommonHelper::setInputVal($model->talukaNameCA->vName, 'text') */ ?></dd>-->
            </div>
            <dt>Area Name</dt>
            <dd><?= CommonHelper::setInputVal($model->vAreaName, 'text') ?></dd>
            <dt>Native Place</dt>
            <dd><?= CommonHelper::setInputVal($model->vNativePlaceCA, 'text') ?></dd>
            <!--<dt>Parents Residing At</dt>
            <dd><?/*= CommonHelper::setInputVal($model->vParentsResiding, 'text') */ ?></dd>-->
            <dt>Family Affluence Level</dt>
            <dd><?= CommonHelper::setInputVal($model->familyAffluenceLevelName->Name, 'text') ?></dd>
            <dt>Family Type</dt>
            <dd><?= CommonHelper::setInputVal($model->vFamilyType, 'text') ?></dd>
            <dt>Property Details</dt>
            <?php
                $family_property_array = ArrayHelper::map(CommonHelper::getFamilyPropertyDetail(), 'ID', 'Name');
                $family_propertyId_array = explode(',', $model->vFamilyProperty);
                $vFamilyProperty = "";
                foreach ($family_propertyId_array as $key => $value) {
                    $vFamilyProperty.= $family_property_array[$value].", ";
                }
                $vFamilyProperty = trim($vFamilyProperty,", ")
            ?>
            <dd><?= CommonHelper::setInputVal($vFamilyProperty, 'text') ?></dd>
            <dt>Additional Information</dt>
            <dd><?= CommonHelper::setInputVal($model->vDetailRelative, 'text') ?></dd>
        </dl>
    
    <?php
}
?>
</div>
<?php
$this->registerJs('
$(".preferences_submit").on("click", function() {
var $this = $(this);
$this.button("loading");
setTimeout(function() {
$this.button("reset");
}, 8000);
});
');
?>