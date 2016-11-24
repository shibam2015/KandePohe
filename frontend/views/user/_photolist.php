<?php
use common\components\CommonHelper;
use yii\bootstrap\Html;

#CommonHelper::pr($model);exit;
if (count($model) > 0) {
    foreach ($model as $K => $V) {
        ?>
        <?php $SELECTED = '';
        if ($V['Is_Profile_Photo'] == 'YES') {
            $SELECTED = "selected";
        } ?>
        <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="gallery">
                <a class="<?= $SELECTED ?>"
                   href="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>">
                    <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->params['thumbnailPrefix'] . "110_" . $V['File_Name'], 110), ['class' => 'img-responsive ' . $SELECTED, 'width' => '140', 'alt' => 'Photo' . $K]); ?>
                </a>
            </div>
            <a href="javascript:void(0)"
               class="pull-left profile_set"
               data-id="<?= $V['iPhoto_ID'] ?>"
               data-target="#photodelete" data-toggle="modal">
                Profile pic
            </a>
            <a href="javascript:void(0)"
               class="pull-right profile_delete"
               data-id="<?= $V['iPhoto_ID'] ?>"
               data-target="#photodelete" data-toggle="modal">
                <i aria-hidden="true" class="fa fa-trash-o"></i>
            </a>
        </div>
    <?php }
} else {
    ?>
    <div class="col-md-12 col-md-offset-1 col-sm-12 col-xs-12 text-center mrg-tp-20">
        <div class="notice kp_info"><p>No Photos Available.</p></div>
    </div>
<?php } ?>