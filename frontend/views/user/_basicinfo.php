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
        'id' => 'form-register1',
        'action' => ['edit-basic-info'],
        'options' => ['data-pjax' => true],
        'validateOnChange' => true,
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
    <?= $form->field($model, 'iReligion_ID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
        ['class' => 'demo-default select-beast clsbasicinfo', 'prompt' => 'Religion']
    ); ?>
    <?= $form->field($model, 'iCommunity_ID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getCommunity(), 'iCommunity_ID', 'vName'),
        ['class' => 'demo-default select-beast clsbasicinfo', 'prompt' => 'Community']
    ); ?>
    <?= $form->field($model, 'iSubCommunity_ID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getSubCommunity(), 'iSubCommunity_ID', 'vName'),
        ['class' => 'demo-default select-beast clsbasicinfo', 'prompt' => 'Sub Community']
    ); ?>
    <?= $form->field($model, 'iGotraID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getGotra(), 'iGotraID', 'vName'),
        ['class' => 'demo-default select-beast clsbasicinfo', 'prompt' => 'Gotra']
    ); ?>
    <?= $form->field($model, 'iMaritalStatusID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'),
        ['prompt' => 'Maritial Status',
            'class' => 'demo-default select-beast clsbasicinfo',
            'onchange' => '
                        var iMaritalStatusID = $(this).val();
                        if(iMaritalStatusID == "4" || iMaritalStatusID == "5"){
                          $("#noc_div").show();
                        }
                        else {
                          $("#noc_div").hide();
                          $("#noc").val("0");
                        }
                    '
        ]
    ); ?>
    <?php
        if($model->iMaritalStatusID == '4' || $model->iMaritalStatusID == '5'){
            $style = "display:block";
        }
        else {
            $style = "display:none";
        }
    ?>
    <div id="noc_div" style="<?=$style?>">
    <?= $form->field($model, 'noc')->input('number',['id'=>'noc']) ?>
    </div>
    <?= $form->field($model, 'iCountryId', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
        ['prompt' => 'Country', 'class' => 'demo-default select-beast clsbasicinfo',
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
    <?= $form->field($model, 'iStateId', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        $stateList,
        ['id' => 'iStateId',
            'prompt' => 'State', 'class' => 'demo-default select-beast clsbasicinfo',
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
    <?= $form->field($model, 'iCityId', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        $cityList,
        ['id' => 'iCityId', 'class' => 'demo-default select-beast clsbasicinfo', 'prompt' => 'City']
    ); ?>

    <?= $form->field($model, 'iDistrictID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
        ['class' => 'demo-default select-beast clsbasicinfo', 'prompt' => 'District']
    ); ?>

    <?= $form->field($model, 'iTalukaID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
        ['class' => 'demo-default select-beast clsbasicinfo', 'prompt' => 'Taluka']
    ); ?>

    <?= $form->field($model, 'vAreaName', [
    'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
    'labelOptions' => ['class' => ''],
])->textInput() ?>
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
                    <?= Html::Button('Cancel', ['class' => 'btn btn-primary my-profile-sc-button', 'id' => 'cancel_edit_basicinfo', 'name' => 'cancel']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end();
    $this->registerJs('
           $(".edit_basic_information").hide();
        ');
    $this->registerJs('
          selectboxClassWise("clsbasicinfo");
         ');
} else {
    ?>
    
        <dl class="dl-horizontal">
            <dt>Religion</dt>
            <dd><?= $model->religionName->vName; ?>
            <dd>
            <dt>Community</dt>
            <dd><?= $model->communityName->vName; ?></dd>
            <dt>Sub Community</dt>
            <dd><?= $model->subCommunityName->vName; ?><dd>
            <dt>Gotra</dt>
            <dd><?= $model->gotraName->vName; ?></dd>
            <dt>Marital Status</dt>
            <dd><?= $model->maritalStatusName->vName; ?></dd>
            <?php if ($model->noc > 0) { ?>
            <dt>Number Of Children</dt>
            <dd><?= $model->noc; ?></dd>
            <?php } ?>
            <dt>Country</dt>
            <dd><?= $model->countryName->vCountryName; ?></dd>
            <dt>State</dt>
            <dd><?= $model->stateName->vStateName; ?></dd>
            <dt>City</dt>
            <dd><?= $model->cityName->vCityName; ?></dd>
            <dt>Distict</dt>
            <dd><?= $model->districtName->vName; ?></dd>
            <dt>Taluks</dt>
            <dd><?= $model->talukaName->vName; ?></dd>
            <dt>Area Name</dt>
            <dd><?= $model->vAreaName ?></dd>
        </dl>
    
    <?php
    $this->registerJs('
           $(".edit_basic_information").show();
        ');
}
?>
</div>
