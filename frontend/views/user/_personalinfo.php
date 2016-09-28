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
    <?= $form->field($model, 'Profile_created_for')->dropDownList(
                  [''=>'Profile for','BRIDE'=>'BRIDE','GROOM'=>'GROOM','SELF'=>'SELF'],
                  ['prompt' => 'Profile For']
              );?>
    <?= $form->field($model, 'iHeightID')->dropDownList(ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'), ['prompt' => 'Height']); ?>
    <div class="row">
        <div class="">
            <input type="hidden" name="save" value="1">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
            <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_personalinfo', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>

        </div>
    </div>
    <?php ActiveForm::end();
} else {
    ?>
    <div class="div_personal_info">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd><?= $model->FullName; ?><dd>
            <dt>Profile created by</dt>
            <dd><?= $model->Profile_created_for; ?></dd>
            <dt>Age</dt>
            <dd>30 years<dd>
            <dt>Height</dt>
            <dd><?= $model->height->vName ?></dd>
            <dt>Weight</dt>
            <dd><?= $model->weight;?></dd>
            <dt>Physical status</dt>
            <dd><?= $model->vDisability;?></dd>
            <dt>Mother tongue</dt>
            <dd><?= $model->weight;?></dd>
            
        </dl>
    </div>
    <?php
}