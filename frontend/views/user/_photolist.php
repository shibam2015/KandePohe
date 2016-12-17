<?php
use common\components\CommonHelper;
use yii\bootstrap\Html;
if (count($model) > 0) {
    foreach ($model as $K => $V) {
        ?>
        <?php $SELECTED = '';
        if ($V['Is_Profile_Photo'] == 'YES') {
            $SELECTED = "selected";
        }
        $PhotoHeading = '';
        $PhotoMessage = '';
        if ($V->eStatus == 'Approve') {
            $PhotoHeading = 'Approved';
            $PhotoMessage = Yii::$app->params['photoApprovedMode'];
        } else if ($V->eStatus == 'Pending') {
            $PhotoHeading = 'Pending';
            $PhotoMessage = Yii::$app->params['photoPendingMode'];
        } else {
            $PhotoHeading = 'Disapproved';
            $PhotoMessage = Yii::$app->params['photoDisapprovedMode'];
        }
        ?>
        <div data-src="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
             data-sub-html="<h4><?= $PhotoHeading ?></h4><p><?= $PhotoMessage ?></p>"
             class="kp_gallery col-md-3 col-sm-3 col-xs-6">
            <div class="<?= ($V->eStatus == 'Approve') ? 'gallery1 ' : 'img-blur' ?>">
                <a class="<?= $SELECTED ?>"
                   data-toggle="tooltip" data-placement="top"
                   href="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                    <?php if ($V->eStatus == 'Approve') { ?>
                        data-original-title="Click for full view"
                    <?php } else { ?>
                        data-original-title="<?= ($V->eStatus == 'Pending') ? 'Awaiting Approval' : 'Please Remove this Photo.' ?>"
                    <?php } ?>>
                    <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, Yii::$app->params['thumbnailPrefix'] . "110_" . $V['File_Name'], 110), ['class' => 'img-responsive ' . $SELECTED, 'width' => '140', 'alt' => 'Photo' . $K]); ?>
                </a>
            </div>
            <?php if ($V->eStatus == 'Approve') { ?>
                <a href="javascript:void(0)"
                   class="pull-left profile_set_kp set_profile_photo kp_not_gallery"
                   data-id="<?= $V['iPhoto_ID'] ?>"
                   data-target="#profilecrop" data-toggle="modal"
                   data-item="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                   data-name="<?= $V['File_Name'] ?>">
                    Profile pic
                </a>
                <!--<a href="javascript:void(0)"
                   class="pull-right profile_delete kp_not_gallery"
                   data-id="<? /*= $V['iPhoto_ID'] */ ?>"
                   data-target="#photodelete" data-toggle="modal">
                    <i aria-hidden="true" class="fa fa-trash-o"></i>
                </a>-->
            <?php } else { ?>
                <a href="javascript:void(0)"
                   class="kp_not_gallery"
                   data-id="<?= $V['iPhoto_ID'] ?>"
                   data-item="<?= CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name']) ?>"
                   data-name="<?= $V['File_Name'] ?>">
                    <?= ($V->eStatus == 'Pending') ? 'Pending' : 'Disapproved' ?>
                </a>
                <?php if ($V->eStatus == 'Disapprove') { ?>
                    <!--<a href="javascript:void(0)"
                       class="pull-right profile_delete kp_not_gallery"
                       data-id="<? /*= $V['iPhoto_ID'] */ ?>"
                       data-target="#photodelete"
                       data-toggle="modal">
                        <i aria-hidden="true"
                           class="fa fa-trash-o"></i>
                    </a>-->
                <?php } ?>
            <?php } ?>
            <a href="javascript:void(0)"
               class="pull-right profile_delete kp_not_gallery"
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