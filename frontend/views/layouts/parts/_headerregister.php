<?php
  use yii\helpers\Html;
?>
<header role="header">
  <!-- over-header -->
  <div class="over-header">
    <div class="header-inner">
      <div class="container">
        <div class="row">
          <div class="col-xs-4">
            <div class="logo"><a href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>" title="logo">
                <?= Html::img('@web/images/logo-inner.png', ['width' => '235', 'height' => 83, 'alt' => 'logo', 'title' => 'Kande Pohe']); ?> </a>
            </div>
          </div>
          <div class="col-xs-8">
            <div class="help pull-right">
              <ul class="list-inline">
                <?php if (!Yii::$app->user->isGuest) { ?>
                  <li><?= html::a('<i class="ti-power-off m-r-5"></i>Logout</a>', [Yii::$app->params['userLogout']], ['data-method' => 'post', 'class' => 'logout']) ?></li>
                  <?php if (Yii::$app->user->identity->eEmailVerifiedStatus == 'Yes' || Yii::$app->user->identity->ePhoneVerifiedStatus == 'Yes') { ?>
                  <?php } ?>
                <?php } else { ?>
                  <li>
                    <a href="<?= Yii::$app->getUrlManager()->getBaseUrl() . Yii::$app->params['PopUPLogin'] ?>"
                       title="Login" id="login_button">Login</a>
                  </li>
                  <li>
                    <a href="<?= Yii::$app->getUrlManager()->getBaseUrl() . Yii::$app->params['PopUPSignUp'] ?>"
                       title="Sign up Free" id="suf">Sign up Free</a>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>