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
                'validateOnChange' => true,
                'validateOnSubmit' => true,
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-3 col-xs-3',
                        'offset' => '',
                        'wrapper' => 'col-sm-8 col-xs-8',
                        'error' => '',
                        'hint' => '',
                    ]
                ]
            ]);
            ?>
            <?= $form->errorSummary($model, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
            <?= $form->field($model, 'iFatherStatusID')->dropDownList(
                ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
                ['class' => 'demo-default select-beast clsfamily', 'prompt' => 'Father Status']
            ); ?>

            <?= $form->field($model, 'iFatherWorkingAsID')->dropDownList(
                ArrayHelper::map(CommonHelper::getWorkingas(), 'iWorkingAsID', 'vWorkingAsName'),
                ['class' => 'demo-default select-beast clsfamily', 'prompt' => 'Father Working AS']
            ); ?>

            <?= $form->field($model, 'iMotherStatusID')->dropDownList(
                ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
                ['class' => 'demo-default select-beast clsfamily', 'prompt' => 'Mother Status']
            ); ?>

            <?= $form->field($model, 'iMotherWorkingAsID')->dropDownList(
                ArrayHelper::map(CommonHelper::getWorkingAS(), 'iWorkingAsID', 'vWorkingAsName'),
                ['class' => 'demo-default select-beast clsfamily', 'prompt' => 'Mother Working AS']
            ); ?>
            <?= $form->field($model, 'nob')->input('number') ?>
            <?= $form->field($model, 'nos')->input('number') ?>
            <?= $form->field($model, 'iCountryCAId')->dropDownList(
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
            <?= $form->field($model, 'iStateCAId')->dropDownList(
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
            <?= $form->field($model, 'iCityCAId')->dropDownList(
                $cityList,
                ['class' => 'demo-default select-beast clsfamily',
                    'id' => 'iCityCAId',
                    'prompt' => 'City'
                ]

            ); ?>
            <?= $form->field($model, 'iDistrictCAID')->dropDownList(
                ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
                ['class' => 'demo-default select-beast clsfamily',
                    'prompt' => 'District'
                ]
            ); ?>
            <?= $form->field($model, 'iTalukaCAID')->dropDownList(
                ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
                ['class' => 'demo-default select-beast clsfamily',
                    'prompt' => 'Taluka'
                ]
            ); ?>
            <?= $form->field($model, 'vAreaNameCA')->input('text', ['class' => 'form-control']) ?>

            <?= $form->field($model, 'vNativePlaceCA')->input('text', ['class' => 'form-control']) ?>

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
            ); ?>

            <?= $form->field($model, 'vFamilyAffluenceLevel')->RadioList(
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

            <?= $form->field($model, 'vFamilyType')->RadioList(
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
            <?= $form->field($model, 'vFamilyProperty')->checkboxList(
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
                  class="input__label-content input__label-content--akira">You can enter your relative surnames etc...</span>
            </label>
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
        } else {
            ?>

            <dl class="dl-horizontal">
                <dt>Father Status</dt>
                <dd><?= CommonHelper::setInputVal($model->fatherStatus->vName, 'text') ?>
                <dd>
                <dt>Father Working As</dt>
                <dd><?= CommonHelper::setInputVal($model->fatherStatusId->vWorkingAsName, 'text') ?></dd>
                <dt>Mother Status</dt>
                <dd><?= CommonHelper::setInputVal($model->motherStatus->vName, 'text') ?>
                <dd>
                <dt>Mother Working As</dt>
                <dd><?= CommonHelper::setInputVal($model->motherStatusId->vWorkingAsName, 'text') ?></dd>
                <dt>No of Brothers</dt>
                <dd><?= CommonHelper::setInputVal($model->nob, 'text') ?></dd>
                <dt>No of Sisters</dt>
                <dd><?= $model->nos; ?></dd>
                <dt>Country</dt>
                <dd><?= CommonHelper::setInputVal($model->countryNameCA->vCountryName, 'text') ?></dd>
                <dt>State</dt>
                <dd><?= CommonHelper::setInputVal($model->stateNameCA->vStateName, 'text') ?></dd>
                <dt>City</dt>
                <dd><?= CommonHelper::setInputVal($model->cityNameCA->vCityName, 'text') ?></dd>
                <dt>Distict</dt>
                <dd><?= CommonHelper::setInputVal($model->districtNameCA->vName, 'text') ?></dd>
                <dt>Taluks</dt>
                <dd><?= CommonHelper::setInputVal($model->talukaNameCA->vName, 'text') ?></dd>
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
                    $vFamilyProperty .= $family_property_array[$value] . ", ";
                }
                $vFamilyProperty = trim($vFamilyProperty, ", ")
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