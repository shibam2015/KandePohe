<?php
use yii\helpers\Html;
use common\components\CommonHelper;

#\common\components\CommonHelper::pr($SimilarProfile);
?>
<div class="col-sm-12 col-md-3">
    <div class="bg-white padd-20">
        <?php if (count($SimilarProfile) > 0) { ?>
            <div class="ad-title">
                Similar Profiles
            </div>
            <ul class="list-unstyled ad-prof">
                <?php foreach ($SimilarProfile as $SPK => $SPV) { ?>
                    <li>
                              <span class="imgarea">
                                  <?= Html::img(CommonHelper::getPhotos('USER', $SPV->id, $SPV->propic, 75, 1), ['alt' => $SPV->FullName, 'class' => '', 'style' => '    width: 65px !important;']); ?>
                              </span>
                              <span class="img-desc">
                                      <p class="name"><strong><?= $SPV->FullName ?></strong></p>
                                      <p>
                                          <?= CommonHelper::getAge($SPV->DOB); ?>
                                          years<?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($SPV->height->vName, 'text')); ?> <?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($SPV->religionName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($SPV->communityName->vName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($SPV->workingAsName->vWorkingAsName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($SPV->cityName->vCityName, 'text')); ?><?= CommonHelper::setCommaInValue(CommonHelper::setInputVal($SPV->countryName->vCountryName, 'text')); ?>
                                      </p>
                              </span>

                        <div class="clearfix"></div>
                    </li>
                <?php } ?>
            </ul>
            <span class="pull-right">
                <a href="#" class="text-right">See All <i class="fa fa-angle-right"></i></a>
            </span>
            <div class="clearfix"></div>
            <div class="border"></div>
        <?php } ?>

        <div class="ad-title">Success Stories</div>
        <div class="mrg-bt-10">
            <?= Html::img('@web/images/image1.jpg', ['width' => '', 'height' => '', 'alt' => 'Image', 'class' => 'img-responsive']); ?>
        </div>
        <span class="pull-right"><a href="#" class="text-right">Read All Stories <i
                    class="fa fa-angle-right"></i></a></span>

        <div class="clearfix"></div>

        <div class="border"></div>
        <div class="ad-title">Interest Accepted</div>
        <ul class="list-unstyled ad-prof">
            <li>
                <span class="imgarea">
                    <?= Html::img('@web/images/profile4.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?>
                  </span>
                <span class="img-desc">
                  <p class="name">Mrunmal Sawant</p>
                  <p>27
                      , 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                </span>

                <div class="clearfix"></div>
            </li>
            <li>
                <span class="imgarea">
                    <?= Html::img('@web/images/heart.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?>
                </span>
                <span class="img-desc">
                  <td width="87%" align="left" valign="top"><p><strong>Mrunmal Sawant</strong></p>

                      <p>has accepted your interest and would like to hear from you.</p></td>
                </span>

                <div class="clearfix"></div>
            </li>
        </ul>
        <!--</table>-->
        <span class="pull-right"><a href="#" class="text-right">Get in touch with her <i class="fa fa-angle-right"></i></a></span>

        <div class="clearfix"></div>
    </div>
</div>