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
<div class="div_preferences">
<?php
if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-preferences'],
        'options' => ['data-pjax' => true],
        'layout' => 'horizontal',
        'validateOnChange' => false,
        'validateOnSubmit' => true,
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
    <?= $form->errorSummary([$PartenersReligion],['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
        <?= $form->field($PartenersReligion, 'iReligion_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
            ['prompt' => 'Religion']
        ); ?>
        <?php
            $range = range(18, 100);
        ?>
        <?= $form->field($UPP, 'age_from')->dropDownList(
            array_combine($range, $range),
            ['prompt' => 'Age From']
        ); ?>

        <?= $form->field($UPP, 'age_to')->dropDownList(
            array_combine($range, $range),
            ['prompt' => 'Age To']
        ); ?>

    <div class="row">
        <div class="">
            <input type="hidden" name="save" value="1">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
            <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_preferences', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>
        </div>
    </div>
    <?php ActiveForm::end();
} else {
    ?>
   
        <dl class="dl-horizontal">
            <dt>Religion</dt>
            <dd><?= $PartenersReligion->religionName->vName ?><dd>
            <dt>Age From</dt>
            <dd><?= $UPP->age_from ?><dd>
            <dt>Age To</dt>
            <dd><?= $UPP->age_to ?><dd>
        </dl>
  
    <?php
}
?>
  </div>