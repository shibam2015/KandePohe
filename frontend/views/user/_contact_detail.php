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
            'id' => 'form-register10',
            'action' => ['edit-contact-detail'],
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
        <?= $form->field($model, 'email')->input('text') ?>
        <?= $form->field($model, 'county_code')->dropDownList(
            ['+91' => '+91'],
            ['class' => 'demo-default select-beast clscontactdetails', 'prompt' => 'Country Code']
        )
        ?>

        <?= $form->field($model, 'Mobile')->input('text') ?>
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
                        <?= Html::Button('Cancel', ['class' => 'btn btn-primary my-profile-sc-button', 'id' => 'cancel_edit_contact_detail', 'name' => 'cancel']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();
        $this->registerJs('
          selectboxClassWise("clscontactdetails");
         ');
    } else {
        ?>
        <dl class="dl-horizontal">
            <dt>Email</dt>
            <dd><?= $model->email; ?>
            <dd>
            <dt>Phone No.</dt>
            <dd><?= $model->county_code . " " . $model->Mobile; ?></dd>
        </dl>

    <?php
    }
    ?>
</div>
