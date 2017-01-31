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

        <?= $form->field($model, 'iCountryId')->dropDownList(
            ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
            ['prompt' => 'Country', 'class' => 'demo-default select-beast clscurrentaddress',
                'onchange' => '
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax/getstate?id=') . '"+$(this).val(), function( data ) {
                                  $( "select#iStateId" ).html( data );
                                  $("select#iStateId").niceSelect("update");
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
                'prompt' => 'State', 'class' => 'demo-default select-beast clscurrentaddress',
                'onchange' => '
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax/getcity?id=') . '"+$(this).val(), function( data ) {
                                  $( "select#iCityId" ).html( data );
                                  $("select#iCityId").niceSelect("update");
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
            ['id' => 'iCityId', 'class' => 'demo-default select-beast clscurrentaddress', 'prompt' => 'City']
        ); ?>

        <?= $form->field($model, 'iDistrictID')->dropDownList(
            ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
            ['class' => 'demo-default select-beast clscurrentaddress', 'prompt' => 'District']
        ); ?>

        <?= $form->field($model, 'iTalukaID')->dropDownList(
            ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
            ['class' => 'demo-default select-beast clscurrentaddress', 'prompt' => 'Taluka']
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
          selectboxClassWise("clscurrentaddress");
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
    }
    ?>
</div>
