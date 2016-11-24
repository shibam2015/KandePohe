<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\components\CommonHelper;

?>
<div class="modal-body photo-gallery">
    <div class="profile-control photo-btn">
        <button class="btn " type="button"> Upload Video or Photo</button>
        <button class="btn active" type="button"> Choose from Photos</button>
        <button class="btn" type="button"> Albums</button>
    </div>
    <div class="choose-photo mrg-tp-20 text-center">
        <div class="row" id="profile_list_popup">
            <?php
            if (count($model) > 0) {
                foreach ($model as $K => $V) {
                    ?>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <?php $SELECTED = '';
                        if ($V['Is_Profile_Photo'] == 'YES') {
                            $SELECTED = "selected";
                        } ?>
                        <a href="javascript:void(0)" class="pull-left profile_set"
                           data-id="<?= $V['iPhoto_ID'] ?>"
                           data-target="#photodelete" data-toggle="modal">
                            <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->params['thumbnailPrefix'] . "120_" . $V['File_Name'], 120), ['class' => 'img-responsive ' . $SELECTED, 'height' => '', 'alt' => 'Photo' . $K]); ?>
                        </a>
                    </div>
                <?php }
            } else {
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <p> No Photos Available</p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
