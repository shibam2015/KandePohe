<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<?php
//echo $this->render('/layouts/parts/_headerregister.php');
?>
<div class="">
    <main>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mrg-tp-30">
                        <div class="dashboard-wrapper">
                            <div class="bg-white">
                                <div class="ad-title"><h1><?= Html::encode($this->title) ?></h1></div>
                                <div class="clearfix"></div>
                                <div class="fb-profile-text">
                                    <div class="alert alert-danger mrg-tp-10">
                                        <?= nl2br(Html::encode($message)) ?>
                                    </div>

                                    <p>
                                        The above error occurred while the Web server was processing your request.
                                    </p>

                                    <p>
                                        Please contact us if you think this is a server error. Thank you.
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                                <span class="pull-right"><a href="<?= Yii::$app->homeUrl ?>" class="text-right">Back To
                                        Home Page<i class="fa fa-angle-right"></i></a></span>

                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
