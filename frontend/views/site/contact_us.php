<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact Us';
$this->params['breadcrumbs'][] = $this->title;
?>
<main>
    <div class="container-fluid">
        <div class="row no-gutter bg-dark">
            <div class="col-md-9 col-sm-12 col-md-offset-2">
                <div class="right-column">
                    <div class="row no-gutter">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="white-section mrg-tp-20 mrg-bt-10">
                                <h3><?= Html::encode($this->title) ?></h3>

                                <p>
                                    If you have business inquiries or other questions, please fill out the following
                                    form to contact us. Thank you.
                                </p>

                                <div class="box">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                                            <?= $form->field($model, 'name')->textInput() ?>
                                            <?= $form->field($model, 'email') ?>
                                            <?= $form->field($model, 'phone') ?>
                                            <?= $form->field($model, 'message')->textarea(['rows' => 6])->label('Message/Question') ?>
                                            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}<!--<br>Note: Click on captcha for refreash it.--></div></div>',
                                            ]) ?>
                                            <div class="form-group">
                                                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <aside>
                                <div class="aside-header text-center">
                                    <h3><strong>Address</strong></h3>
                                </div>

                                <div class="aside-content">
                                    <!--<div id="map"></div>-->
                                    <strong>
                                        Kande-Pohe Marathi Matrimony </strong><br>
                                    Sr. No 48/1, Opp. Anand Mangal Society, <br>
                                    Ganeshnagar, Vadgaonsheri, <br>
                                    Pune - 411014 <br>
                                    Email: help@kande-pohe.com <br>
                                    Contact Number: <br>

                                </div>
                                <div class="aside-footer  mrg-bt-10">

                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<style>
    #map {
        height: 100%;
    }
</style>
<?php
if ($STATUS != '') {
    $this->registerJs('
        notificationPopup("' . $STATUS . '", "' . $MESSAGE . '", "' . $TITLE . '");
    ');
}
$this->registerJs("

function initMap() {
    var myLatLng = {lat: -25.363, lng: 131.044};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: myLatLng
    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Hello World!'
    });
}

    ");
?>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChCF5DNujYmoPn2-gz_b9yZwrACzjq7mY&callback=initMap">
</script>