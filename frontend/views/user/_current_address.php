<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

?>
<div class=
     <"div_basic_info">
    <?php
    if ($show) {
        $form = ActiveForm::begin([
            'id' => 'form-register11',
            'action' => ['edit-current-address'],
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

        <?= $form->field($model, 'iCountryCAId')->dropDownList(
            ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
            ['prompt' => 'Country', 'class' => 'demo-default select-beast clscurrentaddress',
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
            ['id' => 'iStateCAId',
                'prompt' => 'State', 'class' => 'demo-default select-beast clscurrentaddress',
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
            ['id' => 'iCityCAId', 'class' => 'demo-default select-beast clscurrentaddress', 'prompt' => 'City']
        ); ?>

        <?= $form->field($model, 'iDistrictCAID')->dropDownList(
            ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
            ['class' => 'demo-default select-beast clscurrentaddress', 'prompt' => 'District']
        ); ?>

        <?= $form->field($model, 'iTalukaCAID')->dropDownList(
            ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
            ['class' => 'demo-default select-beast clscurrentaddress', 'prompt' => 'Taluka']
        ); ?>

        <?= $form->field($model, 'vAreaNameCA')->textInput() ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="form-cont">
                    <div class="form-cont">
                        <input type="hidden" name="save" value="1">
                        <?= Html::submitButton('save', ['class' => 'btn btn-primary my-profile-sc-button', 'name' => 'register5']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= Html::Button('Cancel', ['class' => 'btn btn-primary my-profile-sc-button', 'id' => 'cancel_edit_current_address', 'name' => 'cancel']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();
        $this->registerJs('
           $(".edit_current_address").hide();
        ');
        $this->registerJs('
          selectboxClassWise("clscurrentaddress");
         ');
    } else {
        ?>
        <dl class="dl-horizontal">
            <dt>Area Name</dt>
            <dd><?= CommonHelper::setInputVal($model->vAreaNameCA, 'text') ?></dd>
            <?php $hide = '';
            if ($model->iCountryCAId != 101) {
                $hide = "display: none; ";
            } ?>

            <!--<dt>Taluks</dt>
            <dd><?/*=  CommonHelper::setInputVal($model->talukaNameCA->vName,'text') */ ?></dd>-->

            <div style="<?= $hide ?>">
            <dt>Distict</dt>
                <dd><?= CommonHelper::setInputVal($model->districtNameCA->vName, 'text') ?></dd>
            </div>

            <dt>City</dt>
            <dd><?= CommonHelper::setInputVal($model->cityNameCA->vCityName, 'text') ?></dd>
            <dt>State</dt>
            <dd><?= CommonHelper::setInputVal($model->stateNameCA->vStateName, 'text') ?></dd>
            <dt>Country</dt>
            <dd><?= CommonHelper::setInputVal($model->countryNameCA->vCountryName, 'text') ?></dd>
        </dl>

    <?php
        $this->registerJs('
           $(".edit_current_address").show();
        ');
    }
    ?>
</div>
