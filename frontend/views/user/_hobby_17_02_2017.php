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
                'action' => ['edit-hobby'],
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


            <div class="form-group field-user-interestid">
                <label class="control-label col-sm-3 col-xs-3" for="user-interestid">Interest</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clhobby"
                            placeholder="Select an Interest" name="User[InterestID][]" size="4">
                        <?php if ($model->InterestID) {
                            $UserInterestArray = explode(",", CommonHelper::removeComma($model->InterestID));
                        }
                        $InterestArray = CommonHelper::getInterests();
                        foreach ($InterestArray as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $UserInterestArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-user-favioritereadid">
                <label class="control-label col-sm-3 col-xs-3" for="user-favioritereadid">Favourite Reads</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clhobby "
                            placeholder="Select a Favourite Reads" name="User[FavioriteReadID][]" size="4">
                        <?php if ($model->FavioriteReadID) {
                            $UserFavReadsArray = explode(",", CommonHelper::removeComma($model->FavioriteReadID));
                        }
                        $FaviouriteReadArray = CommonHelper::getFavouriteReads();
                        foreach ($FaviouriteReadArray as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $UserFavReadsArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-user-faviouritemusicid">
                <label class="control-label col-sm-3 col-xs-3" for="user-faviouritemusicid">Favourite Music</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clhobby"
                            placeholder="Select a Favourite Music" name="User[FaviouriteMusicID][]" size="4">
                        <?php if ($model->FaviouriteMusicID) {
                            $UserFavMusicArray = explode(",", CommonHelper::removeComma($model->FaviouriteMusicID));
                        }
                        $FaviouriteMusicArray = CommonHelper::getFavouriteMusic();
                        foreach ($FaviouriteMusicArray as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $UserFavMusicArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-user-favouritecousinesid">
                <label class="control-label col-sm-3 col-xs-3" for="user-favouritecousinesid">Favourite Cousines</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clhobby"
                            placeholder="Select a Favourite Cousine" name="User[FavouriteCousinesID][]" size="4">
                        <?php if ($model->FavouriteCousinesID) {
                            $UserFavCousinArray = explode(",", CommonHelper::removeComma($model->FavouriteCousinesID));
                        }
                        $FaviouriteCousinArray = CommonHelper::getFavouriteCousines();
                        foreach ($FaviouriteCousinArray as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $UserFavCousinArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-user-sportsfittnessid">
                <label class="control-label col-sm-3 col-xs-3" for="user-sportsfittnessid">Sports Fitness
                    Activities</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clhobby"
                            placeholder="Select a Sports Fitness Activities" name="User[SportsFittnessID][]" size="4">
                        <?php if ($model->SportsFittnessID) {
                            $UserSportFitnessArray = explode(",", CommonHelper::removeComma($model->SportsFittnessID));
                        }
                        $SportFitnessArray = CommonHelper::getSportsFitnActivities();
                        foreach ($SportFitnessArray as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $UserSportFitnessArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-user-preferreddressid">
                <label class="control-label col-sm-3 col-xs-3" for="user-preferreddressid">Preferred Dress Style</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clhobby"
                            placeholder="Select a Preferred Dress Style" name="User[PreferredDressID][]" size="4">
                        <?php if ($model->PreferredDressID) {
                            $UserPreferredDressArray = explode(",", CommonHelper::removeComma($model->PreferredDressID));
                        }
                        $PreferredDressArray = CommonHelper::getPreferredDressStyle();
                        foreach ($PreferredDressArray as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $UserPreferredDressArray)) {
                                echo "selected";
                            } ?>><?= $V->Name ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group field-user-preferredmovieid">
                <label class="control-label col-sm-3 col-xs-3" for="user-preferredmovieid">Preferred Movie</label>

                <div class="col-sm-8 col-xs-8">
                    <select id="select-state" multiple class="demo-default select-beast clhobby"
                            placeholder="Select a Preferred Movie" name="User[PreferredMovieID][]" size="4">
                        <?php if ($model->PreferredMovieID) {
                            $UserPreferredMovieArray = explode(",", CommonHelper::removeComma($model->PreferredMovieID));
                        }
                        $PreferredMovieArray = CommonHelper::getPreferredMovies();
                        foreach ($PreferredMovieArray as $K => $V) { ?>
                            <option value="<?= $V->ID ?>" <?php if (in_array($V->ID, $UserPreferredMovieArray)) {
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
                            <?= Html::Button('Cancel', ['class' => 'btn btn-primary  my-profile-sc-button', 'id' => 'cancel_edit_hobby', 'name' => 'cancel']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end();
            $this->registerJs('
                    selectboxClassWise("clhobby");
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
                <?php $InterestArray = \common\models\Interests::getInterestNames(CommonHelper::removeComma($model->InterestID)); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($InterestArray, 'Name'), 'text') ?></dd>
                <dt>Favorite Reads</dt>
                <?php $ReadsArray = \common\models\FavouriteReads::getReadsNames(CommonHelper::removeComma($model->FavioriteReadID)); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($ReadsArray, 'Name'), 'text') ?></dd>
                <dt>Favorite Music</dt>
                <?php $MusicArray = \common\models\FavouriteMusic::getMusicNames(CommonHelper::removeComma($model->FaviouriteMusicID)); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($MusicArray, 'Name'), 'text') ?></dd>
                <dt>Favorite Cousines</dt>
                <?php $CousinesArray = \common\models\FavouriteCousines::getCousinesNames(CommonHelper::removeComma($model->FavouriteCousinesID)); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($CousinesArray, 'Name'), 'text') ?></dd>
                <dt>Sports/Fitness and Activities</dt>
                <?php $SportsArray = \common\models\SportsFitnActivities::getSportsNames(CommonHelper::removeComma($model->SportsFittnessID)); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($SportsArray, 'Name'), 'text') ?></dd>
                <dt>Preferred Dress Style</dt>
                <?php $DressArray = \common\models\PreferredDressStyle::getDressNames(CommonHelper::removeComma($model->PreferredDressID)); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($DressArray, 'Name'), 'text') ?></dd>
                <dt>Preferred Movie</dt>
                <?php $MovieArray = \common\models\PreferredMovies::getMovieNames(CommonHelper::removeComma($model->PreferredMovieID)); ?>
                <dd><?= CommonHelper::setInputVal(CommonHelper::getCommaSeperatedValue($MovieArray, 'Name'), 'text') ?></dd>
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