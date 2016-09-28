<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

if ($show) {
    $form = ActiveForm::begin([
        'id' => 'form',
        'action' => ['edit-personal-info'],
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
    <?= $form->field($model, 'First_Name')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'Last_Name')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'iHeightID')->dropDownList(ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'), ['prompt' => 'Height']); ?>
    <?= $form->field($model, 'iMaritalStatusID')->dropDownList(ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'), ['class' => 'form-control', 'prompt' => 'Maritial Status']); ?>
    <div class="row">
        <div class="">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
        </div>
    </div>
    <?php ActiveForm::end();
} else {
    ?>
    <div class="div_personal_info">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd><?= $model->FullName; ?>
            <dd>
            <dt>Profile created by</dt>
            <dd>Self</dd>
            <dt>Age</dt>
            <dd>30 years
            <dd>
            <dt>Height</dt>
            <dd><?= $model->height->vName ?></dd>
            <dt>Weight</dt>
            <dd>76 kgs/ 172 lbs</dd>
            <dt>Physical status</dt>
            <dd>Normal</dd>
            <dt>Mother tongue</dt>
            <dd>Marathi</dd>
            <dt>Marital status</dt>
            <dd><?= $model->maritalStatusName->vName; ?></dd>
        </dl>
    </div>
    <?php
}