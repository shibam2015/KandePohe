<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

?>
    <div class="div_personal_info">
        <?php
        if ($show) {
            $form = ActiveForm::begin([
                'id' => 'form',
                'action' => ['edit-education'],
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
            <?= $form->field($model, 'iEducationLevelID')->dropDownList(
                ArrayHelper::map(CommonHelper::getEducationLevel(), 'iEducationLevelID', 'vEducationLevelName'),
                ['class' => 'demo-default select-beast clseducation', 'prompt' => 'Education Level']
            ); ?>

            <?= $form->field($model, 'iEducationFieldID')->dropDownList(
                ArrayHelper::map(CommonHelper::getEducationField(), 'iEducationFieldID', 'vEducationFieldName'),
                ['class' => 'demo-default select-beast clseducation', 'prompt' => 'Education Field']
            ); ?>

            <?= $form->field($model, 'iWorkingWithID')->dropDownList(
                ArrayHelper::map(CommonHelper::getWorkingWith(), 'iWorkingWithID', 'vWorkingWithName'),
                ['class' => 'demo-default select-beast clseducation', 'prompt' => 'Working with']
            ); ?>

            <?= $form->field($model, 'iWorkingAsID')->dropDownList(
                ArrayHelper::map(CommonHelper::getWorkingAS(), 'iWorkingAsID', 'vWorkingAsName'),
                ['class' => 'demo-default select-beast clseducation', 'prompt' => 'Working As']
            ); ?>
            <?= $form->field($model, 'iAnnualIncomeID')->dropDownList(
                ArrayHelper::map(CommonHelper::getAnnualIncome(), 'iAnnualIncomeID', 'vAnnualIncome'),
                ['class' => 'demo-default select-beast clseducation', 'prompt' => 'Annual Income']
            ); ?>

            <div class="row">
                <div class="col-md-4 col-md-offset-2">
                    <div class="form-cont">
                        <div class="form-cont">
                            <input type="hidden" name="save" value="1">
                            <?= Html::submitButton('save', ['class' => 'btn btn-primary preferences_submit  my-profile-sc-button', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-cont">
                        <div class="form-cont">
                            <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_education', 'name' => 'cancel']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end();
            $this->registerJs('
                  selectboxClassWise("clseducation");
             ');
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
<?php
$this->registerJs('
$(".preferences_submit").on("click", function() {
var $this = $(this);
$this.button("loading");
setTimeout(function() {
$this.button("reset");
}, 8000);
});
');
?>