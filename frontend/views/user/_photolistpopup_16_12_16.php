<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\components\CommonHelper;

?>
<div class="modal-body photo-gallery">
    <div class="profile-control photo-btn">
        <button class="btn file_browse_wrapper" type="button"> Upload Video or Photo</button>
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
                        <div class="hovertool<?= ($V->eStatus == 'Approve') ? '' : ' img-blur' ?>">
                            <a class="<?= $SELECTED ?><?= ($V->eStatus == 'Approve') ? ' profile_set_kp set_profile_photo' : '' ?>"
                               data-toggle="tooltip" data-placement="top"
                               href="javascript:void(0)"
                                <?php if ($V->eStatus == 'Approve') { ?>
                                    data-original-title="Click for select Photo as Profile Photo"
                                    data-id="<?= $V['iPhoto_ID'] ?>"
                                    data-target="#profilecrop" data-toggle="modal"
                                    data-item="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                                    data-name="<?= $V['File_Name'] ?>"
                                <?php } else { ?>
                                    data-original-title="<?= ($V->eStatus == 'Pending') ? 'Awaiting Approval' : 'Please Remove this Photo.' ?>"
                                <?php } ?>>
                                <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->params['thumbnailPrefix'] . "120_" . $V['File_Name'], 120), ['class' => 'img-responsive ' . $SELECTED, 'width' => '140', 'alt' => 'Photo' . $K]); ?>
                            </a>
                        </div>

                        <!--<a href="javascript:void(0)"
                           class="pull-left profile_set_kp set_profile_photo"
                           data-id="<?/*= $V['iPhoto_ID'] */ ?>"
                           data-target="#profilecrop" data-toggle="modal"
                           data-item="<?/*= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) */ ?>"
                           data-name="<?/*= $V['File_Name'] */ ?>">
                            <?/*= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->params['thumbnailPrefix'] . "120_" . $V['File_Name'], 120), ['class' => 'img-responsive ' . $SELECTED, 'height' => '', 'alt' => 'Photo' . $K]); */ ?>
                        </a>-->
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
