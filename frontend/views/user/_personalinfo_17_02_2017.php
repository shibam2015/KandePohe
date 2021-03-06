<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

?>
<div id="div_personal_info1">
    <?php
    if ($show) {
        $form = ActiveForm::begin([
            'id' => 'form',
            //'enableClientValidation'=> true,
            'enableAjaxValidation' => false,
            'validateOnSubmit' => false,
            'validateOnChange' => false,
            'action' => ['edit-personal-info'],
            'options' => ['data-pjax' => true],
            'layout' => 'horizontal',
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
        <?= $form->errorSummary($model, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
        <?= $form->field($model, 'First_Name',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ]
        )->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'Last_Name',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ])->textInput() ?>
        <?= $form->field($model, 'Gender', [
            'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
            'labelOptions' => ['class' => ''],
        ])->RadioList(
            ['MALE' => 'MALE', 'FEMALE' => 'FEMALE'],
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
        <?= $form->field($model, 'DOB',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ]
        )->textInput()
            ->widget(\yii\jui\DatePicker::classname(),
                [
                    'dateFormat' => 'php:Y-m-d',
                    'options' => [
                        'id' => 'DOB',
                        'class' => 'form-control',
                        'onkeyup' => ' $(".hasDatepicker").val("");',
                    ],
                    'clientOptions' => [
                        'changeMonth' => true,
                        'yearRange' => '-70:-21',
                        'changeYear' => true,
                        'maxDate' => date('Y-m-d', strtotime('-21 year')),
                    ]

                ]);
        ?>

        <?= $form->field($model, 'Profile_created_for',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ]
        )->dropDownList(
            Yii::$app->params['profileFor'],
            ['class' => 'demo-default select-beast clspersonalinfo', 'prompt' => 'Profile For']
        ); ?>
        <!--<?= $form->field($model, 'county_code')->dropDownList(
            ['+91' => '+91'],
            ['class' => 'demo-default select-beast clspersonalinfo', 'prompt' => 'Country Code']
        )
        ?>
        <?= $form->field($model, 'Mobile')->input('text') ?> -->
        <?= $form->field($model, 'mother_tongue',
            [
                'template' => '<label class="control-label col-sm-4 col-xs-4" for="user-last_name"><span class="text-danger">*</span>{label}</label>
                                <div class="col-sm-8 col-xs-8">{input}</div>',
                'labelOptions' => ['class' => ''],
            ])->dropDownList(
            ArrayHelper::map(CommonHelper::getMotherTongue(), 'ID', 'Name'),
            ['class' => 'demo-default select-beast clspersonalinfo', 'prompt' => 'Mother Tongue']
        ); ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="form-cont">
                    <div class="form-cont">
                        <input type="hidden" name="save" value="1">
                        <?= Html::submitButton('save', ['class' => 'btn btn-primary  my-profile-sc-button preferences_submit', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_personalinfo', 'name' => 'cancel']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();

        $this->registerJs('
          selectboxClassWise("clspersonalinfo");
         ');
        $this->registerJs('
        $(".genderV").on("change",function(e){
          var genderVal = $(this).val();
          if(genderVal == "FEMALE") {
            $("#DOB").datepicker("option","maxDate","' . date('Y-m-d', strtotime('-18 year')) . '");
            $("#DOB").datepicker("option","yearRange","-70:-18");
          }
          else {
            $("#DOB").datepicker("option","maxDate","' . date('Y-m-d', strtotime('-21 year')) . '");
            $("#DOB").datepicker("option","yearRange","-70:-21");
          }
        });
      ');
    } else {
        ?>

        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd><?= $model->FullName; ?>
            <dd>
            <dt>Profile created by</dt>
            <dd><?= $model->Profile_created_for; ?></dd>
            <dt>Date Of Birth</dt>
            <dd><?= $model->DOB; ?>
            <dd>
            <dt>Age</dt>
            <dd><?= CommonHelper::getAge($model->DOB); ?> years
            <dd>
            <dt>Gender</dt>
            <dd><?= $model->Gender ?></dd>
            <!--  <dt>Mobile</dt>
            <dd><?/*= $model->county_code." ".$model->Mobile; */ ?></dd>-->
            <dt>Mother Tongue</dt>
            <dd><?= CommonHelper::setInputVal($model->motherTongue->Name, 'text') ?></dd>

        </dl>
        <?php
        if ($popup) {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'CHANGE_PHONE_NUMBER');
            $this->registerJs('
                    //notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
                    $(".modal").on("hidden.bs.modal", function (e) {
                        //window.location.href = "' . Yii::$app->homeUrl . 'site/verification";
                    })
                ');
        }
    }
    ?>


</div>