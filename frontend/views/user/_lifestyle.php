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
        'action' => ['edit-lifestyle'],
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

    <div class="row">
        <div class="">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>

        </div>
    </div>
    <?php ActiveForm::end();
} else {
    ?>
    <div class="div_lifestyle">
        <dl class="dl-horizontal">
            <dt>Height</dt>
            <dd><?= $model->height->vName ?>
            <dd>
            <dt>Skin Tone</dt>
            <dd><?= $model->vSkinTone; ?></dd>
            <dt>Body type</dt>
            <dd><?= $model->vBodyType; ?>
            <dd>
            <dt>Smoke</dt>
            <dd><?= $model->vSmoke; ?></dd>
            <dt>Drink</dt>
            <dd><?= $model->vDrink; ?></dd>
            <dt>Spectacles/Lens</dt>
            <dd><?= $model->vSpectaclesLens; ?></dd>
            <dt>Diet</dt>
            <dd><?= $model->dietName->vName; ?></dd>
        </dl>
    </div>
    <?php
}