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
<?php
if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-family'],
        'options' => ['data-pjax' => true],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
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
    <?= $form->field($model, 'iFatherStatusID')->dropDownList(
        ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
        ['prompt' => 'Father Status']
    ); ?>

    <?= $form->field($model, 'iFatherWorkingAsID')->dropDownList(
        ArrayHelper::map(CommonHelper::getWorkingas(), 'iWorkingAsID', 'vWorkingAsName'),
        ['prompt' => 'Father Working AS']
    ); ?>

    <?= $form->field($model, 'iMotherStatusID')->dropDownList(
        ArrayHelper::map(CommonHelper::getFmstatus(), 'iFMStatusID', 'vName'),
        ['prompt' => 'Mother Status']
    ); ?>

    <?= $form->field($model, 'iMotherWorkingAsID')->dropDownList(
        ArrayHelper::map(CommonHelper::getWorkingAS(), 'iWorkingAsID', 'vWorkingAsName'),
        ['prompt' => 'Mother Working AS']
    ); ?>
    <?= $form->field($model, 'nob')->input('number', ['class' => 'input__field input__field--akira form-control']) ?>
    <?= $form->field($model, 'nos')->input('number', ['class' => 'input__field input__field--akira form-control']) ?>
    <?= $form->field($model, 'iCountryCAId')->dropDownList(
        ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
        [
            'prompt' => 'Country',
            'onchange' => '
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax/getstate?id=') . '"+$(this).val(), function( data ) {
                                  $( "select#iStateCAId" ).html( data );
                                  $("select#iStateCAId").niceSelect("update");
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
        [
            'id' => 'iStateCAId',
            'prompt' => 'State',
            'onchange' => '
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax/getcity?id=') . '"+$(this).val(), function( data ) {
                                  $( "select#iCityCAId" ).html( data );
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
        [
            'id' => 'iCityCAId',
            'prompt' => 'City'
        ]

    ); ?>
    <?= $form->field($model, 'iDistrictCAID')->dropDownList(
        ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
        [
            'prompt' => 'District'
        ]
    ); ?>
    <?= $form->field($model, 'iTalukaCAID')->dropDownList(
        ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
        [
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
        ['Affluent' => 'Affluent', 'Upper Middle Class' => 'Upper Middle Class', 'Middle Class' => 'Middle Class', 'Lower Middle Class' => 'Lower Middle Class'],
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
        ['Joint' => 'Joint', 'Nuclear' => 'Nuclear'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                return $return;
            }
        ]
    ); ?>

    <?php global $ABC;
    $ABC = $model->vFamilyProperty; ?>
    <?= $form->field($model, 'vFamilyProperty')->checkboxList(
        ['Ownership Flat' => 'Ownership Flat', 'Own Car' => 'Own Car'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                global $ABC;
                //if (in_array($value, explode(",",$model->vFamilyProperty))) { $checked='checked="checked"'; }else{$checked='';}
                $checked = (in_array($value, explode(",", $ABC))) ? 'checked' : '';
                $return = '<input type="checkbox" id="vFamilyProperty' . $label . '" name="' . $name . '" value="' . $value . '"' . $checked . '>';
                $return .= '<label for="vFamilyProperty' . $label . '" class="control-label toccl">' . $label . '</label>';
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

            <textarea class="input__field input__field--akira" cols="50" rows="5"
                      name="User[vDetailRelative]"><?= ($model->vDetailRelative) ?></textarea>
            <label class="input__label input__label--akira" for="input-22">
              <span
                  class="input__label-content input__label-content--akira">You can enter your relative surnames etc...</span> </label>
          </span>
        </div>
        </div>

    </div>
    <div class="row">
        <div class="">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
                        
        </div>
    </div>
    <?php ActiveForm::end();
} else {
    ?>
    <div class="div_family">
        <dl class="dl-horizontal">
            <dt>Father Status</dt>
            <dd><?= $model->fatherStatus->vName ?>
            <dd>
            <dt>Father Working As</dt>
            <dd><?= $model->fatherStatusId->vWorkingAsName; ?></dd>
            <dt>Mother Status</dt>
            <dd><?= $model->motherStatus->vName ?>
            <dd>
            <dt>Mother Working As</dt>
            <dd><?= $model->motherStatusId->vWorkingAsName; ?></dd>
            <dt>No of Brothers</dt>
            <dd><?= $model->nob; ?></dd>
            <dt>No of Sisters</dt>
            <dd><?= $model->nos; ?></dd>
            <dt>Country</dt>
            <dd><?= $model->countryNameCA->vCountryName; ?></dd>
            <dt>State</dt>
            <dd><?= $model->stateNameCA->vStateName; ?></dd>
            <dt>City</dt>
            <dd><?= $model->cityNameCA->vCityName; ?></dd>
            <dt>Distict</dt>
            <dd><?= $model->districtNameCA->vName; ?></dd>
            <dt>Taluks</dt>
            <dd><?= $model->talukaNameCA->vName; ?></dd>
            <dt>Area Name</dt>
            <dd><?= $model->vAreaName ?></dd>
            <dt>Native Place</dt>
            <dd><?= $model->vNativePlaceCA ?></dd>
            <dt>Parents Residing At</dt>
            <dd><?= $model->vParentsResiding ?></dd>
            <dt>Family Affluence Level</dt>
            <dd><?= $model->vFamilyAffluenceLevel; ?></dd>
            <dt>Family Type</dt>
            <dd><?= $model->vFamilyType ?></dd>
            <dt>Property Details</dt>
            <dd><?= $model->vFamilyProperty ?></dd>
            <dt>You can enter your relative surnames etc</dt>
            <dd><?= $model->vAreaName ?></dd>
        </dl>
    </div>
    <?php
}