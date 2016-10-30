<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\components\MessageHelper;
use yii\helpers\Url;

?>

<div id="email_verification" class="mrg-tp-30 mrg-bt-10">
    <?php
    if (!$show) {
        $form = ActiveForm::begin([
            'id' => 'form',
            'action' => ['email-id-change'],
            'options' => ['data-pjax' => true],
            #'layout' => 'horizontal',
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
            <div class="col-sm-4 col-xs-4">
                <div class="form-cont">
                    <div class="form-cont">
                        <?= $form->field($model, 'email', ["template" => '<span class="input input--akira">{input}<label class="input__label input__label--akira" for="input-22"> <span class="input__label-content input__label-content--akira">Email</span> </label></span>{error}'])->input('email', ['class' => 'input__field input__field--akira form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-4">
                <input type="hidden" name="save" value="EMAIL_ID_CHANGE">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary email_submit', 'name' => 'save', 'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> Saving', 'value' => 'EMAIL_ID_CHANGE']) ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-primary', 'id' => 'cancel_change_email', 'name' => 'cancel',]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <?php
        if ($popup) {
            if ($flag) {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'CHANGE_EMAIL_ADDRESS');
                $this->registerJs('
                    $(".modal").on("hidden.bs.modal", function (e) {
                            getInlineDetail("' . Url::to(['user/email-verification']) . '","#email_verification","1");
                    })
                ');
            } else {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'CHANGE_EMAIL_ADDRESS');
            }
            $this->registerJs(' 
            notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
            $(".ew").hide();
            ');

        } else {
            if ($flag) {
                $this->registerJs('
                            getInlineDetail("' . Url::to(['user/email-verification']) . '","#email_verification","1");
                            $(".ew").hide();
                ');
            }
        }
    }
    $this->registerJs('
        setDesign();
          (function() { 
                    $(".email_submit").click(function(){
                       $(".ew").show();                
                    });
                 
          
          })();
        $(".email_submit").on("click", function() {
        var $this = $(this);
        $this.button("loading");
        setTimeout(function() {
            $this.button("reset");
        }, 8000);
    });
 ');

    ?>
</div>
