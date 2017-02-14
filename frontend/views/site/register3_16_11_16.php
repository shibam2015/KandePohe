<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;

echo $this->render('/layouts/parts/_headerregister.php');
?>
    <main>
        <div class="container-fluid">
            <div class="row no-gutter bg-dark">
                <div class="col-md-3 col-sm-12">
                    <div class="sidebar-nav">
                        <div class="navbar navbar-default" role="navigation">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse"
                                        data-target=".sidebar-navbar-collapse"><span
                                        class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                                        class="icon-bar"></span> <span class="icon-bar"></span></button>
                                <span class="visible-xs navbar-brand">Sidebar menu</span></div>
                            <div class="navbar-collapse collapse sidebar-navbar-collapse">
                                <ul class="nav navbar-nav">
                                    <li class="step_done"><a href="<?= $HOME_URL_SITE ?>basic-details">Basic Details</a>
                                    </li>
                                    <li class="step_done"><a href="<?= $HOME_URL_SITE ?>education-occupation">Education
                                            &amp; Occupation</a></li>
                                    <li class="active"><a href="javascript::void()">Lifestyle &amp; Appearance</a></li>
                                    <li><a href="javascript::void()">Family</a></li>
                                    <li><a href="javascript::void()">About Yourself</a></li>
                                </ul>
                            </div>
                            <!--/.nav-collapse -->
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="right-column"> <span class="welcome-note">
          <p><strong>Welcome <?= $model->First_Name; ?> !</strong> Your lifestyle details will help us find you the best
              matches</p>
          </span>

                        <div class="row no-gutter">
                            <div class="col-lg-8 col-md-12 col-sm-12">
                                <div class="white-section mrg-tp-20 mrg-bt-10">
                                    <h3>Lifestyle &amp; Appearance</h3>
                                    <!--<span class="error">Oops! Please ensure all fields are valid</span>
                                    <p><span class="text-danger">*</span> marked fields are mandatory</p>-->
                                    <p><span class="text-danger">*</span> marked fields are mandatory</p>
                                    <?php
                                    $form = ActiveForm::begin([
                                        'id' => 'form-register3',
                                        'validateOnChange' => false,
                                    ]);
                                    ?>
                                    <?= $form->errorSummary($model, ['header' => '<p>Oops! Please ensure all fields are valid</p>']); ?>
                                    <div class="box">
                                        <div class="small-col">
                                            <div class="required1"><span class="text-danger">*</span></div>
                                        </div>
                                        <div class="mid-col">
                                            <div class="form-cont">
                                                <?= $form->field($model, 'iHeightID')->dropDownList(
                                                    ArrayHelper::map(CommonHelper::getHeight(), 'iHeightID', 'vName'),
                                                    ['class' => 'cs-select cs-skin-border',
                                                        'prompt' => 'Height'
                                                    ]
                                                )->label(false)->error(false); ?>
                                            </div>
                                        </div>
                                        <div class="small-col tp ">
                                            <a href="#" data-toggle="tooltip" data-placement="right"
                                               title="Mention Your Height"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                        </div>
                                    </div>

                                    <div class="box">
                                        <div class="small-col">
                                            <div class="required1 mrg-tp-0"><span class="text-danger">*</span></div>
                                        </div>
                                        <div class="mid-col">
                                            <div class="form-cont">
                                                <div class="radio dl" id="IVA">
                                                    <dt>Skin Tone:</dt>
                                                    <dd>
                                                        <?= $form->field($model, 'vSkinTone')->RadioList(
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
                                        </div>
                                        <div class="small-col tp ">
                                            <a href="#" data-toggle="tooltip" data-placement="right"
                                               title="Mention Your Skin"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div class="small-col">
                                            <div class="required1 mrg-tp-0"><span class="text-danger">*</span></div>
                                        </div>
                                        <div class="mid-col">
                                            <div class="form-cont">
                                                <div class="radio dl" id="IVA">
                                                    <dt>Body Type:</dt>
                                                    <dd>

                                                        <?= $form->field($model, 'vBodyType')->RadioList(
                                                            ArrayHelper::map(CommonHelper::getBodyType(), 'ID', 'Name'),
                                                            ['item' => function ($index, $label, $name, $checked, $value) {
                                                                $checked = ($checked) ? 'checked' : '';
                                                                $return = '<input type="radio" id="vBodyType_' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                                $return .= '<label for="vBodyType_' . $value . '">' . ucwords($label) . '</label>';
                                                                return $return;
                                                            }
                                                            ]

                                                        )->label(false)->error(false); ?>
                                                    </dd>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="small-col tp ">
                                            <a href="#" data-toggle="tooltip" data-placement="right"
                                               title="Mention Your Body Type"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div class="small-col">
                                            <div class="required1 mrg-tp-0"><span class="text-danger">*</span></div>
                                        </div>
                                        <div class="mid-col">
                                            <div class="form-cont">
                                                <div class="radio dl" id="IVA">
                                                    <dt>Smoke:</dt>
                                                    <dd>
                                                        <?= $form->field($model, 'vSmoke')->RadioList(
                                                            ['Smoke_Yes' => 'Yes', 'Smoke_No' => 'No', 'Smoke_Occasionally' => 'Occasionally'],
                                                            [
                                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                                    $checked = ($checked) ? 'checked' : '';
                                                                    $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                                    $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                                                                    return $return;
                                                                }

                                                            ]
                                                        )->label(false)->error(false); ?>
                                                    </dd>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="small-col tp ">
                                            <a href="#" data-toggle="tooltip" data-placement="right"
                                               title="Mention Your Smoke Habit"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div class="small-col">
                                            <div class="required1 mrg-tp-0"><span class="text-danger">*</span></div>
                                        </div>
                                        <div class="mid-col">
                                            <div class="form-cont">
                                                <div class="radio dl" id="IVA">
                                                    <dt>Drink:</dt>
                                                    <dd>
                                                        <?= $form->field($model, 'vDrink')->RadioList(
                                                            ['Drink_Yes' => 'Yes', 'Drink_No' => 'No', 'Drink_Occasionally' => 'Occasionally'],
                                                            [
                                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                                    $checked = ($checked) ? 'checked' : '';
                                                                    $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                                    $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                                                                    return $return;
                                                                }

                                                            ]
                                                        )->label(false)->error(false); ?>
                                                    </dd>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="small-col tp ">
                                            <a href="#" data-toggle="tooltip" data-placement="right"
                                               title="Mention Your Drink Habit"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div class="small-col">
                                            <div class="required1 mrg-tp-0">
                                                <!--<span class="text-danger">*</span>--></div>
                                        </div>
                                        <div class="mid-col">
                                            <div class="form-cont">
                                                <div class="radio dl" id="IVA">
                                                    <dt>Spectacles/ Lens:</dt>
                                                    <dd>
                                                        <?= $form->field($model, 'vSpectaclesLens')->RadioList(
                                                            ['SpectaclesLens_Spectacles' => 'Spectacles', 'SpectaclesLens_Lens' => 'Lens'],
                                                            [
                                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                                    $checked = ($checked) ? 'checked' : '';
                                                                    $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                                                    $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                                                                    return $return;
                                                                }

                                                            ]
                                                        )->label(false)->error(false); ?>
                                                    </dd>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="small-col tp ">
                                            <a href="#" data-toggle="tooltip" data-placement="right"
                                               title="Mention Your Spectacles/ Lens"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div class="small-col">
                                            <div class="required1"><span class="text-danger">*</span></div>
                                        </div>
                                        <div class="mid-col">
                                            <div class="form-cont">
                                                <label for="Diet" class="hide"></label>
                                                <?= $form->field($model, 'vDiet')->dropDownList(
                                                    ArrayHelper::map(CommonHelper::getDiet(), 'iDietID', 'vName'),
                                                    ['class' => 'cs-select cs-skin-border',
                                                        'prompt' => 'Diet'
                                                    ]

                                                )->label(false)->error(false); ?>
                                            </div>
                                        </div>
                                        <div class="small-col tp ">
                                            <a href="#" data-toggle="tooltip" data-placement="right"
                                               title="Mention Your Diet"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <?= Html::submitButton('CONTINUE', ['class' => 'btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-left', 'name' => 'register2']) ?>
                                            <a href="<?= $HOME_URL_SITE ?>about-family"
                                               class="btn btn-primary mrg-tp-10 col-xs-5 col-xs-5 pull-right">Skip</a>
                                        </div>
                                    </div>

                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                            <?php
                            echo $this->render('/layouts/parts/_rightbarregister.php');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
$this->registerJs('
    $("#form-register3").on("submit",function(e){
      var iheightid = $("#user-iheightid").val();
      var vdiet = $("#user-vdiet").val();
      var vSkinTone = $(\'input:radio[name="User[vSkinTone]"]:checked\').val()
      var vBodyType = $(\'input:radio[name="User[vBodyType]"]:checked\').val()
      var vSmoke = $(\'input:radio[name="User[vSmoke]"]:checked\').val()
      var vDrink = $(\'input:radio[name="User[vDrink]"]:checked\').val()
      

      $(".error-field").removeClass("error-field");
      $("#top-error").hide();
      var error_flag = true;
      if(iheightid == ""){
        $("#user-iheightid").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }
      if(vdiet == ""){
        $("#user-vdiet").parent().children(".nice-select").addClass("error-field");
        error_flag = false;
      }

      if(vSkinTone == "" || typeof vSkinTone === "undefined"){
        $(\'input:radio[name="User[vSkinTone]"]\').closest(".mid-col").addClass("error-field");
        error_flag = false;
      }

      if(vBodyType == "" || typeof vBodyType === "undefined"){
        $(\'input:radio[name="User[vBodyType]"]\').closest(".mid-col").addClass("error-field");
        error_flag = false;
      }

      if(vSmoke == "" || typeof vSmoke === "undefined"){
        $(\'input:radio[name="User[vSmoke]"]\').closest(".mid-col").addClass("error-field");
        error_flag = false;
      }
      
      if(vDrink == "" || typeof vDrink === "undefined"){
        $(\'input:radio[name="User[vDrink]"]\').closest(".mid-col").addClass("error-field");
        error_flag = false;
      }
      

      if(!error_flag){
        // $("#top-error").show();
        return false;
      }
    });
  ');
?>