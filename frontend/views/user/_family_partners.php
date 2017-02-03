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
                'action' => ['edit-preferences-family'],
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

            <div class="form-group field-partners_family_affluence_level-family_affluence_level_id">
                <label class="control-label col-sm-3 col-xs-3"
                       for="partners_family_affluence_level-family_affluence_level_id">Family Affluence Level</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clspartnersfamily"
                            placeholder="Select Family Affluence Level"
                            name="PartnersFamilyAffluenceLevel[family_affluence_level_id][]"
                            size="4">
                        <?php
                        foreach (CommonHelper::getFamilyAffulenceLevel() as $K => $V) { ?>
                            <option
                                value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartnersFamilyALevel)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-partners_family_type-family_type">
                <label class="control-label col-sm-3 col-xs-3" for="partners_family_type-family_type">Family
                    Type</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clspartnersfamily"
                            placeholder="Select Family Type" name="PartnersFamilyType[family_type][]"
                            size="4">
                        <?php
                        foreach (Yii::$app->params['familyTypeArray'] as $K => $V) { ?>
                            <option
                                value="<?= $V ?>" <?php if (in_array($V, $PartnersFamilyTypeS)) {
                                echo "selected";
                            } ?>><?= $K ?></option>
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
                            <?= Html::submitButton('save', ['class' => 'btn btn-primary preferences_submit  my-profile-sc-button', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-cont">
                        <div class="form-cont">
                            <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_partner_family', 'name' => 'cancel']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end();

            $this->registerJs('
          selectboxClassWise("clspartnersfamily");
         ');
        } else {
            ?>

            <dl class="dl-horizontal">

                <dt>Family Affluence Level</dt>
                <?php $PFamilyALevelArray = \common\models\FamilyAffluenceLevel::getFamilyAffluenceLevelName(CommonHelper::removeComma(implode(",", $PartnersFamilyALevel))); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PFamilyALevelArray, 'Name'), 'text') ?></dd>
                <dt>Family Type</dt>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getValuesFromArray(Yii::$app->params['familyTypeArray'], $PartnersFamilyTypeS, 1), 'text') ?></dd>

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