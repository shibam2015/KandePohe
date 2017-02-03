<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

?>
    <div class="div_hobby">
        <?php
        if ($show) {
            $form = ActiveForm::begin([
                'id' => 'form',
                'action' => ['edit-preferences-hobby'],
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

            <div class="form-group field-partnersinterest-interest_id">
                <label class="control-label col-sm-3 col-xs-3" for="partnersinterest-interest_id">Interest</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clspartnerhobby"
                            placeholder="Select an Interest" name="PartnersInterest[interest_id][]" size="4">
                        <?php
                        foreach (CommonHelper::getInterests() as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersInterestArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-partnersfavouritereads-read_id">
                <label class="control-label col-sm-3 col-xs-3" for="partnersfavouritereads-read_id">Favourite
                    Reads</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clspartnerhobby "
                            placeholder="Select a Favourite Reads" name="PartnersFavouriteReads[read_id][]" size="4">
                        <?php
                        foreach (CommonHelper::getFavouriteReads() as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersFavReadsArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-partnersfavouritemusic-music_name_id">
                <label class="control-label col-sm-3 col-xs-3" for="partnersfavouritemusic-music_name_id">Favourite
                    Music</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clspartnerhobby"
                            placeholder="Select a Favourite Music" name="PartnersFavouriteMusic[music_name_id][]"
                            size="4">
                        <?php
                        foreach (CommonHelper::getFavouriteMusic() as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersMusicArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-partnersfavouritecousines-cousines_id">
                <label class="control-label col-sm-3 col-xs-3" for="partnersfavouritecousines-cousines_id">Favourite
                    Cousines</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clspartnerhobby"
                            placeholder="Select a Favourite Cousine" name="PartnersFavouriteCousines[cousines_id][]"
                            size="4">
                        <?php
                        foreach (CommonHelper::getFavouriteCousines() as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersCousinsArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-partnersfitnessactivities-fitness_id">
                <label class="control-label col-sm-3 col-xs-3" for="partnersfitnessactivities-fitness_id">Sports Fitness
                    Activities</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clspartnerhobby"
                            placeholder="Select a Sports Fitness Activities"
                            name="PartnersFitnessActivities[fitness_id][]" size="4">
                        <?php
                        foreach (CommonHelper::getSportsFitnActivities() as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersFitnessArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-partnerspreferreddresstype-dress_style_id">
                <label class="control-label col-sm-3 col-xs-3" for="partnerspreferreddresstype-dress_style_id">Preferred
                    Dress Style</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clspartnerhobby"
                            placeholder="Select a Preferred Dress Style"
                            name="PartnersPreferredDressType[dress_style_id][]" size="4">
                        <?php
                        foreach (CommonHelper::getPreferredDressStyle() as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersDressStyleArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-partnerspreferredmovies-movie_id">
                <label class="control-label col-sm-3 col-xs-3" for="partnerspreferredmovies-movie_id">Preferred
                    Movie</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clspartnerhobby"
                            placeholder="Select a Preferred Movie" name="PartnersPreferredMovies[movie_id][]" size="4">
                        <?php
                        foreach (CommonHelper::getPreferredMovies() as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $PartenersMoviesArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
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
                            <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_partner_hobby', 'name' => 'cancel']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end();
            $this->registerJs('
                    selectboxClassWise("clspartnerhobby");
         ');
            # $this->registerCssFile(Yii::$app->request->baseUrl . '/plugings/select2/select2.min.css');
            # $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/select2/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
            # $this->registerJs('
            /*$(".js-example-basic-multiple").select2({
                placeholder: "Select Option"
            });*/
            #');

        } else {
            ?>

            <dl class="dl-horizontal">

                <dt>Interest</dt>
                <?php $PInterestArray = \common\models\Interests::getInterestNames(CommonHelper::removeComma(implode(",", $PartenersInterestArray))); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PInterestArray, 'Name'), 'text') ?></dd>

                <dt>Favorite Reads</dt>
                <?php $PReadsArray = \common\models\FavouriteReads::getReadsNames(CommonHelper::removeComma(implode(",", $PartenersFavReadsArray))); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PReadsArray, 'Name'), 'text') ?></dd>

                <dt>Favorite Music</dt>
                <?php $PMusicArray = \common\models\FavouriteMusic::getMusicNames(CommonHelper::removeComma(implode(",", $PartenersMusicArray))); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PMusicArray, 'Name'), 'text') ?></dd>

                <dt>Favorite Cousines</dt>
                <?php $PCousinsArray = \common\models\FavouriteCousines::getCousinesNames(CommonHelper::removeComma(implode(",", $PartenersCousinsArray))); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PCousinsArray, 'Name'), 'text') ?></dd>

                <dt>Sports/Fitness and Activities</dt>
                <?php $PFitnessArray = \common\models\SportsFitnActivities::getSportsNames(CommonHelper::removeComma(implode(",", $PartenersFitnessArray))); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PFitnessArray, 'Name'), 'text') ?></dd>

                <dt>Preferred Dress Style</dt>
                <?php $PDressStyleArray = \common\models\PreferredDressStyle::getDressNames(CommonHelper::removeComma(implode(",", $PartenersDressStyleArray))); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PDressStyleArray, 'Name'), 'text') ?></dd>

                <dt>Preferred Movie</dt>
                <?php $PMoviesArray = \common\models\PreferredMovies::getMovieNames(CommonHelper::removeComma(implode(",", $PartenersMoviesArray))); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($PMoviesArray, 'Name'), 'text') ?></dd>
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