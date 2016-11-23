<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\components\CommonHelper;
use common\components\MessageHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

$id = 0;
$PROFILE_COMPLETENESS = 50;

if (!Yii::$app->user->isGuest) {
    $Id = Yii::$app->user->identity->id;
}

$HOME_URL = Yii::getAlias('@web') . "/";
$HOME_URL_SITE = Yii::getAlias('@web') . "/site/";
$UPLOAD_DIR = Yii::getAlias('@frontend') . '/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') . '/web/';

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
            <div class="row">
                <div class="col-md-12">
                    <div class="gray-tabs-block mrg-tp-30">
                        <div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="#tab1" aria-controls="Basic Search" role="tab"
                                                           data-toggle="tab">Basic Search</a></li>
                                <li role="presentation" class="active"><a href="#tab2" aria-controls="Advanced Search"
                                                                          role="tab" data-toggle="tab">Advanced
                                        Search</a></li>
                                <li role="presentation"><a href="#tab3" aria-controls="My Saved Searches" role="tab"
                                                           data-toggle="tab">My Saved Searches</a></li>
                                <li class="dropdown search-profile pull-right"><a href="#" class="dropdown-toggle"
                                                                                  data-toggle="dropdown"><img
                                            src="images/prof-search-icon.jpg" width="26" height="17"> Search By Profile
                                        ID</a>
                                    <ul class="dropdown-menu">
                                        <div class="pop-over">
                                            <form class="form-inline">
                                                <button type="submit" class="btn btn-default pull-right"><i
                                                        class="glyphicon glyphicon-search text-danger"></i></button>
                                                <input type="text" class="form-control pull-left"
                                                       placeholder="Enter Profile ID">
                                            </form>
                                        </div>
                                    </ul>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="tab1">
                                    <p>Under Construction...</p>
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="tab2">
                                    <div class="bs-accordian">
                                        <div class="panel-group" id="accordion">
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
                                                        //'label' => 'col-sm-3 col-xs-3',
                                                        'offset' => '',
                                                        'wrapper' => 'col-sm-12 col-xs-12',
                                                        'error' => '',
                                                        'hint' => '',
                                                    ]
                                                ]
                                            ]);
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse"
                                                     data-parent="#accordion" href="#collapseOne1">
                                                    <h4 class="panel-title">Basic Details <i
                                                            class="fa fa-angle-up indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapseOne1" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <div class="radio-wrapper">

                                                            <div class="radio dl" id="IVA">
                                                                <dt>Skin Tone:</dt>
                                                                <dd>
                                                                    <?= $form->field($TempModel, 'vSkinTone')->RadioList(
                                                                        ArrayHelper::map(CommonHelper::getSkinTone(), 'ID', 'Name'),
                                                                        ['item' => function ($index, $label, $name, $checked, $value) {
                                                                            $checked = ($checked) ? 'checked' : '';
                                                                            $return = '<input type="radio" id="vSkinTone_' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                                            $return .= '<label for="vSkinTone_' . $value . '">' . ucwords($label) . '</label>';
                                                                            return $return;
                                                                        }
                                                                        ]

                                                                    )->label(false)->error(false); ?>
                                                                </dd>
                                                            </div>

                                                        </div>
                                                        <?php
                                                        $heightrange = range(134, 204);
                                                        $range = range(18, 100);
                                                        ?>
                                                        <div class="mid-col xs-col mrg-bt-20">
                                                            <div class="form-cont">
                                                                <label for="Height" class="hide"></label>
                                                                <?= $form->field($TempModel, 'AgeFrom')->dropDownList(
                                                                    array_combine($range, $range),
                                                                    ['class' => 'cs-select cs-skin-border',
                                                                        'prompt' => 'Minimum Age']
                                                                )->label(true)->error(false); ?>
                                                            </div>
                                                        </div>
                                                        <div class="mid-col xs-col mrg-lt-15 mrg-bt-20">
                                                            <div class="form-cont">
                                                                <label for="Height" class="hide"></label>
                                                                <?= $form->field($TempModel, 'AgeFrom')->dropDownList(
                                                                    array_combine($range, $range),
                                                                    ['class' => 'cs-select cs-skin-border',
                                                                        'prompt' => 'Maximum Age']
                                                                )->label(true)->error(false); ?>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>

                                                        <div class="mid-col xs-col mrg-bt-20">
                                                            <div class="form-cont">
                                                                <label for="Height" class="hide"></label>
                                                                <?= $form->field($TempModel, 'iHeightID')->dropDownList(
                                                                    ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
                                                                    ['class' => 'cs-select cs-skin-border',
                                                                        'id' => 'Height',
                                                                        'prompt' => 'Minimum Height']
                                                                )->label(true)->error(false); ?></div>
                                                        </div>
                                                        <div class="mid-col xs-col mrg-lt-15 mrg-bt-20">
                                                            <div class="form-cont">
                                                                <label for="Height" class="hide"></label>
                                                                <?= $form->field($TempModel, 'iHeightID')->dropDownList(
                                                                    ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
                                                                    ['class' => 'cs-select cs-skin-border',
                                                                        'id' => 'Height',
                                                                        'prompt' => 'Maximum Height']
                                                                )->label(true)->error(false); ?>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Marital Status</label>
                                                            <select class="multiselect select4 " name="select4"
                                                                    multiple>
                                                                <option value="8" class="option_eight"
                                                                        data-subtitle="Never Married">Never Married
                                                                </option>
                                                                <option value="9" class="option_nine">Nine</option>
                                                                <option value="10" class="option_ten" selected>Never
                                                                    Married
                                                                </option>
                                                                <option value="12" class="option_twelve">Twelve</option>
                                                                <option value="13" class="option_thirteen">Thirteen
                                                                </option>
                                                                <option value="14" class="option_fourteen">Fourteen
                                                                </option>
                                                            </select>
                                                            <input value="activate selectator" id="activate_selectator4"
                                                                   type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Religion</label>
                                                            <?= $form->field($TempModel, 'iReligion_ID')->dropDownList(
                                                                ArrayHelper::map(CommonHelper::getReligion(), 'iReligion_ID', 'vName'),
                                                                ['class' => ' cs-select cs-skin-border selectator',
                                                                    //'prompt' => 'Religion',
                                                                    //'class' => 'js-example-basic-multiple cs-select cs-skin-border',
                                                                    'multiple' => 'multiple',
                                                                ]

                                                            )->label(false)->error(false); ?>
                                                            <input value="activate selectator" id="activate_selectator4"
                                                                   type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Mother Tongue</label>
                                                            <select class="multiselect select4" name="select4" multiple>
                                                                <option value="8" class="option_eight"
                                                                        data-subtitle="Never Married">Never Married
                                                                </option>
                                                                <option value="9" class="option_nine">Nine</option>
                                                                <option value="10" class="option_ten" selected>Never
                                                                    Married
                                                                </option>
                                                                <option value="12" class="option_twelve">Twelve</option>
                                                                <option value="13" class="option_thirteen">Thirteen
                                                                </option>
                                                                <option value="14" class="option_fourteen">Fourteen
                                                                </option>
                                                            </select>
                                                            <input value="activate selectator" id="activate_selectator4"
                                                                   type="hidden">
                                                        </div>
                                                        <div class="multiselect-wrapper">
                                                            <label for="select4">Community</label>
                                                            <select class="multiselect select4" name="select4" multiple>
                                                                <option value="8" class="option_eight"
                                                                        data-subtitle="Never Married">Never Married
                                                                </option>
                                                                <option value="9" class="option_nine">Nine</option>
                                                                <option value="10" class="option_ten" selected>Never
                                                                    Married
                                                                </option>
                                                                <option value="12" class="option_twelve">Twelve</option>
                                                                <option value="13" class="option_thirteen">Thirteen
                                                                </option>
                                                                <option value="14" class="option_fourteen">Fourteen
                                                                </option>
                                                            </select>
                                                            <input value="activate selectator" id="activate_selectator4"
                                                                   type="hidden">
                                                        </div>
                                                        <div class="radio-wrapper mrg-bt-30">

                                                            <div class="radio dl" id="IVA">
                                                                <dd>
                                                                    <input id="cast" type="radio" checked="checked"
                                                                           name="cast" value="Very Fair">
                                                                    <label for="cast">Select from list</label>
                                                                    <input id="cast2" type="radio" name="cast2"
                                                                           value="Fair">
                                                                    <label for="fair">Only Members who selected Cast Not
                                                                        Bar</label>
                                                                    <a href="#" data-toggle="tooltip"
                                                                       data-placement="right"
                                                                       title="This is where the help text will appear when the mouse hovers over the help icon"> <?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?> </a>
                                                                </dd>
                                                            </div>

                                                        </div>
                                                        <div class="radio-wrapper manglik">

                                                            <div class="radio dl" id="IVA">
                                                                <dt class="xs-col mrg-bt-10">Mangalik/<br>
                                                                    Chewai Dosham:
                                                                </dt>
                                                                <dd>
                                                                    <input id="Does not matter" type="radio"
                                                                           checked="checked" name="manglik"
                                                                           value="Does not matter">
                                                                    <label for="Does not matter">Does not matter</label>
                                                                    <input id="Only Mangaliks" type="radio"
                                                                           name="manglik" value="Only Mangaliks">
                                                                    <label for="Only Mangaliks">Only Mangaliks</label>
                                                                    <input id="No Mangaliks" type="radio" name="manglik"
                                                                           value="No Mangaliks">
                                                                    <label for="No Mangaliks">No Mangaliks</label>
                                                                    <input id="Donot include my Gothra" type="radio"
                                                                           name="manglik"
                                                                           value="Donot include my Gothra">
                                                                    <label for="Does not matter2" class="mrg-bt-10">Does
                                                                        not matter</label>
                                                                    <input id="Does not matter2" type="radio"
                                                                           name="manglik" value="Does not matter2">
                                                                    <label for="Donot include my Gothra"
                                                                           class="mrg-bt-10">Donot include my
                                                                        Gothra</label>
                                                                </dd>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse"
                                                     data-parent="#accordion" href="#collapseTwo">
                                                    <h4 class="panel-title">Location and Place Grown Up At <i
                                                            class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p>Under Construction...</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse"
                                                     data-parent="#accordion" href="#collapseThree">
                                                    <h4 class="panel-title">Education &amp; Profession Details <i
                                                            class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapseThree" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p>Under Construction...</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse"
                                                     data-parent="#accordion" href="#collapsefour">
                                                    <h4 class="panel-title">Lifestyle &amp; Appearance Details <i
                                                            class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapsefour" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p>Under Construction...</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse"
                                                     data-parent="#accordion" href="#collapsefive">
                                                    <h4 class="panel-title">Search By Keywords <i
                                                            class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapsefive" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p>Under Construction...</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" data-toggle="collapse"
                                                     data-parent="#accordion" href="#collapsesix">
                                                    <h4 class="panel-title">General Details <i
                                                            class="fa fa-angle-down indicator pull-right"></i></h4>
                                                </div>
                                                <div id="collapsesix" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="checkbox-wrapper">
                                                            <div class="checkbox">
                                                                <dt class="xs-col">Photo Setting</dt>
                                                                <dd>
                                                                    <input id="Remember" type="checkbox" name="Remember"
                                                                           value="check1">
                                                                    <label for="Remember" class="control-label">Visible
                                                                        to All</label>
                                                                    <input id="Photo" type="checkbox" name="Photo"
                                                                           value="check1">
                                                                    <label for="Photo" class="control-label">Protected
                                                                        Photo</label>
                                                                    <a href="#" data-toggle="tooltip"
                                                                       data-placement="right"
                                                                       title="This is where the help text will appear when the mouse hovers over the help icon"> <?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                                                </dd>
                                                            </div>
                                                            <div class="checkbox">
                                                                <dt class="xs-col">Photo Created by</dt>
                                                                <dd>
                                                                    <input id="dm" type="checkbox" name="pic"
                                                                           value="check1">
                                                                    <label for="dm" class="control-label">Does'nt
                                                                        matter</label>
                                                                    <input id="self" type="checkbox" name="pic"
                                                                           value="check1">
                                                                    <label for="self" class="control-label">Self</label>
                                                                    <input id="Parent" type="checkbox" name="pic"
                                                                           value="check1">
                                                                    <label for="Parent" class="control-label">Parent/
                                                                        Guardian</label>
                                                                    <input id="Sibling" type="checkbox" name="pic"
                                                                           value="check1">
                                                                    <label for="Sibling" class="control-label">Sibling/
                                                                        Friend</label>
                                                                </dd>
                                                            </div>
                                                            <div class="radio-wrapper">

                                                                <div class="radio dl" id="IVA">
                                                                    <dt class="xs-col">Has Horoscope:</dt>
                                                                    <dd>
                                                                        <input id="matter1" type="radio"
                                                                               checked="checked" name="matter"
                                                                               value="Very Fair">
                                                                        <label for="matter1">Does'nt matter</label>
                                                                        <input id="matter2" type="radio" name="matter"
                                                                               value="Fair">
                                                                        <label for="matter2">No</label>
                                                                    </dd>
                                                                </div>

                                                            </div>
                                                            <div class="checkbox">
                                                                <dt class="xs-col">Donot Show</dt>
                                                                <dd>
                                                                    <input id="Remember" type="checkbox" name="Remember"
                                                                           value="check1">
                                                                    <label for="Remember" class="control-label">Profiles
                                                                        that have filtered me out</label>
                                                                    <input id="Photo" type="checkbox" name="Photo"
                                                                           value="check1">
                                                                    <label for="Photo" class="control-label">Profiles
                                                                        that have already
                                                                        viewed</label>
                                                                </dd>
                                                            </div>
                                                            <h3 class="heading-xs mrg-bt-20">Save upto 5 Searches</h3>

                                                            <div class="form-cont mid-col mrg-bt-20">
                              <span class="input input--akira">
                                <input class="input__field input__field--akira" type="text">
                                <label class="input__label input__label--akira" for="input-22"> <span
                                        class="input__label-content input__label-content--akira">Save Search as (e.g Mumbai, 20-22)</span>
                                </label>
                                </span></div>
                                                            <div class="mid-col mrg-tp-10">

                                                                <div class="form-cont">
                                                                    <label for="Community" class="hide"></label>
                                                                    <select id="Community"
                                                                            class="cs-select cs-skin-border">
                                                                        <option value="Community" disabled selected>
                                                                            Select Saved Search
                                                                        </option>
                                                                        <option value="option 1">option 1</option>
                                                                        <option value="option 2">option 2</option>
                                                                        <option value="option 3">option 3</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix mrg-bt-20"></div>
                                                            <div class="radio-wrapper">

                                                                <div class="radio dl" id="IVA">
                                                                    <dt class="xs-col">Email me New Results:</dt>
                                                                    <dd>
                                                                        <input id="Daily" type="radio" checked="checked"
                                                                               name="Email" value="Daily">
                                                                        <label for="Daily">Daily</label>
                                                                        <input id="Twice" type="radio" name="Email"
                                                                               value="Twice">
                                                                        <label for="Twice">Twice a week</label>
                                                                        <input id="Once" type="radio" name="Email"
                                                                               value="Once">
                                                                        <label for="Once">Once a week</label>
                                                                        <input id="Never" type="radio" name="Email"
                                                                               value="Never">
                                                                        <label for="Never">Never</label>
                                                                    </dd>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <ul class="list-inline filter-buttons">
                                        <li class="pull-right">
                                            <?= Html::submitButton('SAVE SEARCH', ['class' => 'btn btn-primary', 'name' => 'button']) ?>
                                        </li>
                                        <li class="pull-right">  <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?></li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <?php ActiveForm::end();
                                    $this->registerCssFile(Yii::$app->request->baseUrl . '/plugings/select2/select2.min.css');
                                    $this->registerJsFile(Yii::$app->request->baseUrl . '/plugings/select2/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
                                    $this->registerJs('
            $(".js-example-basic-multiple").select2({
            });
        '); ?>

                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab3">
                                    <p>Under Construction...</p>
                                </div>
                            </div>
                            <!--  <div class="bg-white padd-20 mrg-bt-20">

                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="mrg-bt-30"><a href="#" class="pull-right">See All</a>
                                              <h3 class="heading-xs">Matches near your city</h3></div>
                                      </div>
                                      <div class="col-sm-4">
                                          <ul class="list-unstyled ad-prof">
                                              <li> <span class="imgarea"><img alt="Profile" src="images/profile1.jpg"></span> <span class="img-desc">
                    <p class="name"><strong>Ishita J</strong></p>
                    <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                    </span>
                                                  <div class="clearfix"></div>
                                              </li>
                                          </ul>
                                      </div>
                                      <div class="col-sm-4">
                                          <ul class="list-unstyled ad-prof">
                                              <li> <span class="imgarea"><img alt="Profile" src="images/profile1.jpg"></span> <span class="img-desc">
                    <p class="name"><strong>Ishita J</strong></p>
                    <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                    </span>
                                                  <div class="clearfix"></div>
                                              </li>
                                          </ul>
                                      </div>
                                      <div class="col-sm-4">
                                          <ul class="list-unstyled ad-prof">
                                              <li> <span class="imgarea"><img alt="Profile" src="images/profile1.jpg"></span> <span class="img-desc">
                    <p class="name"><strong>Ishita J</strong></p>
                    <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                    </span>
                                                  <div class="clearfix"></div>
                                              </li>
                                          </ul>
                                      </div>

                                  </div>

                              </div>-->
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3 col-sm-12">
                     <div class="row">
                         <div class="map mrg-tp-30"><iframe width="100%" height="700" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.uk/maps?f=q&source=s_q&hl=en&geocode=&q=15+Springfield+Way,+Hythe,+CT21+5SH&aq=t&sll=52.8382,-2.327815&sspn=8.047465,13.666992&ie=UTF8&hq=&hnear=15+Springfield+Way,+Hythe+CT21+5SH,+United+Kingdom&t=m&z=14&ll=51.077429,1.121722&output=embed"></iframe> </div>
                     </div>
                 </div>-->
            </div>
        </div>

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

    .mid-col {
        max-width: 530px;
    }

    .form-horizontal .control-label {
        padding-top: 0px;
        margin-bottom: 20px;
    }

    .checkbox label {
        margin-bottom: 15px;
        color: #000;
    }

    .radio-wrapper .radio label {
        margin-bottom: 20px;
        color: #000;
    / / width : 100 %;
    }

    .radio-wrapper .radio dd {
        width: 50%;
    }

    .multiselect {
        width: 600px;
    }

    div.cs-skin-border {
        width: 600px;
    }

</style>