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
        <div class="form-group field-partners_countries-country_id">
            <label class="control-label col-sm-3 col-xs-3" for="partners_countries-country_id">Country</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clselocation"
                        placeholder="Select Country" name="PartnersCountries[country_id][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getCountry() as $K => $V) { ?>
                        <option
                            value="<?= $V->iCountryId ?>" <?php if (in_array($V->iCountryId, $PartnersCountries)) {
                            echo "selected";
                        } ?>><?= $V->vCountryName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnersstates-state_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnersstates-state_id">State</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clselocation"
                        placeholder="Select State" name="PartnersStates[state_id][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getState($CountryIDs) as $K => $V) { ?>
                        <option
                            value="<?= $V->iStateId ?>" <?php if (in_array($V->iStateId, $PartnersStates)) {
                            echo "selected";
                        } ?>><?= $V->vStateName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group field-partnerscities-city_id">
            <label class="control-label col-sm-3 col-xs-3" for="partnerscities-city_id">City</label>

            <div class="col-sm-8 col-xs-8">
                <select id="select-state" multiple class="demo-default select-beast clselocation"
                        placeholder="Select City" name="PartnersCities[city_id][]"
                        size="4">
                    <?php
                    foreach (CommonHelper::getCity($StatesIDs) as $K => $V) { ?>
                        <option
                            value="<?= $V->iCityId ?>" <?php if (in_array($V->iCityId, $PartnersCities)) {
                            echo "selected";
                        } ?>><?= $V->vCityName ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>


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
           $(".edit_location").hide();
        ');
        $this->registerJs('
          selectboxClassWise("clselocation");
         ');
    } else {
        ?>

        <dl class="dl-horizontal">
            <dt>City</dt>
            <?php $PCityArray = \common\models\Cities::getCityName(CommonHelper::removeComma(implode(",", $PartnersCities))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PCityArray, 'vCityName'), 'text') ?></dd>


            <dt>State</dt>
            <?php $PStateArray = \common\models\States::getStateName(CommonHelper::removeComma(implode(",", $PartnersStates))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PStateArray, 'vStateName'), 'text') ?></dd>


            <dt>Country</dt>
            <?php $PCountryArray = \common\models\Countries::getCountryName(CommonHelper::removeComma(implode(",", $PartnersCountries))); ?>
            <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PCountryArray, 'vCountryName'), 'text') ?></dd>

        </dl>

    <?php
        $this->registerJs('
           $(".edit_location").show();
        ');
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