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
      <?php
      echo $this->render('/layouts/parts/_leftsidebarregister.php', ['CurrentStep' => $CurrentStep]);
      ?>
      <div class="col-sm-9">
        <div class="right-column"> <span class="welcome-note">
          <p><strong><?= $model->First_Name; ?> !</strong> One last thing… describe your self.</p>
          </span>
          <div class="row no-gutter">
            <div class="col-lg-8 col-md-12 col-sm-12">
              <div class="white-section mrg-tp-20 mrg-bt-10">
                <h3>About YourSelf</h3>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'form-register5',
                ]);
                ?>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><!--<span class="text-danger">*</span>--></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                        <span class="input input--akira input--filled input-textarea">
                          <textarea class="input__field input__field--akira" cols="50" rows="5" name="User[tYourSelf]" ><?= ($model->tYourSelf)?></textarea>
                          <label class="input__label input__label--akira" for="input-22">
                            <span class="input__label-content input__label-content--akira">Describe yourself in your own words</span> </label>
                        </span>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right"
                       title="Mention Your Describe yourself in your own words"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-10 col-sm-offset-1">
                    <label for="Remember" class="control-label">Any Disability :</label>
                  </div>
                </div>
                <div class="box">
                  <div class="small-col">
                    <div class="required1"><!--<span class="text-danger">*</span>--></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <div class="radio dl" id="IVA">
                        <dt></dt>
                        <dd>
                          <?= $form->field($model, 'vDisability')->RadioList(
                              ['None' => 'None', 'Physical Disability' => 'Physical Disability'],
                              [
                                  'item' => function ($index, $label, $name, $checked, $value) {
                                    $checked = ($checked) ? 'checked' : '';
                                    $return = '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                                    $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                                    return $return;
                                  },
                                  'onchange' => '
                            var vDisability = $("input[name=\'User[vDisability]\']:checked", "#form-register5").val();

                            if(vDisability == "Physical Disability"){
                              $("#nocDiv").show();
                            }
                            else {
                              $("#nocDiv").hide();
                              $("#user-vdisabilitydescription").val(" ");
                            }
                            '
                              ]
                          )->label(false); ?>
                        </dd>
                        <!--<dd>
                            <input id="None" type="radio" name="disability" value="None" <?/*= ($model->disability == 'None') ? 'checked="checked"' :''; */?>>
                            <label for="None">None</label>
                            <input id="Physical_Disability" type="radio" name="disability" value="Physical Disability" <?/*= ($model->disability == 'Physical Disability') ? 'checked="checked"' :''; */?>>
                            <label for="Physical_Disability">Physical Disability</label>
                          </dd>-->
                      </div>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right"
                       title="Mention Your Disability"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                  </div>
                </div>
                <?php
                //CommonHelper::pr($model->vDisability);exit;
                if ($model->vDisability == 'Physical Disability') {
                  $style = "display:block";
                } else {
                  $style = "display:none";
                }
                ?>
                <div class="box noc" id="nocDiv" style="<?= $style ?>">
                  <div class="small-col">
                    <div class="required1"><!--<span class="text-danger">*</span>--></div>
                  </div>
                  <div class="mid-col">
                    <div class="form-cont">
                      <?= $form->field($model, 'vDisabilityDescription', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Physical Disability</span> </label></span>{error}'])->input('text', ['class' => 'input__field input__field--akira form-control']) ?>
                    </div>
                  </div>
                  <div class="small-col tp ">
                    <a href="#" data-toggle="tooltip" data-placement="right"
                       title="Mention Your Disability"><?= Html::img('@web/images/tooltip.jpg', ['width' => '21', 'height' => 21, 'alt' => 'help']); ?></a>
                  </div>
                </div>
                <div class="row">
                  <div class="small-col">
                    <div class="required1"></div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-cont">
                      <div class="form-cont">
                        <?= Html::submitButton('create my profile', ['class' => 'btn btn-primary mrg-tp-10', 'name' => 'register5']) ?>
                      </div>
                    </div>
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
if ($ref == 'first') { ?>
  <div class="modal fade" id="first" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <p class="text-center mrg-bt-10">
        <img src="<?= \common\components\CommonHelper::getLogo() ?>" width="157" height="61" alt="logo">
      </p>


      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <h2 class="text-center"><?= Yii::$app->params['titleInformation'] ?></h2>
        </div>
        <div class="modal-body text-center">
          <div class="row">
            <?= Yii::$app->params['firstPhotoPagePopup'] ?>
          </div>
          <div class="row">
            <div class="col-md-12 ">
              <?= html::a('Continue ', ['user/dashboard'], ['class' => 'btn btn-primary mrg-tp-10']) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  $this->registerJs('
            $("#first").modal("toggle");

    ');
} ?>