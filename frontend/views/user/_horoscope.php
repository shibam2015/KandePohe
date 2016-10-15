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
<div class="div_horoscope">
    <?php
    if ($show) {
        $form = ActiveForm::begin([
            'id' => 'form',
            'action' => ['edit-horoscope'],
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
        <?= $form->field($model, 'RaashiId')->dropDownList(
            ArrayHelper::map(CommonHelper::getRaashi(), 'ID', 'Name'),
            ['prompt' => 'Raashi']
        ); ?>
        <?= $form->field($model, 'NakshtraId')->dropDownList(
            ArrayHelper::map(CommonHelper::getNaksatra(), 'ID', 'Name'),
            ['prompt' => 'Nakshtra']
        ); ?>
        <?= $form->field($model, 'CharanId')->dropDownList(
            ArrayHelper::map(CommonHelper::getCharan(), 'ID', 'Name'),
            ['prompt' => 'Charan']
        ); ?>
        <?= $form->field($model, 'NadiId')->dropDownList(
            ArrayHelper::map(CommonHelper::getNadi(), 'ID', 'Name'),
            ['prompt' => 'Nadi']
        ); ?>
        <?= $form->field($model, 'iGotraID')->dropDownList(
            ArrayHelper::map(CommonHelper::getMasterGotra(), 'iGotraID', 'vName'),
            ['prompt' => 'Gotra']
        ); ?>
        <?= $form->field($model, 'Mangalik')->RadioList(
            ['Yes' => 'Yes', 'No' => 'No'],
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
        <div class="row">
            <div class="">
                <input type="hidden" name="save" value="1">
                <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_horoscope', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>
            </div>
        </div>
        <?php ActiveForm::end();
    } else {
        ?>

        <dl class="dl-horizontal">
            <dt>Raashi</dt>
            <dd><?= CommonHelper::setInputVal($model->raashiName->Name, 'text') ?>
            <dd>
            <dt>Charan</dt>
            <dd><?= CommonHelper::setInputVal($model->charanName->Name, 'text') ?>
            <dd>
            <dt>Nakshtra</dt>
            <dd><?= CommonHelper::setInputVal($model->nakshtraName->Name, 'text') ?>
            <dd>
            <dt>Nadi</dt>
            <dd><?= CommonHelper::setInputVal($model->nadiName->Name, 'text') ?>
            <dd>
            <dt>Gotra</dt>
            <dd><?= CommonHelper::setInputVal($model->gotraName->vName, 'text') ?>
            <dd>
            <dt>Mangalik</dt>
            <dd><?= $model->Mangalik ?></dd>
        </dl>

    <?php
    }
    ?>
</div>