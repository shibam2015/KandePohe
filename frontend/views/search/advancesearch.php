<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\components\CommonHelper;
use common\components\MessageHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

$id = 0;
$PROFILE_COMPLETENESS = 50;

if (!Yii::$app->user->isGuest) {
    $Id = Yii::$app->user->identity->id;
}

$HOME_URL = Yii::getAlias('@web') . "/";
$HOME_URL_SITE = Yii::getAlias('@web') . "/site/";
$UPLOAD_DIR = Yii::getAlias('@frontend') . '/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') . '/web/';

$M1 = array();
?>

<div class="main-section">
    <?php
    if (!Yii::$app->user->isGuest) {
        echo $this->render('/layouts/parts/_headerafterlogin');
    } else {
        echo $this->render('/layouts/parts/_headerregister.php');
    }
    ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="gray-tabs-block mrg-tp-30">
                        <div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="#tab1" aria-controls="Basic Search" role="tab" data-toggle="tab">Basic Search</a></li>
                                <li role="presentation" class="active"><a href="#tab2" aria-controls="Advanced Search" role="tab" data-toggle="tab">Advanced Search</a></li>
                                <li role="presentation"><a href="#tab3" aria-controls="My Saved Searches" role="tab" data-toggle="tab">My Saved Searches</a></li>
                                <li class="dropdown search-profile pull-right"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/prof-search-icon.jpg" width="26" height="17"> Search By Profile ID</a>
                                    <ul class="dropdown-menu">
                                        <div class="pop-over">
                                            <form class="form-inline">
                                                <button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-search text-danger"></i></button>
                                                <input type="text" class="form-control pull-left" placeholder="Enter Profile ID">
                                            </form>
                                        </div>
                                    </ul>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="tab1">
                                    <p>Under Construction...</p>
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="tab2">
                                <?php
$form = ActiveForm::begin([
    'id' => 'formsearch',
    'action' => ['search/basic-search'],
    'options' => ['data-pjax' => true],
    'layout' => 'horizontal',
    'validateOnChange' => false,
    'validateOnSubmit' => true,
    'fieldConfig' => [
        'template' => "{label}{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-3 col-xs-3',
            'offset' => '',
            'wrapper' => 'col-sm-12 col-xs-12',
            'error' => '',
            'hint' => '',
        ]
    ]
]);
?>

                                    <div class="bs-accordian">
                                        <div class="panel-group" id="accordion">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseOne1">
                                                    <h4 class="panel-title">Basic Details <i class="fa fa-angle-up indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapseOne1" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <div class="radio-wrapper">
                                                            <div class="radio dl" id="IVA">
                                                                <dt>Skin Tone: </dt>
                                                                <dd>
                                                                    <?= $form->field($TempModel, 'vSkinTone')->RadioList(
                                                                        ArrayHelper::map(CommonHelper::getSkinTone(), 'ID', 'Name'),
                                                                        ['item' => function ($index, $label, $name, $checked, $value) {
                                                                            $checked = ($checked) ? 'checked' : '';
                                                                            $return = '<input type="radio" id="vSkinTone_' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                                            $return .= '<label for="vSkinTone_' . $value . '">' . ucwords($label) . '</label>';
                                                                            return $return;
                                                                        }
                                                                        ]
                                                                    )->label(false)->error(false); ?>
                                                                </dd>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $heightrange = range(134, 204);
                                                        $range = range(18, 100);
                                                        ?>
                                                        <div class="mid-col xs-col mrg-bt-20">
                                                            <div class="form-cont">
                                                                <label for="Height" class="hide"></label>
                                                                   <?= $form->field($TempModel, 'AgeFrom')->dropDownList(
    array_combine($range, $range),
    ['prompt' => 'Minimum Age',
        'class' => 'cs-select cs-skin-border nice-select-cls',]
); ?>
                                                            </div>
                                                        </div>
                                                        <div class="mid-col xs-col mrg-lt-15 mrg-bt-20">
                                                            <div class="form-cont">
                                                                <label for="Height" class="hide"></label>
                                                               <?= $form->field($TempModel, 'AgeTo')->dropDownList(
                                                                    array_combine($range, $range),
    ['prompt' => 'Maximum Age',
        'class' => 'cs-select cs-skin-border nice-select-cls',]
); ?>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="mid-col xs-col mrg-bt-20">
                                                            <div class="form-cont">
                                                                <label for="Height" class="hide"></label>

                                                                    <?= $form->field($TempModel, 'height')->dropDownList(
    ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
    ['prompt' => 'Minimum Height',
        'class' => 'cs-select cs-skin-border nice-select-cls',]
); ?>

                                                            </div>
                                                        </div>
                                                        <div class="mid-col xs-col mrg-lt-15 mrg-bt-20">
                                                            <div class="form-cont">
                                                                <label for="Height" class="hide"></label>
                                                                <?= $form->field($TempModel, 'height')->dropDownList(
                                                                    ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
    ['prompt' => 'Maximum Height',
        'class' => 'cs-select cs-skin-border nice-select-cls',]
); ?>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Marital Status</label>
                                                            <?= $form->field($TempModel, 'vName')->dropDownList(
                                                                ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'),
                                                                ['class' => 'multiselect select4 tag-select-box',
                                                                    //'id' => 'activate_selectator4',
                                                                    'multiple' => 'multiple',
                                                                ]
                                                            )->label(false)->error(false); ?>
                                                                                                                                <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Religion</label>
                                                                <?= $form->field($TempModel, 'iReligion_ID')->dropDownList(
    ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
    ['class' => 'multiselect select4 tag-select-box',
        //'id' => 'activate_selectator4',
        'multiple' => 'multiple',
    ]

)->label(false)->error(false); ?>
                                                            <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Mother Tongue</label>
                                                            <?= $form->field($TempModel, 'Name')->dropDownList(
                                                                ArrayHelper::map(CommonHelper::getMotherTongue(), 'ID', 'Name'),
                                                                ['class' => 'multiselect select4 tag-select-box',
                                                                    'multiple' => 'multiple',
                                                                ]

                                                            )->label(false)->error(false); ?>
                                                            <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Community</label>
                                                            <?= $form->field($TempModel, 'iCommunity_ID')->dropDownList(
                                                                ArrayHelper::map(CommonHelper::getCommunity(), 'iCommunity_ID', 'vName'),
                                                                ['class' => 'multiselect select4 tag-select-box',
                                                                    //'id' => 'activate_selectator4',
                                                                    'multiple' => 'multiple',
                                                                ]
                                                            )->label(false)->error(false); ?>
                                                            <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="radio-wrapper mrg-bt-30">

                                                            <div class="radio dl" id="IVA">
                                                                <dd>
                                                                    <input id="cast" type="radio" name="cast"
                                                                           value="cast">
                                                                    <label for="cast">Select from list</label>
                                                                    <input id="cast" type="radio" name="cast2"
                                                                           value="cast2">
                                                                    <label for="fair">Only Members who selected Cast Not Bar</label>
                                                                    <a href="#" data-toggle="tooltip"
                                                                       data-placement="right"
                                                                       title="This is where the help text will appear when the mouse hovers over the help icon"> <?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?> </a>
                                                                </dd>
                                                            </div>

                                                        </div>
                                                        <div class="radio-wrapper manglik">

                                                            <div class="radio dl" id="IVA">
                                                                <dt class="xs-col mrg-bt-10">Mangalik/<br>
                                                                    Chewai Dosham: </dt>
                                                                <dd>
                                                                    <input id="Does not matter" type="radio" checked="checked" name="manglik" value="Does not matter">
                                                                    <label for="Does not matter">Does not matter</label>
                                                                    <input id="Only Mangaliks" type="radio" name="manglik" value="Only Mangaliks">
                                                                    <label for="Only Mangaliks">Only Mangaliks</label>
                                                                    <input id="No Mangaliks" type="radio" name="manglik" value="No Mangaliks">
                                                                    <label for="No Mangaliks">No Mangaliks</label>
                                                                    <input id="Gothra" type="radio" name="manglik"
                                                                           value="Gothra">
                                                                    <label for="Donot include my Gothra" class="mrg-bt-10">Donot include my Gothra</label>
                                                                </dd>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                    <h4 class="panel-title">Location and Place Grown Up At <i class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Country</label>
                                                            <?= $form->field($TempModel, 'vCountryName')->dropDownList(
                                                                ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
                                                                ['class' => 'multiselect select4 tag-select-box',
                                                                    'prompt' => 'Country',
                                                                    'onchange' => '
                                                                    $.post( "' . Yii::$app->urlManager->createUrl('ajax/getstate?id=') . '"+$(this).val(), function( data ) {
                                                                      $( "select#iStateId" ).html( data );
                                                                      $("select#iStateId").niceSelect("update");
                                                                    });'
                                                                ]

                                                            )->label(false)->error(false); ?>
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">State</label>
                                                            <?php
                                                            $stateList = [];
                                                            if ($TempModel->iCountryId != "") {
                                                                $stateList = ArrayHelper::map(CommonHelper::getState($TempModel->iCountryId), 'iStateId', 'vStateName');
                                                            }
                                                            ?>
                                                            <?= $form->field($TempModel, 'vStateName')->dropDownList(
                                                                $stateList,
                                                                ['class' => 'multiselect select4 tag-select-box',
                                                                    'id' => 'iStateId',
                                                                    'prompt' => 'State',
                                                                    'onchange' => '
                                                                    $.post( "' . Yii::$app->urlManager->createUrl('ajax/getcity?id=') . '"+$(this).val(), function( data ) {
                                                                      $( "select#iCityId" ).html( data );
                                                                      $("select#iCityId").niceSelect("update");
                                                                    });']
                                                            )->label(false)->error(false); ?>
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">City</label>
                                                            <?php
                                                            $cityList = [];
                                                            if ($TempModel->iStateId != "") {
                                                                $cityList = ArrayHelper::map(CommonHelper::getCity($TempModel->iStateId), 'iCityId', 'vCityName');
                                                            }
                                                            ?>
                                                            <?= $form->field($TempModel, 'vCityName')->dropDownList(
                                                                $cityList,
                                                                ['class' => 'multiselect select4 tag-select-box',
                                                                    'id' => 'iCityId',
                                                                    'prompt' => 'City'
                                                                ]

                                                            )->label(false)->error(false); ?>
                                                        </div>

                                                        <input value="activate selectator" id="activate_selectator4"
                                                               type="hidden">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                                    <h4 class="panel-title">Education &amp; Profession Details <i class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapseThree" class="panel-collapse collapse">
                                                    <div class="panel-body">

                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Education Level</label>
                                                            <?= $form->field($TempModel, 'vEducationLevelName')->dropDownList(
    ArrayHelper::map(CommonHelper::getEducationLevel(), 'iEducationLevelID', 'vEducationLevelName'),
    ['class' => 'multiselect select4 tag-select-box',
        'multiple' => 'multiple',
    ]
)->label(false)->error(false); ?>
                                                            <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Education Name</label>
                                                            <?= $form->field($TempModel, 'vEducationFieldName')->dropDownList(
                                                                ArrayHelper::map(CommonHelper::getEducationField(), 'iEducationFieldID', 'vEducationFieldName'),
                                                                ['class' => 'multiselect select4 tag-select-box',
                                                                    'multiple' => 'multiple',
                                                                ]
                                                            )->label(false)->error(false); ?>
                                                            <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Working With</label>
                                                            <?= $form->field($TempModel, 'iWorkingWithID')->dropDownList(
    ArrayHelper::map(CommonHelper::getWorkingWith(), 'iWorkingWithID', 'vWorkingWithName'),
    ['class' => 'multiselect select4 tag-select-box',
        'multiple' => 'multiple',
    ]
)->label(false)->error(false); ?>
                                                            <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Working As</label>
                                                            <?= $form->field($TempModel, 'vWorkingAsName')->dropDownList(
    ArrayHelper::map(CommonHelper::getWorkingAS(), 'iWorkingAsID', 'vWorkingAsName'),
    ['class' => 'multiselect select4 tag-select-box',
        'multiple' => 'multiple',
    ]
)->label(false)->error(false); ?>
                                                            <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Annual Income</label>
                                                            <?= $form->field($TempModel, 'vAnnualIncome')->dropDownList(
    ArrayHelper::map(CommonHelper::getAnnualIncome(), 'iAnnualIncomeID', 'vAnnualIncome'),
    ['class' => 'multiselect select4 tag-select-box',
        'multiple' => 'multiple',
    ]
)->label(false)->error(false); ?>
                                                            <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapsefour">
                                                    <h4 class="panel-title">Lifestyle &amp; Appearance Details <i class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapsefour" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Height</label>
                                                            <?= $form->field($TempModel, 'vName')->dropDownList(
    ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
    ['class' => 'multiselect select4 tag-select-box',
        'multiple' => 'multiple',
    ]
)->label(false)->error(false); ?>
                                                                                                                                <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="radio-wrapper">
                                                            <div class="radio dl" id="IVA">
                                                                <dt>Skin Tone: </dt>
                                                                <dd>
                                                                    <?= $form->field($TempModel, 'vSkinTone')->RadioList(
    ArrayHelper::map(CommonHelper::getSkinTone(), 'ID', 'Name'),
    ['item' => function ($index, $label, $name, $checked, $value) {
        $checked = ($checked) ? 'checked' : '';
        $return = '<input type="radio" id="vSkinTone_' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
        $return .= '<label for="vSkinTone_' . $value . '">' . ucwords($label) . '</label>';
        return $return;
    }
    ]
)->label(false)->error(false); ?>
                                                                </dd>
                                                            </div>
                                                        </div>
                                                        <div class="radio-wrapper">
                                                            <div class="radio dl" id="IVA">
                                                                <dt>Body Type: </dt>
                                                                <dd>
                                                                     <?= $form->field($TempModel, 'vBodyType')->RadioList(
                                                                         ArrayHelper::map(CommonHelper::getBodyType(), 'ID', 'Name'),
                                                                         [
                                                                             'item' => function ($index, $label, $name, $checked, $value) {
                                                                                 $checked = ($checked) ? 'checked' : '';
                                                                                 $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                                                 $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                                                                                 return $return;
                                                                             }
                                                                         ]
                                                                     )->label(false)->error(false); ?>
                                                                </dd>
                                                            </div>
                                                        </div>
                                                        <div class="radio-wrapper">
                                                            <div class="radio dl" id="IVA">
                                                                <dt>Smoke: </dt>
                                                                <dd>
                                                                     <?= $form->field($TempModel, 'vSmoke')->RadioList(
                                                                         ['Smoke_Yes' => 'Yes', 'Smoke_No' => 'No', 'Smoke_Occasionally' => 'Occasionally'],
                                                                         [
                                                                             'item' => function ($index, $label, $name, $checked, $value) {
                                                                                 $checked = ($checked) ? 'checked' : '';
                                                                                 $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                                                 $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                                                                                 return $return;
                                                                             }

                                                                         ]
                                                                     )->label(false)->error(false); ?>
                                                                </dd>
                                                            </div>
                                                        </div>
                                                        <div class="radio-wrapper">
                                                            <div class="radio dl" id="IVA">
                                                                <dt>Drink: </dt>
                                                                <dd>
                                                                     <?= $form->field($TempModel, 'vDrink')->RadioList(
    ['Drink_Yes' => 'Yes', 'Drink_No' => 'No', 'Drink_Occasionally' => 'Occasionally'],
    [
        'item' => function ($index, $label, $name, $checked, $value) {
            $checked = ($checked) ? 'checked' : '';
            $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
            $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
            return $return;
        }
    ]
)->label(false)->error(false); ?>
                                                                </dd>
                                                            </div>
                                                        </div>
                                                        <div class="radio-wrapper">
                                                            <div class="radio dl" id="IVA">
                                                                <dt>Spectacles Lens: </dt>
                                                                <dd>
                                                                      <?= $form->field($TempModel, 'vSpectaclesLens')->RadioList(
    ['SpectaclesLens_Spectacles' => 'Spectacles', 'SpectaclesLens_Lens' => 'Lens'],
    [
        'item' => function ($index, $label, $name, $checked, $value) {
            $checked = ($checked) ? 'checked' : 'checked';
            $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
            $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
            return $return;
        }

    ]
)->label(false)->error(false); ?>
                                                                </dd>
                                                            </div>
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Diet</label>
                                                            <?= $form->field($TempModel, 'vDiet')->dropDownList(
                                                                ArrayHelper::map(CommonHelper::getDiet(), 'iDietID', 'vName'),
                                                                ['class' => 'multiselect select4 tag-select-box',
                                                                    'multiple' => 'multiple',
                                                                ]
                                                            )->label(false)->error(false); ?>
                                                                                                                                <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <div class="mid-col"><!--error-field-->
                                                                <div class="form-cont">
                                                            <label for="select4">Weight</label>
                                                                    <?= $form->field($TempModel, 'weight', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Weight</span> </label></span>'])->input('number', ['class' => 'input__field input__field--akira form-control']
                                                                    )->label(false)->error(false); ?>
                                                                                                                                <input value="activate selectator" id="activate_selectator4" type="hidden">
                                                        </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapsefive">
                                                    <h4 class="panel-title">Search By Keywords <i class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapsefive" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p>Under Construction...</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapsesix">
                                                    <h4 class="panel-title">General Details <i class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapsesix" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="checkbox-wrapper">
                                                            <div class="checkbox">
                                                                <dt class="xs-col">Photo Setting</dt>
                                                                <dd>
                                                                    <input id="Remember" type="checkbox" name="Remember" value="check1">
                                                                    <label for="Remember" class="control-label">Visible to All</label>
                                                                    <input id="Photo" type="checkbox" name="Photo" value="check1">
                                                                    <label for="Photo" class="control-label">Protected Photo</label>
                                                                    <a href="#" data-toggle="tooltip"
                                                                       data-placement="right"
                                                                       title="This is where the help text will appear when the mouse hovers over the help icon"> <?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?> </a>
                                                                </dd>
                                                            </div>
                                                            <div class="checkbox">
                                                                <dt class="xs-col">Photo Created by</dt>
                                                                <dd>
                                                                    <input id="dm" type="checkbox" name="pic" value="check1">
                                                                    <label for="dm" class="control-label">Does'nt matter</label>
                                                                    <input id="self" type="checkbox" name="pic" value="check1">
                                                                    <label for="self" class="control-label">Self</label>
                                                                    <input id="Parent" type="checkbox" name="pic" value="check1">
                                                                    <label for="Parent" class="control-label">Parent/ Guardian</label>
                                                                    <input id="Sibling" type="checkbox" name="pic" value="check1">
                                                                    <label for="Sibling" class="control-label">Sibling/ Friend</label>
                                                                </dd>
                                                            </div>
                                                            <div class="radio-wrapper">

                                                                <div class="radio dl" id="IVA">
                                                                    <dt class="xs-col">Has Horoscope: </dt>
                                                                    <dd>
                                                                        <input id="matter1" type="radio" checked="checked" name="matter" value="Very Fair">
                                                                        <label for="matter1">Does'nt matter</label>
                                                                        <input id="matter2" type="radio" name="matter" value="Fair">
                                                                        <label for="matter2">No</label>
                                                                    </dd>
                                                                </div>

                                                            </div>
                                                            <div class="checkbox">
                                                                <dt class="xs-col">Donot Show:</dt>
                                                                <dd>
                                                                    <input id="Remember" type="checkbox" name="Remember" value="check1">
                                                                    <label for="Remember" class="control-label">Profiles that have filtered me out</label>
                                                                    <input id="Photo" type="checkbox" name="Photo" value="check1">
                                                                    <label for="Photo" class="control-label">Profiles that have already
                                                                        viewed</label>
                                                                </dd>
                                                            </div>
                                                            <h3 class="heading-xs mrg-bt-20">Save upto 5 Searches</h3>
                                                            <div class="form-cont mid-col mrg-bt-20">
                              <span class="input input--akira">
                                <input class="input__field input__field--akira" type="text">
                                <label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Save Search as (e.g Mumbai, 20-22)</span> </label>
                                </span> </div>
                                                            <div class="mid-col mrg-tp-10">

                                                                <div class="form-cont">
                                                                    <label for="Community" class="hide"></label>
                                                                    <select id="Community" class="cs-select cs-skin-border">
                                                                        <option value="Community" disabled selected>Select Saved Search</option>
                                                                        <option value="option 1">option 1</option>
                                                                        <option value="option 2">option 2</option>
                                                                        <option value="option 3">option 3</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix mrg-bt-20"></div>
                                                            <div class="radio-wrapper">

                                                                <div class="radio dl" id="IVA">
                                                                    <dt class="xs-col">Email me New Results: </dt>
                                                                    <dd>
                                                                        <input id="Daily" type="radio" checked="checked" name="Email" value="Daily">
                                                                        <label for="Daily">Daily</label>
                                                                        <input id="Twice" type="radio" name="Email" value="Twice">
                                                                        <label for="Twice">Twice a week</label>
                                                                        <input id="Once" type="radio" name="Email" value="Once">
                                                                        <label for="Once">Once a week</label>
                                                                        <input id="Never" type="radio" name="Email" value="Never">
                                                                        <label for="Never">Never</label>
                                                                    </dd>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline filter-buttons">
                                        <li class="pull-right">
                                            <input type="button" name="SAVE SEARCH" value="SAVE SEARCH" class="btn btn-primary">
                                        </li>
                                        <li class="pull-right"> <a href="#" class="btn btn-custom"><strong>RESET</strong></a> </li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <?php ActiveForm::end(); ?>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab3">
                                    <p>Under Construction...</p>
                                </div>
                            </div>
                            <div class="bg-white padd-20 mrg-bt-20">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mrg-bt-30"><a href="#" class="pull-right">See All</a>
                                            <h3 class="heading-xs">Matches near your city</h3></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <ul class="list-unstyled ad-prof">
                                            <li><span
                                                    class="imgarea"><?= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile', 'class' => '']); ?></span> <span
                                                    class="img-desc">
                  <p class="name"><strong>Ishita J</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>
                                                <div class="clearfix"></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-4">
                                        <ul class="list-unstyled ad-prof">
                                            <li><span
                                                    class="imgarea"><?= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile', 'class' => '']); ?></span> <span
                                                    class="img-desc">
                  <p class="name"><strong>Ishita J</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>
                                                <div class="clearfix"></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-4">
                                        <ul class="list-unstyled ad-prof">
                                            <li><span
                                                    class="imgarea"><?= Html::img('@web/images/profile1.jpg', ['width' => '', 'height' => '', 'alt' => 'Profile', 'class' => '']); ?></span> <span
                                                    class="img-desc">
                  <p class="name"><strong>Ishita J</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>
                                                <div class="clearfix"></div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3 col-sm-12">
                   <div class="row">
                     <div class="map mrg-tp-30"><iframe width="100%" height="700" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.uk/maps?f=q&source=s_q&hl=en&geocode=&q=15+Springfield+Way,+Hythe,+CT21+5SH&aq=t&sll=52.8382,-2.327815&sspn=8.047465,13.666992&ie=UTF8&hq=&hnear=15+Springfield+Way,+Hythe+CT21+5SH,+United+Kingdom&t=m&z=14&ll=51.077429,1.121722&output=embed"></iframe> </div>
                   </div>
                 </div>-->
            </div>
        </div>
      </div>

</div>
<?php
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/slider.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/fm.selectator.jquery.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/cover/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/fm.selectator.jquery.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<style>
    .form-horizontal .control-label {
        padding-top: 0px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 0px;
    }

    .mid-col {
        max-width: 600px;
        margin-left: 0px;
    }
</style>