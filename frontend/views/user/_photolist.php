<?php
use common\components\CommonHelper;
use yii\bootstrap\Html;
if (count($model) > 0) {
    foreach ($model as $K => $V) {
        ?>
        <?php $SELECTED = '';
        if ($V['Is_Profile_Photo'] == 'YES') {
            $SELECTED = "selected";
        } ?>
        <div
            class="col-md-3 col-sm-3 col-xs-6 <?= ($V->eStatus == 'Approve' || $V->eStatus == 'Disapprove') ? '' : '   text-center' ?>">
            <div class="<?= ($V->eStatus == 'Approve') ? 'gallery ' : 'img-blur' ?>">
                <a class="<?= $SELECTED ?>"
                   data-toggle="tooltip" data-placement="top"
                    <?php if ($V->eStatus == 'Approve') { ?>
                        href="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                        data-original-title="Click for full view"
                    <?php } else { ?>
                        href="javascript:void(0)"
                        data-original-title="<?= ($V->eStatus == 'Pending') ? 'Awaiting Approval' : 'Please Remove this Photo.' ?>"
                    <?php } ?>>
                    <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->params['thumbnailPrefix'] . "110_" . $V['File_Name'], 110), ['class' => 'img-responsive ' . $SELECTED, 'width' => '140', 'alt' => 'Photo' . $K]); ?>
                </a>
            </div>
            <?php if ($V->eStatus == 'Approve') { ?>
                <a href="javascript:void(0)"
                   class="pull-left profile_set_kp set_profile_photo"
                   data-id="<?= $V['iPhoto_ID'] ?>"
                   data-target="#profilecrop" data-toggle="modal"
                   data-item="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                   data-name="<?= $V['File_Name'] ?>">
                    Profile pic
                </a>
                <a href="javascript:void(0)"
                   class="pull-right profile_delete"
                   data-id="<?= $V['iPhoto_ID'] ?>"
                   data-target="#photodelete" data-toggle="modal">
                    <i aria-hidden="true" class="fa fa-trash-o"></i>
                </a>
            <?php } else { ?>
                <a href="javascript:void(0)"
                   class=""
                   data-id="<?= $V['iPhoto_ID'] ?>"
                   data-item="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                   data-name="<?= $V['File_Name'] ?>">
                    <?= ($V->eStatus == 'Pending') ? 'Pending' : 'Disapproved' ?>
                </a>
                <?php if ($V->eStatus == 'Disapprove') { ?>
                    <a href="javascript:void(0)"
                       class="pull-right profile_delete"
                       data-id="<?= $V['iPhoto_ID'] ?>"
                       data-target="#photodelete"
                       data-toggle="modal">
                        <i aria-hidden="true"
                           class="fa fa-trash-o"></i>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    <?php }
} else {
    ?>
    <div class="col-md-12 col-md-offset-1 col-sm-12 col-xs-12 text-center mrg-tp-20">
        <div class="notice kp_info"><p>No Photos Available.</p></div>
    </div>
<?php } ?>