<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

?>
    <div class="div_location">
        <?php
        if ($show) {
            $form = ActiveForm::begin([
                'id' => 'form',
                'action' => ['edit-preferences-location'],
                'options' => ['data-pjax' => true],
                'layout' => 'horizontal',
                'validateOnChange' => true,
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
            <!-- <?= $form->errorSummary([$PCS], ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?> -->

            <?= $form->field($PCS, 'country_id')->dropDownList(
                ArrayHelper::map(CommonHelper::getCountry(), 'iCountryId', 'vCountryName'),
                ['class' => 'demo-default select-beast clselocation', 'prompt' => 'Country',
                    'onchange' => '
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax/getstate?id=') . '"+$(this).val(), function( data ) {
                                  $( "select#state_id" ).html( data );
                                  $("select#state_id").niceSelect("update");
                                });'
                ]

            ); ?>
            <?php
            $stateList = [];
            if ($PCS->country_id != "") {
                $stateList = ArrayHelper::map(CommonHelper::getState($PCS->country_id), 'iStateId', 'vStateName');
            }
            ?>
            <?= $form->field($PS, 'state_id')->dropDownList(
                $stateList,
                ['id' => 'state_id',
                    'class' => 'demo-default select-beast clselocation',
                    'prompt' => 'State',
                    'onchange' => '
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax/getcity?id=') . '"+$(this).val(), function( data ) {
                                  $( "select#city_id" ).html( data );
                                  $("select#city_id").niceSelect("update");
                                });'
                ]

            ); ?>
            <?php
            $cityList = [];
            if ($PS->state_id != "") {
                $cityList = ArrayHelper::map(CommonHelper::getCity($PS->state_id), 'iCityId', 'vCityName');
            }
            ?>
            <?= $form->field($PC, 'city_id')->dropDownList(
                $cityList,
                ['id' => 'city_id', 'class' => 'demo-default select-beast clselocation', 'prompt' => 'City']
            ); ?>


            <div class="row">
                <div class="col-md-4 col-md-offset-2">
                    <div class="form-cont">
                        <div class="form-cont">
                            <input type="hidden" name="save" value="1">
                            <?= Html::submitButton('save', ['class' => 'btn btn-primary preferences_submit my-profile-sc-button', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-cont">
                        <div class="form-cont">
                            <?= Html::Button('Cancel', ['class' => 'btn btn-primary my-profile-sc-button', 'id' => 'cancel_edit_location', 'name' => 'cancel']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end();
            $this->registerJs('
          selectboxClassWise("clselocation");
         ');
        } else {
            ?>

            <dl class="dl-horizontal">

                <dt>City</dt>
                <dd><?= CommonHelper::setInputVal($PC->cityName->vCityName, 'text') ?>
                <dd>

                <dt>State</dt>
                <dd><?= CommonHelper::setInputVal($PS->stateName->vStateName, 'text') ?>
                <dd>
                <dt>Country</dt>
                <dd><?= CommonHelper::setInputVal($PCS->countryName->vCountryName, 'text') ?>
                <dd>
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