<?php
  use yii\helpers\Html;
?>
<header role="header">
  <!-- over-header -->
  <div class="over-header">
    <div class="header-inner">
      <div class="container">
        <div class="row">
          <div class="col-xs-8">
            <div class="logo"><a href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>" title="logo">
                <!-- <img src="images/logo-inner.png" width="202" height="83" alt="logo" title="Kande Pohe"> --><?= Html::img('@web/images/logo-inner.png', ['width' => '202', 'height' => 83, 'alt' => 'logo']); ?> </a>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="help pull-right"> <a href="#" title="Help"> <!-- <img src="images/help.png" width="21" height="21" alt="help" title="Help"> --><?= Html::img('@web/images/help.png', ['width' => '21','height' => 21,'alt' => 'help']); ?> </a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>