<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

?>
<div id="div_personal_info1">
    <?php
    if ($show) {
        $form = ActiveForm::begin([
            'id' => 'form',
            //'enableClientValidation'=> true,
            'enableAjaxValidation' => false,
            'validateOnSubmit' => false,
            'validateOnChange' => false,
            'action' => ['edit-personal-info'],
            'options' => ['data-pjax' => true],
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
        <?= $form->errorSummary($model, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
        <?= $form->field($model, 'First_Name',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ]
        )->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'Last_Name',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ])->textInput() ?>
        <?= $form->field($model, 'Gender', [
            'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
            'labelOptions' => ['class' => ''],
        ])->RadioList(
            ['MALE' => 'MALE', 'FEMALE' => 'FEMALE'],
            [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $checked = ($checked) ? 'checked' : '';
                    $return = '<input type="radio" class = "genderV" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                    $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                    return $return;
                }
            ]
        )
        ?>
        <?= $form->field($model, 'DOB',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ]
        )->textInput()
            ->widget(\yii\jui\DatePicker::classname(),
                [
                    'dateFormat' => 'php:Y-m-d',
                    'options' => [
                        'id' => 'DOB',
                        'class' => 'form-control',
                        'onkeyup' => ' $(".hasDatepicker").val("");',
                    ],
                    'clientOptions' => [
                        'changeMonth' => true,
                        'yearRange' => '-70:-21',
                        'changeYear' => true,
                        'maxDate' => date('Y-m-d', strtotime('-21 year')),
                    ]

                ]);
        ?>

        <?= $form->field($model, 'Profile_created_for',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ]
        )->dropDownList(
            Yii::$app->params['profileFor'],
            ['class' => 'demo-default select-beast clspersonalinfo', 'prompt' => 'Profile For']
        ); ?>
        <!--<?= $form->field($model, 'county_code')->dropDownList(
            ['+91' => '+91'],
            ['class' => 'demo-default select-beast clspersonalinfo', 'prompt' => 'Country Code']
        )
        ?>
        <?= $form->field($model, 'Mobile')->input('text') ?> -->
        <?= $form->field($model, 'mother_tongue',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ])->dropDownList(
            ArrayHelper::map(CommonHelper::getMotherTongue(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast clspersonalinfo', 'prompt' => 'Mother Tongue']
        ); ?>

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
        if ($model->iMaritalStatusID == '4' || $model->iMaritalStatusID == '5') {
            $style = "display:block";
        } else {
            $style = "display:none";
        }
        ?>
        <div id="noc_div" style="<?= $style ?>">
            <?= $form->field($model, 'noc')->input('number', ['id' => 'noc']) ?>
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

                                                                         if(data.CountryId == 101){
                                                                            $(".user_idistrictid_div").hide();
                                                                            var selectize = $("select#user-idistrictid")[0].selectize;
                                                                            selectize.clear();
                                                                            selectize.setValue(1);
                                                                            $(".user_iTalukaID_div").hide();
                                                                            var selectize = $("select#user-italukaid")[0].selectize;
                                                                            selectize.clear();
                                                                            selectize.setValue(1);
                                                                        }else{
                                                                            $(".user_idistrictid_div").show();
                                                                            $(".user_iTalukaID_div").show();
                                                                            var selectize = $("select#user-idistrictid")[0].selectize;
                                                                            selectize.clear();
                                                                            var selectize = $("select#user-italukaid")[0].selectize;
                                                                            selectize.clear();
                                                                        }

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
        <?php $hide = '';
        if ($model->iCountryId == 101) {
            $hide = "display: none; ";
        } ?>
        <div class="user_idistrictid_div"
             style="<?= $hide ?>">
        <?= $form->field($model, 'iDistrictID', [
            'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
            'labelOptions' => ['class' => ''],
        ])->dropDownList(
            ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
            ['class' => 'demo-default select-beast clsbasicinfo', 'prompt' => 'District']
        ); ?>
        </div>
        <div class="box user_iTalukaID_div"
             style="<?= $hide ?>">
        <?= $form->field($model, 'iTalukaID', [
            'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
            'labelOptions' => ['class' => ''],
        ])->dropDownList(
            ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
            ['class' => 'demo-default select-beast clsbasicinfo', 'prompt' => 'Taluka']
        ); ?>
        </div>
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
                        <?= Html::submitButton('save', ['class' => 'btn btn-primary  my-profile-sc-button preferences_submit', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_personalinfo', 'name' => 'cancel']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();

        $this->registerJs('
          selectboxClassWise("clspersonalinfo");
           selectboxClassWise("clsbasicinfo");
         ');
        $this->registerJs('
        $(".genderV").on("change",function(e){
          var genderVal = $(this).val();
          if(genderVal == "FEMALE") {
            $("#DOB").datepicker("option","maxDate","'.date('Y-m-d',strtotime('-18 year')).'");
            $("#DOB").datepicker("option","yearRange","-70:-18");
          }
          else {
            $("#DOB").datepicker("option","maxDate","'.date('Y-m-d',strtotime('-21 year')).'");
            $("#DOB").datepicker("option","yearRange","-70:-21");
          }
        });
      ');
    } else {
        ?>

        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd><?= $model->FullName; ?><dd>
            <dt>Profile created by</dt>
            <dd><?= $model->Profile_created_for; ?></dd>
            <dt>Date Of Birth</dt>
            <dd><?= $model->DOB; ?><dd>
            <dt>Age</dt>
            <dd><?= CommonHelper::getAge($model->DOB);?> years<dd>
            <dt>Gender</dt>
            <dd><?= $model->Gender ?></dd>
            <!--  <dt>Mobile</dt>
            <dd><?/*= $model->county_code." ".$model->Mobile; */ ?></dd>-->
            <dt>Mother Tongue</dt>
            <dd><?= CommonHelper::setInputVal($model->motherTongue->Name, 'text') ?></dd>

            <dt>Religion</dt>
            <dd><?= $model->religionName->vName; ?>
            <dd>
            <dt>Community</dt>
            <dd><?= $model->communityName->vName; ?></dd>
            <dt>Sub Community</dt>
            <dd><?= $model->subCommunityName->vName; ?>
            <dd>
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
            <?php $hide = '';
            if ($model->iCountryId == 101) {
                $hide = "display: none; ";
            } ?>

            <div style="<?= $hide ?>">
            <dt>Distict</dt>
            <dd><?= $model->districtName->vName; ?></dd>
            <dt>Taluks</dt>
            <dd><?= $model->talukaName->vName; ?></dd>
            </div>
            <dt>Area Name</dt>
            <dd><?= $model->vAreaName ?></dd>

        </dl>
        <?php
        if ($popup) {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'CHANGE_PHONE_NUMBER');
            $this->registerJs('
                    //notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
                    $(".modal").on("hidden.bs.modal", function (e) {
                        //window.location.href = "' . Yii::$app->homeUrl . 'site/verification";
                    })
                ');
        }
    }
    ?>


</div>