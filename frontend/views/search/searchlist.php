<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\components\CommonHelper;
use common\components\MessageHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
$id = 0;
if (!Yii::$app->user->isGuest) {
    $Id = Yii::$app->user->identity->id;
}
$M1 = array();
?>

<div class="main-section">
    <?php
    if (!Yii::$app->user->isGuest) {
        echo $this->render('/layouts/parts/_headerafterlogin');
    } else {
        echo $this->render('/layouts/parts/_headerregister.php');
    }
    ?>
    <main>
        <div class="container">
            <?php if ($ErrorStatus) { ?>
                <div class="white-section listing border-sharp mrg-tp-10">
                    <div class="row mrg-tp-10">
                        <div class="col-md-12 middlebox">
                            <div class="notice kp_error">
                                <p><?= $ErrorMessage ?></p>
                            </div>
                            <div class="clearfix"></div>
                                <span class="pull-right mrg-tp-20"><a href="<?= Yii::$app->homeUrl ?>"
                                                                      class="text-right">Back To
                                        Home Page<i class="fa fa-angle-right"></i></a></span>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="sidebar1">
                                <div class="mrg-tp-20">
                                    <?php if ($SearchStatus) { ?>
                                    <div class="dropdown drp-lg">
                                        <button class="btn gray-filter dropdown-toggle" id="filter-toggle" type="button"
                                                aria-haspopup="true" aria-expanded="true"> Filters <i
                                                class="fa indicator fa-angle-down"></i></button>
                                        <div class="open-div">
                                            <?php
                                            $form = ActiveForm::begin([
                                                'id' => 'formsearch',
                                                'action' => ['search/basic-search'],
                                                'options' => ['data-pjax' => true],
                                                'layout' => 'horizontal',
                                                'validateOnChange' => false,
                                                'validateOnSubmit' => true,
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
                                            <div class="row">
                                                <?php
                                                $heightrange = range(134, 204);
                                                $range = range(18, 100);
                                                ?>
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs">
                                                                <?= $form->field($TempModel, 'AgeFrom')->dropDownList(
                                                                    array_combine($range, $range),
                                                                    ['class' => 'demo-default select-beast',
                                                                        'prompt' => 'From']
                                                                )->label(true)->error(false); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs">
                                                                <?= $form->field($TempModel, 'AgeTo')->dropDownList(
                                                                    array_combine($range, $range),
                                                                    ['class' => 'demo-default select-beast',
                                                                        'prompt' => 'To']
                                                                )->label(true)->error(false); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs">
                                                                <div class="form-group field-user-heightto">
                                                                    <label class="control-label col-sm-3 col-xs-3"
                                                                           for="user-heightfrom">Height From </label>

                                                                    <div class="col-sm-8 col-xs-8">
                                                                        <select id="user-heightfrom"
                                                                                class="demo-default select-beast"
                                                                                name="User[HeightFrom]">
                                                                            <option value="">Height From</option>
                                                                            <?php foreach (CommonHelper::getHeight() as $K => $V) { ?>
                                                                                <option
                                                                                    value="<?= $V['Centimeters'] ?>" <?= ($V['Centimeters'] == $TempModel->HeightFrom) ? 'selected' : '' ?>><?= $V['vName'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs">
                                                                <div class="form-group field-user-heightto">
                                                                    <label class="control-label col-sm-3 col-xs-3"
                                                                           for="user-heightto">Height To </label>

                                                                    <div class="col-sm-8 col-xs-8">
                                                                        <select id="user-heightto"
                                                                                class="demo-default select-beast"
                                                                                name="User[HeightTo]">
                                                                            <option value="">Height To</option>
                                                                            <?php foreach (CommonHelper::getHeight() as $K => $V) { ?>
                                                                                <option
                                                                                    value="<?= $V['Centimeters'] ?>" <?= ($V['Centimeters'] == $TempModel->HeightTo) ? 'selected' : '' ?>><?= $V['vName'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs hovertool" data-toggle="tooltip"
                                                                 data-placement="top"
                                                                 data-original-title="<?= Yii::$app->params['messageCommunitieBS'] ?>">
                                                                <?= $form->field($TempModel, 'iCommunity_ID')->dropDownList(
                                                                    ArrayHelper::map(CommonHelper::getCommunity(), 'iCommunity_ID', 'vName'),
                                                                    ['class' => 'demo-default select-beast',
                                                                        'prompt' => 'Community'
                                                                    ]
                                                                )->label(true)->error(false); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs hovertool" data-toggle="tooltip"
                                                                 data-placement="top"
                                                                 data-original-title="<?= Yii::$app->params['messageSubCommunitieBS'] ?>">
                                                                <?= $form->field($TempModel, 'iSubCommunity_ID')->dropDownList(
                                                                    ArrayHelper::map(CommonHelper::getSubCommunity(), 'iSubCommunity_ID', 'vName'),
                                                                    ['class' => 'demo-default select-beast',
                                                                        'prompt' => 'Sub Community']
                                                                )->label(true)->error(false); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs hovertool" data-toggle="tooltip"
                                                                 data-placement="top"
                                                                 data-original-title="<?= Yii::$app->params['messageReligionBS'] ?>">
                                                                <?= $form->field($TempModel, 'iReligion_ID')->dropDownList(
                                                                    ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
                                                                    ['class' => 'demo-default select-beast',
                                                                        'prompt' => 'Religion']
                                                                )->label(true)->error(false); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs">
                                                                <?= $form->field($TempModel, 'Marital_Status')->dropDownList(
                                                                    ArrayHelper::map(CommonHelper::getMaritalStatus(), 'iMaritalStatusID', 'vName'),
                                                                    ['class' => 'demo-default select-beast',
                                                                        'prompt' => 'Maritial Status',
                                                                    ]
                                                                )->label(true)->error(false); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs">
                                                                <!--  <?= $form->field($TempModel, 'iHeightID')->dropDownList(
                                                                    ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
                                                                    ['class' => 'demo-default select-beast',
                                                                        'prompt' => 'Height']
                                                                )->label(true)->error(false); ?> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs">
                                                                <?= $form->field($TempModel, 'Profile_for')->dropDownList(
                                                                    ['FEMALE' => 'BRIDE', 'MALE' => 'GROOM'],
                                                                    ['class' => 'demo-default select-beast',
                                                                        'prompt' => 'Looking For'
                                                                    ]
                                                                )->label(true); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="row">
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs">
                                                                <label for="amount">Area:</label>

                                                                <div id="slider-range"></div>
                                                                <input type="text" class="demo-default select-beast"
                                                                       id="amount" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="box">
                                                        <div class="mid-col">
                                                            <div class="form-cont bs">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="col-md-3 col-md-offset-2">
                                                        <div class="box">
                                                            <div class="mid-col">
                                                                <div class="form-cont bs">
                                                                    <?= Html::submitButton('search', ['class' => 'btn btn-primary', 'name' => 'button']) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="box">
                                                            <div class="mid-col">
                                                                <div class="form-cont bs">
                                                                    <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="box">
                                                            <div class="mid-col">
                                                                <div class="form-cont bs">
                                                                    <?= html::a('<i class="ti-power-off m-r-5"></i> Advanced Search</a>', ['search/advanced-search'], ['data-method' => 'post']) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="#">Test 1</a></li>
                                            <li><a href="#">Test 2</a></li>
                                            <li><a href="#">Test 3</a></li>
                                        </ul>
                                    </div>
                                    <div class="gray-bg mrg-tp-5">
                                        <div class="matches pull-left padd-10"><span> Matches Found: <span
                                                    class="orange-text"><?= $TotalRecords ?></span> </span></div>
                                        <div class="pull-right filter-small padd-10">
                                            <ul class="list-inline">
                                                <li><a href="#">Search By ID</a></li>
                                                <li><a href="#">Save Search</a></li>
                                                <li><a href="#">Modify Search</a></li>
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php if ($TotalRecords == 0) { ?>
                                    <div class="white-section listing border-sharp mrg-tp-10">
                                        <div class="row mrg-tp-10">
                                            <div class="col-md-12">
                                                <div class="notice kp_info">
                                                    <p><?= Yii::$app->params['noRecordsFoundInSearchList'] ?></p>
                                                </div>
                                                <div class="clearfix"></div>
                                <span class="pull-right"><a href="<?= Yii::$app->homeUrl ?>" class="text-right">Back To
                                        Home Page<i class="fa fa-angle-right"></i></a></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <?php

                                    foreach ($Model as $SK => $SV) {
                                        ?>
                                        <div
                                            class="white-section <?= ($SK == 0) ? 'listing' : ''; ?> border-sharp mrg-tp-10">
                                            <div class="row mrg-bt-20">
                                                <div class="col-sm-12">
                                                    <div class="featured-prof"><span class="featured-icon"></span> <span
                                                            class="thead">Featured Profile <a href="#"
                                                                                              data-toggle="tooltip"
                                                                                              data-placement="right"
                                                                                              title=""
                                                                                              data-original-title="This is where the help text will appear when the mouse hovers over the help icon">
                                                                <?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => '21']); ?>
                                                            </a></span></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="prof-pic">
                                                        <div class="drop-effect"></div>
                                                        <div class="slider">
                                                            <div id="carousel-example-generic_<?= $SK ?>"
                                                                 class="carousel slide"
                                                                 data-ride="carousel">
                                                                <!-- Wrapper for slides -->
                                                                <div class="carousel-inner">
                                                                    <?php
                                                                    if (is_array($Photos[$SV->id])) {
                                                                        foreach ($Photos[$SV->id] as $K => $V) {
                                                                            $SELECTED = '';
                                                                            $Photo = Yii::$app->params['thumbnailPrefix'] . '120_' . $V->File_Name;
                                                                            $Yes = 'No';
                                                                            if ($V['Is_Profile_Photo'] == 'YES') {
                                                                                $SELECTED = "active";
                                                                                $Photo = '120' . $SV->propic;
                                                                                $Yes = 'Yes';
                                                                            } ?>
                                                                            <div
                                                                                class="item <?= ($K == 0) ? 'active' : ''; ?>">
                                                                                <?= Html::img(CommonHelper::getPhotos('USER', $SV->id, $Photo, 120, '', $Yes), ['width' => '205', 'height' => '205', 'alt' => 'Profile', 'class' => 'img-responsive']); ?>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } else { ?>
                                                                        <div class="item active">
                                                                            <?= Html::img(CommonHelper::getPhotos('USER', $SV->id, $Photos[$SV->id], 120), ['width' => '205', 'height' => '205', 'alt' => 'Profile', 'class' => 'img-responsive item']); ?>
                                                                        </div>
                                                                    <?php }
                                                                    ?>
                                                                </div>
                                                                <!-- Controls -->
                                                                <?php if (is_array($Photos[$SV->id])) { ?>
                                                                <a class="left carousel-control"
                                                                   href="#carousel-example-generic_<?= $SK ?>"
                                                                   data-slide="prev"> <span
                                                                        class="glyphicon glyphicon-chevron-left"></span>
                                                                </a> <a class="right carousel-control"
                                                                        href="#carousel-example-generic_<?= $SK ?>"
                                                                        data-slide="next">
                                                                    <span
                                                                        class="glyphicon glyphicon-chevron-right"></span>
                                                                    </a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if (is_array($Photos[$SV->id])) { ?>
                                                        <!-- <p class="text-right"><a href="#" data-toggle="modal"
                                                                                  data-target="#photo">View
                                                                 Album <i class="fa fa-angle-right"></i></a></p>-->
                                                    <?php } ?>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="name-panel">
                                                        <h2 class="nameplate">
                                                            <?php
                                                            if (!Yii::$app->user->isGuest) { ?>
                                                                <a href="<?= Yii::$app->homeUrl ?>user/profile?uk=<?= $SV->Registration_Number ?>&source=profile_viewed_by"
                                                                   class="name"
                                                                   title="<?= $SV->Registration_Number ?>">
                                                                    <?= $SV->FullName; ?>
                                                                </a>
                                                            <?php } else { ?>
                                                                <?= $SV->FullName; ?>
                                                            <?php } ?>
                                                            <span class="font-light">(<?= $SV->Registration_Number ?>
                                                                )</span>
                                                            <?php
                                                            #$USER_FACEBOOK = \common\models\User::weightedCheck(11);
                                                            $USER_PHONE = \common\models\User::weightedCheck(8);
                                                            $USER_EMAIL = \common\models\User::weightedCheck(9);
                                                            $USER_APPROVED = \common\models\User::weightedCheck(10);
                                                            if ($USER_PHONE && $USER_EMAIL && $USER_APPROVED) {
                                                                ?>
                                                                <span class="premium"></span>
                                                            <?php } ?>
                                                        </h2>
                                                        <?php $USER_PHONE = \common\models\User::weightedCheck(8); ?>
                                                        <p>Profile created by <?= $SV->Profile_created_for; ?> | Last
                                                            online <?= CommonHelper::DateTime($SV->LastLoginTime, 28); ?>
                                                            |
                                                        <span class="pager-icon">
                                                    <a href="javascript:void(0)">
                                                        <i class="fa fa-mobile"></i>
                                                      <span
                                                          class="badge <?php if ($SV->ePhoneVerifiedStatus != 'Yes') { ?>badge1<?php } ?>">
                                                          <i class="fa fa-check"></i>
                                                      </span>
                                                    </a>
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <dl class="dl-horizontal mrg-tp-20">
                                                        <dt>Personal Details</dt>
                                                        <dd><?= CommonHelper::getAge($SV->DOB); ?>
                                                            yrs, <?= CommonHelper::setInputVal($SV->height->vName, 'text'); ?>
                                                            <?= ($SV->RaashiId > 0) ? ", " . CommonHelper::setInputVal($SV->raashiName->Name, 'text') : ''; ?>
                                                        </dd>
                                                        <dt>Marital Status</dt>
                                                        <dd><?= CommonHelper::setInputVal($SV->maritalStatusName->vName, 'text') ?></dd>
                                                        <dt>Religion Community</dt>
                                                        <dd><?= CommonHelper::setInputVal($SV->religionName->vName, 'text') . ',' . CommonHelper::setInputVal($SV->communityName->vName, 'text') ?></dd>
                                                        <dt>Education</dt>
                                                        <dd><?= CommonHelper::setInputVal($SV->educationLevelName->vEducationLevelName, 'text') ?></dd>
                                                        <dt>Profession</dt>
                                                        <dd><?= CommonHelper::setInputVal($SV->workingAsName->vWorkingAsName, 'text') ?></dd>
                                                        <dt>Current Location</dt>
                                                        <dd><?= CommonHelper::setInputVal($SV->cityName->vCityName, 'text') . ', ' . CommonHelper::setInputVal($SV->countryName->vCountryName, 'text') ?></dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <?php
                                            if (!Yii::$app->user->isGuest) {
                                                if ($SV->Gender != Yii::$app->user->identity->Gender) { ?>
                                                    <div class="row gray-bg">
                                                        <div class="col-sm-12">
                                                            <div class="profile-control-vertical">
                                                                <ul class="list-unstyled pull-right">
                                                                    <li><a href="#">Shortlist <i
                                                                                class="fa fa-list-ul"></i></a>
                                                                    </li>
                                                                    <li class="s__<?= $SV->id ?>">
                                                                        <?php

                                                                        $Value = \common\models\UserRequestOp::checkSendInterest(Yii::$app->user->identity->id, $SV->id);
                                                                        #CommonHelper::pr(\common\models\UserRequestOp::checkSendInterest(Yii::$app->user->identity->id, $ValueRM->id));
                                                                        if (count($Value)) {
                                                                            if ($Id == $Value->from_user_id && $Value->profile_viewed_from_to == 'Yes') {
                                                                                $ViewerId = $Value->to_user_id;
                                                                            } else {
                                                                                $ViewerId = $Value->from_user_id;
                                                                            }
                                                                        } else {
                                                                            $ViewerId = $Value->id;
                                                                        }
                                                                        $UserInfoModel = \common\models\User::getUserInfroamtion($ViewerId);

                                                                        if (count($Value) == 0 || ($Id == $Value->from_user_id && $Value->send_request_status_from_to == 'No' && $Value->send_request_status_to_from == 'No') || ($Id == $Value->to_user_id && $Value->send_request_status_to_from == 'No' && $Value->send_request_status_from_to == 'No')) { ?>
                                                                            <a href="javascript:void(0)"
                                                                               class=" sendinterestpopup"
                                                                               role="button"
                                                                               data-target="#sendInterest"
                                                                               data-toggle="modal"
                                                                               data-id="<?= $SV->id ?>"
                                                                               data-name="<?= $SV->fullName ?>"
                                                                               data-rgnumber="<?= $SV->Registration_Number ?>">Send
                                                                                Interest
                                                                                <i class="fa fa-heart-o"></i>
                                                                            </a>
                                                                        <?php } else if (($Id == $Value->from_user_id && $Value->send_request_status_from_to == 'Yes' && $Value->send_request_status_to_from != 'Yes') || ($Id == $Value->to_user_id && $Value->send_request_status_to_from == 'Yes' && $Value->send_request_status_from_to != 'Yes')) { ?>
                                                                            <a href="javascript:void(0)"
                                                                               class=" ci " role="button"
                                                                               data-target="#"
                                                                               data-toggle="modal"
                                                                               data-id="<?= $UserInfoModel->id ?>"
                                                                               data-name="<?= $UserInfoModel->fullName ?>"
                                                                               data-rgnumber="<?= $UserInfoModel->Registration_Number ?>">Cancel
                                                                                Interest
                                                                                <i class="fa fa-close"></i> </a>

                                                                        <?php } else if (($Id == $Value->to_user_id && $Value->send_request_status_from_to == 'Yes' && $Value->send_request_status_to_from != 'Yes') || ($Id == $Value->from_user_id && $Value->send_request_status_to_from == 'Yes' && $Value->send_request_status_from_to != 'Yes')) {
                                                                            ?>
                                                                            <a href="javascript:void(0)"
                                                                               class=" accept_decline adbtn"
                                                                               role="button"
                                                                               data-target="#accept_decline"
                                                                               data-toggle="modal"
                                                                               data-id="<?= $UserInfoModel->id ?>"
                                                                               data-name="<?= $UserInfoModel->fullName ?>"
                                                                               data-rgnumber="<?= $UserInfoModel->Registration_Number ?>"
                                                                               data-type="Accept Interest">
                                                                                Accept
                                                                                <i class="fa fa-check"></i>
                                                                            </a>
                                                                            <a href="javascript:void(0)"
                                                                               class="accept_decline adbtn"
                                                                               role="button"
                                                                               data-target="#accept_decline"
                                                                               data-toggle="modal"
                                                                               data-id="<?= $UserInfoModel->id ?>"
                                                                               data-name="<?= $UserInfoModel->fullName ?>"
                                                                               data-rgnumber="<?= $UserInfoModel->Registration_Number ?>"
                                                                                >
                                                                                Decline
                                                                                <i class="fa fa-close"></i> </a>
                                                                        <?php } else if ($Value->send_request_status_from_to == 'Accepted' || $Value->send_request_status_to_from == 'Accepted') {
                                                                            ?>
                                                                            <a href="javascript:void(0)" class=""
                                                                               role="button"
                                                                               data-target="#" data-toggle="modal"
                                                                               data-id="<?= $UserInfoModel->id ?>"
                                                                               data-name="<?= $UserInfoModel->fullName ?>"
                                                                               data-rgnumber="<?= $UserInfoModel->Registration_Number ?>"
                                                                               data-type="Connected">Connected
                                                                                <i class="fa fa-heart"></i> </a>
                                                                        <?php } else if ($Value->send_request_status_from_to == 'Rejected' || $Value->send_request_status_to_from == 'Rejected') {
                                                                            ?>
                                                                            <a href="javascript:void(0)" class=" "
                                                                               role="button"
                                                                               data-target="#" data-toggle="modal"
                                                                               data-id="<?= $UserInfoModel->id ?>"
                                                                               data-name="<?= $UserInfoModel->fullName ?>"
                                                                               data-rgnumber="<?= $UserInfoModel->Registration_Number ?>"
                                                                               data-type="Connected">Rejected <i
                                                                                    class="fa fa-close"></i> </a>

                                                                        <?php } else { ?>
                                                                            <a href="javascript:void(0)"
                                                                               class="btn btn-link isent" role="button">Interest
                                                                                Sent <i class="fa fa-heart"></i></a>
                                                                        <?php } ?>
                                                                        <!--
                                                                    <a href="javascript:void(0)" class="isent"
                                                                       role="button">Interest Sent <i
                                                                            class="fa fa-heart"></i></a>
                                                                <?php /*} else { */ ?>
                                                                    <a href="javascript:void(0)"
                                                                       class="sendinterestpopup"
                                                                       role="button"
                                                                       data-target="#sendInterest"
                                                                       data-toggle="modal"
                                                                       data-id="<? /*= $SV->id */ ?>"
                                                                       data-name="<? /*= $SV->FullName */ ?>"
                                                                       data-rgnumber="<? /*= $SV->Registration_Number */ ?>">Send
                                                                        Interest
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                --><?php /*} */ ?>
                                                                    </li>

                                                                    <li>
                                                                        <a href="#" data-toggle="modal"
                                                                           class="send_email"
                                                                           <?php if (Yii::$app->user->isGuest) { ?>data-target="#sendMail"<?php } else { ?> data-id="<?= $SV->id ?>" <?php } ?>>Send
                                                                            Email <i class="fa fa-envelope-o"></i>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                            <?php } else { ?>
                                                <div class="row gray-bg">
                                                    <div class="col-sm-12">
                                                        <div class="profile-control-vertical">
                                                            <ul class="list-unstyled pull-right">
                                                                <li>
                                                                    <a href="javascript:void(0)" class="send_email"
                                                                       role="button"
                                                                       data-target="#sendMail" data-toggle="modal"
                                                                        >Shortlist <i class="fa fa-list-ul"></i></a>
                                                                </li>
                                                                <li class="s__<?= $SV->id ?>">
                                                                    <a href="javascript:void(0)" class="send_email"
                                                                       role="button"
                                                                       data-target="#sendMail" data-toggle="modal"
                                                                        >Send Interest <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" data-toggle="modal" class="send_email"
                                                                       data-target="#sendMail">Send Email <i
                                                                            class="fa fa-envelope-o"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <div class="mrg-bt-10 text-center">
                                        <nav>
                                            <?php require_once(__DIR__ . '/pagination.php'); ?>
                                        </nav>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!--<div class="col-md-5 col-sm-12 mrg-tp-20">
                            <div class="map">
                                <iframe width="100%" height="1000" frameborder="0" scrolling="no" marginheight="0"
                                        marginwidth="0"
                                        src="https://maps.google.co.uk/maps?f=q&source=s_q&hl=en&geocode=&q=15+Springfield+Way,+Hythe,+CT21+5SH&aq=t&sll=52.8382,-2.327815&sspn=8.047465,13.666992&ie=UTF8&hq=&hnear=15+Springfield+Way,+Hythe+CT21+5SH,+United+Kingdom&t=m&z=14&ll=51.077429,1.121722&output=embed">
                                </iframe>
                        </div>-->
                    </div>
                </div>
            <?php } ?>
        </div>
</div>
</main>
</div>
<div class="modal fade" id="photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                        class="sr-only">Close</span></button>
                <h2 class="text-center"> Photo Gallery</h2>
                <!--<div class="profile-control photo-btn">
                    <button class="btn " type="button"> Upload Video or Photo</button>
                    <button class="btn active" type="button"> Choose from Photos</button>
                    <button class="btn" type="button"> Albums</button>
                </div>-->
            </div>
            <!-- Modal Body -->
            <div class="modal-body photo-gallery">
                <div class="choose-photo">
                    <div class="row" id="profile_list_popup">
                        <?php
                        if (count($PhotoList) > 0) {
                            foreach ($PhotoList as $K => $V) {
                                ?>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <?php $SELECTED = '';
                                    if ($V['Is_Profile_Photo'] == 'YES') {
                                        $SELECTED = "selected";
                                    } ?>
                                    <a href="javascript:void(0)" class="pull-left"
                                       data-id="<?= $V['iPhoto_ID'] ?>">
                                        <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name'], 140), ['class' => 'img-responsive ' . $SELECTED, 'height' => '140', 'alt' => 'Photo' . $K, 'style' => 'height:140px;']); ?>
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
        </div>
    </div>
</div>
<div class="modal fade" id="sendMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <p class="text-center mrg-bt-10">
            <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
        </p>
        <?php Pjax::begin(['id' => 'my_index', 'enablePushState' => false]); ?>
        <div class="send_message">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span></button>
                    <?php
                    if (!Yii::$app->user->isGuest) { ?>
                        <h2 class="text-center">Please Wait</h2>
                    <?php } else { ?>
                        <h2 class="text-center">Information</h2>
                    <?php } ?>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mrg-tp-10 profile-control">
                            <?php
                            if (!Yii::$app->user->isGuest) { ?>
                                <i class="fa fa-spinner fa-spin pink"></i> Loading Information...
                            <?php } else { ?>
                                <div class="notice kp_warning marg-l"><p><?= Yii::$app->params['loginFirst'] ?></p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <a href="<?= Yii::$app->homeUrl ?>?ref=login" class="btn active pull-right"
                                       title="Login" id="login_button">Login</a>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 ">
                                    <a href="<?= Yii::$app->homeUrl ?>?ref=signup" title="Sign up Free"
                                       class="btn active pull-left">Sign up Free</a>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php if (!Yii::$app->user->isGuest) { ?>
    <div class="modal fade" id="sendInterest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <p class="text-center mrg-bt-10">
                <img src="<?= CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
            </p>

            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"><span aria-hidden="true">&times;</span> <span
                            class="sr-only">Close</span>
                    </button>
                    <h4 class="text-center"> Send Interest </h4>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form>
                        <div class="text-center">
                            <!--<p class="mrg-bt-10 font-15"><span class="text-success"><strong>&#10003;</strong></span> Your interest has been sent successfully to</p>-->
                            <div class="fb-profile-text mrg-bt-30 text-dark">
                                <h1 id="to_name"></h1>(<span class="sub-text mrg-tp-10" id="to_rg_number"></span>)
                            </div>

                            <h6 class="mrg-bt-30 font-15 text-dark">
                                <strong><?= Yii::$app->params['sendInterest'] ?></strong>
                            </h6>
                            <!--<h6 class="mrg-bt-30 font-15 text-dark"><strong>Request the member to add the following details</strong></h6>-->

                            <div class="checkbox mrg-tp-0 profile-control">
                                <!--<input id="Photo" type="checkbox" name="Photo" value="check1">
                                <label for="Photo" class="control-label">Photo</label>
                                <input id="Horoscope" type="checkbox" name="Horoscope" value="check1">
                                <label for="Horoscope" class="control-label">Horoscope</label>-->
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <button type="button" class="btn active pull-right send_request" data-id=""
                                                data-parentid=""> Send
                                            Interest
                                        </button>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                                        <button type="button" class="btn active pull-left" data-dismiss="modal">Back
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <!-- Modal Footer -->
            </div>
        </div>
    </div>
    <?php
    require_once dirname(__DIR__) . '/user/_useroperation.php';
}
?>
<?php
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/slider.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/cover/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php

$this->registerJs('
       jQuery(document).ready(function($) {

        $("#myCarousel").carousel({
                interval: 5000
        });

        $("#carousel-text").html($("#slide-content-0").html());

        //Handles the carousel thumbnails
       $("[id^=carousel-selector-]").click( function(){
         var id = this.id.substr(this.id.lastIndexOf("-") + 1);
         var id = parseInt(id);
         $("#myCarousel").carousel(id);
       });


        // When the carousel slides, auto update the text
        $("#myCarousel").on("slid.bs.carousel", function (e) {
          var id = $(".item.active").data("slide-number");
          $("#carousel-text").html($("#slide-content-"+id).html());
        });
});
    $(document).on("click",".send_email",function(e){
        var formData = new FormData();
        formData.append("ToUserId", $(this).data("id"));
        formData.append("UserId", ' . Yii::$app->user->identity->id . ');
        loaderStart();
         $.ajax({
                        url: "' . Yii::$app->homeUrl . 'user/send-email-profile",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR) {
                            loaderStop();
                            var DataObject = JSON.parse(data);
                            notificationPopup(DataObject.STATUS, DataObject.MESSAGE, DataObject.TITLE);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                                notificationPopup(\'ERROR\', \'Something went wrong. Please try again !\', \'Error\');
                                loaderStop();
                        }
         });

    });
    $(document).on("click",".send_request",function(e){
      Pace.restart();
      loaderStart();
      var formData = new FormData();
      formData.append("ToUserId", $(this).data("id"));
      formData.append("Action", "SEND_INTEREST");
      sendRequestDashboard("' . Url::to(['user/send-int-dashboard']) . '",".requests","SL",$(this).data("parentid"),formData);
    });

    $(document).on("click",".a_b_d",function(e){
      Pace.restart();
      loaderStart();
      var formData = new FormData();
      formData.append("ToUserId", $(this).data("id"));
      formData.append("Name", $(".to_name").text());
      formData.append("RGNumber", $(".to_rg_number").text());
      formData.append("Action",  $(this).data("type"));
      sendRequestDashboard("' . Url::to(['user/user-request']) . '",".requests","R_A_D_B",$(this).data("parentid"),formData);
      //sendRequest("' . Url::to(['user/user-request']) . '",".requests",formData);
    });

');
?>
<style>
    .bs label {
        font-weight: bold;
        display: block;
        position: inherit;
        color: #696767;
        height: 20px;
    }

    #amount {
        -webkit-border-radius: 2px;
        border: #c4c4c4 1px solid;
        padding: 1px;
        -moz-box-shadow: 0 0 5px #dad9d9 inset;
        -webkit-box-shadow: 0 0 5px #dad9d9 inset;
        box-shadow: 0 0 5px #dad9d9 inset;
        height: 42px;
    }

    .box {
        margin: 0px !important;
    }

    .cs-select span {
        padding: 0.4em 01em !important;
    }

    div.cs-select {
        height: 42px !important;
    }
</style>
