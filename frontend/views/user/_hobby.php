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

        <!-- <?= $form->field($model, 'iReligion_ID')->dropDownList(
            ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
            ['class' => 'js-example-basic-multiple',
                'multiple' => 'multiple'
            ]

        ); ?>-->
        <!-- <?= $form->field($model, 'InterestID')->dropDownList(
            ArrayHelper::map(CommonHelper::getInterests(), 'ID', 'Name'),
            [
                'class' => 'js-example-basic-multiple',
                'multiple' => 'multiple',
                'item' => function ($index, $label, $name, $checked, $value) {
                    global $model;
                    $checked = (in_array($value, explode(",", $model->InterestID))) ? 'selected' : '';
                    $return = '<input type="selectbox" id="InterestID' . $label . '" name="' . $name . '" value="' . $value . '"' . $checked . '>';
                    $return .= '<label for="InterestID' . $label . '" class="control-label no-content">' . $label . '</label>';
                    return $return;
                }
            ]
        ); ?>-->
        <?php // CommonHelper::pr($model);exit;?>
        <?=

        $form->field($model, 'InterestID', 'explode(" ",$model->InterestID)')->dropDownList(
            ArrayHelper::map(CommonHelper::getInterests(), 'ID', 'Name'),
            [
                'class' => 'js-example-basic-multiple',
                'multiple' => 'multiple',
                //'selected'=>true,
                'prompt' => '$model->InterestID'
            ]
        );
        ?>

        <?= $form->field($model, 'FavioriteReadID')->DropDownList(
            ArrayHelper::map(CommonHelper::getFavouriteReads(), 'ID', 'Name'),
            [
                'class' => 'js-example-basic-multiple',
                'multiple' => 'multiple',
            ]
        );
        ?>
        <?= $form->field($model, 'FaviouriteMusicID')->dropDownList(
            ArrayHelper::map(CommonHelper::getFavouriteMusic(), 'ID', 'Name'),
            [
                'class' => 'js-example-basic-multiple',
                'multiple' => 'multiple',
            ]
        ); ?>
        <?= $form->field($model, 'FavouriteCousinesID')->dropDownList(
            ArrayHelper::map(CommonHelper::getFavouriteCousines(), 'ID', 'Name'),
            ['class' => 'js-example-basic-multiple',
                'multiple' => 'multiple',
            ]
        ); ?>
        <?= $form->field($model, 'SportsFittnessID')->dropDownList(
            ArrayHelper::map(CommonHelper::getSportsFitnActivities(), 'ID', 'Name'),
            ['class' => 'js-example-basic-multiple',
                'multiple' => 'multiple',
            ]
        ); ?>
        <?= $form->field($model, 'PreferredDressID')->dropDownList(
            ArrayHelper::map(CommonHelper::getPreferredDressStyle(), 'ID', 'Name'),
            ['class' => 'js-example-basic-multiple',
                'multiple' => 'multiple',
            ]
        ); ?>
        <?= $form->field($model, 'PreferredMovieID')->dropDownList(
            ArrayHelper::map(CommonHelper::getPreferredMovies(), 'ID', 'Name'),
            ['class' => 'js-example-basic-multiple',
                'multiple' => 'multiple',
            ]
        ); ?>
        <div class="row">
            <div class="">
                <input type="hidden" name="save" value="1">
                <?= Html::submitButton('save', ['class' => 'btn btn-primary pull-right preferences_submit', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'name' => 'register5', 'style' => 'padding:5px;font-size:14px;']) ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-primary pull-right', 'id' => 'cancel_edit_hobby', 'name' => 'cancel', 'style' => 'padding:5px;font-size:14px;margin-right:10px;']) ?>
            </div>
        </div>
        <?php ActiveForm::end();

        $this->registerCssFile(Yii::$app->request->baseUrl . '/plugings/select2/select2.min.css');
        $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/select2/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJs('
            $(".js-example-basic-multiple").select2({
                placeholder: "Select Option"
            });
        ');

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