<?php
use yii\helpers\Html;
use common\components\CommonHelper;
?>
<header role="header">
  <!-- over-header -->
  <div class="over-header">
    <div class="header-inner">
      <div class="container">
        <div class="row">
          <div class="col-xs-4">
            <div class="logo">
              <a href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/user/dashboard" title="logo">
                <?= Html::img('@web/images/logo-inner.png', ['width' => '202', 'height' => 83, 'alt' => 'logo']); ?>
              </a>
            </div>
          </div>
          <div class="col-xs-8">
            <div class="primary-menu">
              <div class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                  <div class="navbar-collapse collapse sidebar-navbar-collapse">
                    <ul class="nav navbar-nav">
                      <?php #if (Yii::$app->user->identity->eEmailVerifiedStatus == 'Yes' && Yii::$app->user->identity->ePhoneVerifiedStatus == 'Yes') {
                      if (1) { ?>
                    <!-- <li><a href="#">Matches <span class="badge">1</span></a></li>-->
                      <!--<li><a href="<? /*= CommonHelper::getMailBoxUrl() */ ?>">Search </a></li>-->
                      <li><?= html::a('<i class="ti-power-off m-r-5"></i> Search</a>', ['search/basic-search'], ['data-method' => 'post']) ?></li>
                      <li><a href="<?= CommonHelper::getMailBoxUrl() ?>">Inbox
                          <!--<span class="badge">10</span>--></a></li>
                      <!--<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Upgrade <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#">Upgrade 1</a></li>
                          <li><a href="#">Upgrade 2</a></li>
                          <li><a href="#">Upgrade 3</a></li>
                          <li><a href="#">Upgrade 4</a></li>
                        </ul>
                      </li>-->
                      <li class="dropdown last"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                          <?= Html::img(CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, "30" . Yii::$app->user->identity->propic, 30, '', 'Yes'), ['width' => '30', 'height' => '30', 'alt' => 'Profile Photo', 'class' => 'profile_photo_one']); ?>
                          <?= Yii::$app->user->identity->First_Name; ?>
                          <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><?= html::a('<i class="ti-power-off m-r-5"></i> My Profile</a>', ['user/my-profile'], ['data-method' => 'post']) ?></li>
                          <li><?= html::a('<i class="ti-power-off m-r-5"></i> Dashboard</a>', ['user/dashboard'], ['data-method' => 'post']) ?></li>
                          <li><?= html::a('<i class="ti-power-off m-r-5"></i> Logout</a>', ['site/logout'], ['data-method' => 'post', 'class' => 'logout']) ?></li>
                          <li><?= html::a('<i class="ti-power-off m-r-5"></i> Setting</a>', ['user/setting']) ?></li>
                          <li role="separator" class="divider"></li>
                          <li class="dropdown-header">Help</li>
                          <li><a href="#">Report a Problem</a></li>
                        </ul>
                      </li>
                      <?php } else { ?>
                        <!--<li><? /*= html::a('<i class="ti-power-off m-r-5"></i> Logout</a>', Yii::$app->homeUrl . 'site/logout', ['data-method' => 'post']) */
                        ?></li>-->
                      <?php } ?>
                    </ul>
                  </div>
                  <!--/.nav-collapse -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>