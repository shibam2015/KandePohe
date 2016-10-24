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
<div class="div_lifestyle">
<?php
if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-lifestyle'],
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
    <?= $form->errorSummary($model,['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
    <?= $form->field($model, 'iHeightID')->dropDownList(
        ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
        ['prompt' => 'Height']
    ); ?>

    <?= $form->field($model, 'vSkinTone')->RadioList(
        ['Very Fair' => 'Very Fair', 'Fair' => 'Fair', 'Wheatish' => 'Wheatish', 'Dark' => 'Dark'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                return $return;
            }

        ]
    ) ?>

    <?= $form->field($model, 'vBodyType')->RadioList(
        ['Slim' => 'Slim', 'Athletic' => 'Athletic', 'Average' => 'Average', 'Heavy' => 'Heavy'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                return $return;
            }

        ]
    ); ?>

    <?= $form->field($model, 'vSmoke')->RadioList(
        ['Smoke_Yes' => 'Yes', 'Smoke_No' => 'No', 'Smoke_Occasionally' => 'Occasionally'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                return $return;
            }

        ]
    ); ?>

    <?= $form->field($model, 'vDrink')->RadioList(
        ['Drink_Yes' => 'Yes', 'Drink_No' => 'No', 'Drink_Occasionally' => 'Occasionally'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                return $return;
            }

        ]
    ); ?>

    <?= $form->field($model, 'vSpectaclesLens')->RadioList(
        ['SpectaclesLens_Spectacles' => 'Spectacles', 'SpectaclesLens_Lens' => 'Lens'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                return $return;
            }

        ]
    ); ?>

    <?= $form->field($model, 'vDiet')->dropDownList(
        ArrayHelper::map(CommonHelper::getDiet(), 'iDietID', 'vName'),
        ['prompt' => 'Diet']
    ); ?>

    <?= $form->field($model, 'weight')->input('number') ?>
    <div class="row">
        <div class="">
            <input type="hidden" name="save" value="1">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
            <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_lifestyle', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>
        </div>
    </div>
    <?php ActiveForm::end();
} else {
    ?>
   
        <dl class="dl-horizontal">
            <dt>Height</dt>
            <dd><?= CommonHelper::setInputVal($model->height->vName, 'text') ?>
            <dd>
            <dt>Skin Tone</dt>
            <dd><?= CommonHelper::setInputVal($model->vSkinTone, 'text') ?></dd>
            <dt>Body type</dt>
            <dd><?= CommonHelper::setInputVal($model->vBodyType, 'text') ?>
            <dd>
            <dt>Smoke</dt>
            <dd><?= CommonHelper::setInputVal($model->vSmoke, 'text') ?></dd>
            <dt>Drink</dt>
            <dd><?= CommonHelper::setInputVal($model->vDrink, 'text') ?></dd>
            <dt>Spectacles/Lens</dt>
            <dd><?= CommonHelper::setInputVal($model->vSpectaclesLens, 'text') ?></dd>
            <dt>Diet</dt>
            <dd><?= CommonHelper::setInputVal($model->dietName->vName, 'text') ?></dd>
            <dt>Weight</dt>
            <dd><?= CommonHelper::setInputVal($model->weight . " KG", 'text') ?></dd>
        </dl>
  
    <?php
}
?>
  </div>