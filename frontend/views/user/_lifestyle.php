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
<div class="div_personal_info">
<?php
if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-lifestyle'],
        'options' => ['data-pjax' => true],
        'layout' => 'horizontal',
        'validateOnChange' => true,
        'validateOnSubmit' => true,
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
    <?= $form->field($model, 'iHeightID', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
        ['class' => 'demo-default select-beast clslifestyle', 'prompt' => 'Height']
    ); ?>

    <?= $form->field($model, 'vSkinTone', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->RadioList(
        ArrayHelper::map(CommonHelper::getSkinTone(), 'ID', 'Name'),
        ['item' => function ($index, $label, $name, $checked, $value) {
            $checked = ($checked) ? 'checked' : '';
            $return = '<input type="radio" id="vSkinTone_' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
            $return .= '<label for="vSkinTone_' . $value . '">' . ucwords($label) . '</label>';
            return $return;
        }
        ]
    ); ?>

    <?= $form->field($model, 'vBodyType', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->RadioList(
        ArrayHelper::map(CommonHelper::getBodyType(), 'ID', 'Name'),
        ['item' => function ($index, $label, $name, $checked, $value) {
            $checked = ($checked) ? 'checked' : '';
            $return = '<input type="radio" id="vBodyType_' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
            $return .= '<label for="vBodyType_' . $value . '">' . ucwords($label) . '</label>';
            return $return;
        }
        ]
    ); ?>

    <?= $form->field($model, 'vSmoke', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->RadioList(
        Yii::$app->params['smokeArray'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . ucwords($value) . '" ' . $checked . '>';
                $return .= '<label for="' . $value . '">' . ucwords($value) . '</label>';
                return $return;
            }

        ]
    ); ?>

    <?= $form->field($model, 'vDrink', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->RadioList(
        Yii::$app->params['drinkArray'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $label . '" name="' . $name . '" value="' . ucwords($value) . '" ' . $checked . '>';
                $return .= '<label for="' . $label . '">' . ucwords($value) . '</label>';
                return $return;
            }

        ]
    ); ?>

    <?= $form->field($model, 'vSpectaclesLens', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">&nbsp</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->RadioList(
        Yii::$app->params['eyesArray'],
        [
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = ($checked) ? 'checked' : '';
                $return = '<input type="radio" id="' . $label . '" name="' . $name . '" value="' . ucwords($value) . '" ' . $checked . '>';
                $return .= '<label for="' . $label . '">' . ucwords($value) . '</label>';
                return $return;
            }

        ]
    ); ?>

    <?= $form->field($model, 'vDiet', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->dropDownList(
        ArrayHelper::map(CommonHelper::getDiet(), 'iDietID', 'vName'),
        ['class' => 'demo-default select-beast clslifestyle', 'prompt' => 'Diet']
    ); ?>

    <?= $form->field($model, 'weight', [
        'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
        'labelOptions' => ['class' => ''],
    ])->input('number') ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="form-cont">
                <div class="form-cont">
                    <input type="hidden" name="save" value="1">
                    <?= Html::submitButton('save', ['class' => 'btn btn-primary  my-profile-sc-button preferences_submit', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-cont">
                <div class="form-cont">
                    <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_lifestyle', 'name' => 'cancel']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end();
    $PROFILE_COMPLETENESS = $this->context->profileCompleteness($model->completed_step);
    $this->registerJs('
           $(".edit_lifestyle").hide();
            profile_meter(' . $PROFILE_COMPLETENESS . ');
        ');
    $this->registerJs('
                  selectboxClassWise("clslifestyle");
             ');
} else {
    ?>
   
        <dl class="dl-horizontal">
            <dt>Height</dt>
            <dd><?= CommonHelper::setInputVal($model->height->vName, 'text') ?>
            <dd>
            <dt>Skin Tone</dt>
            <dd><?= CommonHelper::setInputVal($model->skinTone->Name, 'text') ?></dd>
            <dt>Body type</dt>
            <dd><?= CommonHelper::setInputVal($model->bodyType->Name, 'text') ?></dd>
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
    $this->registerJs('
           $(".edit_lifestyle").show();
        ');
}
?>
  </div>
