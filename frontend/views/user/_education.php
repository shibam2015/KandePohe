<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
?>
<div class="div_education">
<?php
if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-education'],
        'options' => ['data-pjax' => true],
        'validateOnChange' => false,
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
    <?= $form->errorSummary($model,['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
    <?= $form->field($model, 'iEducationLevelID')->dropDownList(
        ArrayHelper::map(CommonHelper::getEducationLevel(), 'iEducationLevelID', 'vEducationLevelName'),
        ['prompt' => 'Education Level']
    ); ?>

    <?= $form->field($model, 'iEducationFieldID')->dropDownList(
        ArrayHelper::map(CommonHelper::getEducationField(), 'iEducationFieldID', 'vEducationFieldName'),
        ['prompt' => 'Education Field']
    ); ?>

    <?= $form->field($model, 'iWorkingWithID')->dropDownList(
        ArrayHelper::map(CommonHelper::getWorkingWith(), 'iWorkingWithID', 'vWorkingWithName'),
        ['prompt' => 'Working with']
    ); ?>

    <?= $form->field($model, 'iWorkingAsID')->dropDownList(
        ArrayHelper::map(CommonHelper::getWorkingAS(), 'iWorkingAsID', 'vWorkingAsName'),
        ['prompt' => 'Working As']
    ); ?>
    <?= $form->field($model, 'iAnnualIncomeID')->dropDownList(
        ArrayHelper::map(CommonHelper::getAnnualIncome(), 'iAnnualIncomeID', 'vAnnualIncome'),
        ['prompt' => 'Annual Income']
    ); ?>

    <div class="row">
        <div class="">
        <input type="hidden" name="save" value="1">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
            <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_education', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>
        </div>
    </div>
    <?php ActiveForm::end();
} else {
    ?>
    
        <dl class="dl-horizontal">
            <dt>Education Level</dt>
            <dd><?= CommonHelper::setInputVal($model->educationLevelName->vEducationLevelName, 'text') ?>
            <dd>
            <dt>Education Field</dt>
            <dd><?= CommonHelper::setInputVal($model->educationFieldName->vEducationFieldName, 'text') ?></dd>
            <dt>Working With</dt>
            <dd><?= CommonHelper::setInputVal($model->workingWithName->vWorkingWithName, 'text') ?></dd>
            <dt>Woking As</dt>
            <dd><?= CommonHelper::setInputVal($model->workingAsName->vWorkingAsName, 'text') ?></dd>
            <dt>Annual Income</dt>
            <dd><?= CommonHelper::setInputVal($model->annualIncome->vAnnualIncome, 'text') ?></dd>
        </dl>
    
    <?php
}
?>
</div>