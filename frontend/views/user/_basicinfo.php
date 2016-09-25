<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-basic-info'],
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
    <?= $form->field($model, 'iReligion_ID')->dropDownList(
        ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
        ['prompt' => 'Religion']
    ); ?>
    <?= $form->field($model, 'iCommunity_ID')->dropDownList(
        ArrayHelper::map(CommonHelper::getCommunity(), 'iCommunity_ID', 'vName'),
        ['prompt' => 'Community']
    ); ?>
    <?= $form->field($model, 'iSubCommunity_ID')->dropDownList(
        ArrayHelper::map(CommonHelper::getSubCommunity(), 'iSubCommunity_ID', 'vName'),
        ['prompt' => 'Sub Community']
    ); ?>
    <?= $form->field($model, 'iGotraID')->dropDownList(
        ArrayHelper::map(CommonHelper::getGotra(), 'iGotraID', 'vName'),
        ['prompt' => 'Gotra']
    ); ?>
    <?= $form->field($model, 'iCountryId')->dropDownList(
        ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
        ['prompt' => 'Country',
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
            'prompt' => 'State',
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
        ['id' => 'iCityId', 'prompt' => 'City']
    ); ?>

    <?= $form->field($model, 'iDistrictID')->dropDownList(
        ArrayHelper::map(CommonHelper::getDistrict(), 'iDistrictID', 'vName'),
        ['prompt' => 'District']
    ); ?>

    <?= $form->field($model, 'iTalukaID')->dropDownList(
        ArrayHelper::map(CommonHelper::getTaluka(), 'iTalukaID', 'vName'),
        ['prompt' => 'Taluka']
    ); ?>

    <?= $form->field($model, 'vAreaName')->textInput(['autofocus' => true]) ?>
    <div class="row">
        <div class="">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>

        </div>
    </div>
    <?php ActiveForm::end();
} else {
    ?>
    <div class="div_basic_info">
        <dl class="dl-horizontal">
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
    </div>
    <?php
}