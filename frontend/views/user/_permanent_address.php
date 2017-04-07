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
            'action' => ['edit-permanent-address'],
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

        <?= $form->field($model, 'iCountryId')->dropDownList(
            ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
            ['prompt' => 'Country', 'class' => 'demo-default select-beast clspermanentaddress',
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
                                                                        $("select#iStateId").html(htmldata);
                                                                        // re-fill/set the selectize values
                                                                        var selectize = $("select#iStateId")[0].selectize;
                                                                        selectize.clear();
                                                                        selectize.clearOptions();
                                                                        selectize.renderCache["option"] = {};
                                                                        selectize.renderCache["item"] = {};

                                                                        selectize.addOption(new_value_options);
                                                                        //selectize.setValue(iStateId);

                                                                        var selectize = $("select#iCityId")[0].selectize;
                                                                        selectize.clear();
                                                                        selectize.clearOptions();

                                                            }
                                });'
            ]

        ); ?>
        <?php
        $stateList = [];
        if ($model->iCountryId != "") {
            $stateList = ArrayHelper::map(CommonHelper::getState($model->iCountryId), 'iStateId', 'vStateName');
        }
        ?>
        <?= $form->field($model, 'iStateId')->dropDownList(
            $stateList,
            ['id' => 'iStateId',
                'prompt' => 'State', 'class' => 'demo-default select-beast clspermanentaddress',
                'onchange' => '
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

        ); ?>
        <?php
        $cityList = [];
        if ($model->iStateId != "") {
            $cityList = ArrayHelper::map(CommonHelper::getCity($model->iStateId), 'iCityId', 'vCityName');
        }
        ?>
        <?= $form->field($model, 'iCityId')->dropDownList(
            $cityList,
            ['id' => 'iCityId', 'class' => 'demo-default select-beast clspermanentaddress', 'prompt' => 'City']
        ); ?>

        <?= $form->field($model, 'iDistrictID')->dropDownList(
            ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
            ['class' => 'demo-default select-beast clspermanentaddress', 'prompt' => 'District']
        ); ?>

        <?= $form->field($model, 'iTalukaID')->dropDownList(
            ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
            ['class' => 'demo-default select-beast clspermanentaddress', 'prompt' => 'Taluka']
        ); ?>

        <?= $form->field($model, 'vAreaName')->textInput() ?>
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
                        <?= Html::Button('Cancel', ['class' => 'btn btn-primary my-profile-sc-button', 'id' => 'cancel_edit_permanent_address', 'name' => 'cancel']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();
        $this->registerJs('
           $(".edit_permanent_address").hide();
        ');
        $this->registerJs('
          selectboxClassWise("clspermanentaddress");
         ');
    } else {
        ?>
        <dl class="dl-horizontal">
            <dt>Area Name</dt>
            <dd><?= $model->vAreaName ?></dd>
            <dt>Taluks</dt>
            <dd><?= $model->talukaName->vName; ?></dd>
            <dt>Distict</dt>
            <dd><?= $model->districtName->vName; ?></dd>
            <dt>City</dt>
            <dd><?= $model->cityName->vCityName; ?></dd>
            <dt>State</dt>
            <dd><?= $model->stateName->vStateName; ?></dd>
            <dt>Country</dt>
            <dd><?= $model->countryName->vCountryName; ?></dd>
        </dl>

    <?php
        $this->registerJs('
           $(".edit_permanent_address").show();
        ');
    }
    ?>
</div>
