  <?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\components\CommonHelper;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
use yii\captcha\Captcha;

/*$religion_data = CommonHelper::getReligion();
$community_data = CommonHelper::getCommunity();*/

// var_dump($id = Yii::$app->user->identity->id);
$id = 0;
if (!Yii::$app->user->isGuest) {
#$id = base64_decode($id);
    $id = Yii::$app->user->identity->id;
}

$HOME_URL = Yii::getAlias('@web')."/";
$HOME_URL_SITE = Yii::getAlias('@web')."/site/";
$UPLOAD_DIR = Yii::getAlias('@frontend') .'/web/uploads/';
$IMG_DIR = Yii::getAlias('@frontend') .'/web/';

#$PROFILE_COMPLETENESS = $model-
?>

<link rel="stylesheet" type="text/css" href="<?=$HOME_URL?>css/radical-progress.css" />
<!-- Custom styles for this template -->
<!-- <link rel="stylesheet" type="text/css" href="css/cs-select.css" />
<link rel="stylesheet" type="text/css" href="css/radical-progress.css" />
<link rel="stylesheet" type="text/css" href="css/cs-skin-border.css" />
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet"> -->
<!--<div class="wrapper">-->
<div class="">
  <?= $this->render('/layouts/parts/_headerafterlogin');?> 
  <main>
    <section>
      <div class="container">
        <div class="row">
          <div class="col-sm-4 col-md-3">
            <div class="bg-white">
              <div class="radical-progress-wrapper">
                <div class="panel-body">
                  <div class="profile-header-container">
                    <div class="profile-header-img">
                      <img class="img-circle" src="<?=($model->propic!='') ? $model->propic : $HOME_PAGE_URL.'images/placeholder.jpg';?>" />

                      <!-- badge -->
                      <div class="rank-label-container img-circle">
                        <div class="dropdown">
                          <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i class="fa fa-pencil"></i> </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="#">Choose from My Photos</a></li>
                            <li><a href="#">Upload Photo</a></li>
                            <li><a href="#">Reposition</a></li>
                            <li><a href="#">Delete Photo</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ad-title" style="margin-bottom:0">My Dashboard</div>
                </div>
              </div>
              <div class="divider no-mrg"></div>
              <div class="panel no-border panel-default panel-friends">
                <div class="panel-heading">
                  <h3 class="heading-xs"> My Profile</h3>
                </div>
                <div class="panel-body">
                  <ul class="reset mrg-lt-15 list-item">
                    <li> <a href="<?=$HOME_URL_SITE?>basic-details" title="Edit Profile">Edit Profile</a> </li>
                    <li><a href="#" title="Manage Photos">Manage Photos</a> </li>
                    <li><a href="#" title="Edit Preference"> Edit Preference</a></li>
                    <li><a href="#" title="Privacy Options"> Privacy Options </a> </li>
                  </ul>
                </div>
              </div>
              <div class="divider no-mrg"></div>
              <div class="panel no-border padd-hr-10 panel-default panel-friends">
                <div class="panel-heading">
                  <h3 class="panel-title text-muted">Unblock Trust Badges
                    <!--<img src="images/follower-member.png">-->
                    <?= Html::img('@web/images/follower-member.png', ['width' => '','height' => '','alt' => '']); ?>
                  </h3>
                </div>
                <div class="panel-body no-padd text-center">
                  <div class="profile-edit">
                    <ul class="list-inline minor-control">
                      <li><a href="#"><i class="fa fa-facebook"></i> <span class="badge"><i class="fa fa-check"></i></span></a></li>
                      <li><a href="#"><i class="fa fa-mobile"></i> <span class="badge"><i class="fa fa-check"></i></span></a></li>
                      <li><a href="#"><i class="fa fa-envelope-o"></i> <span class="badge"><i class="fa fa-check"></i></span></a></li>
                      <li><a href="#"><i class="fa fa-user"></i> <span class="badge"><i class="fa fa-check"></i></span></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="divider no-mrg"></div>
              <div class="panel no-border panel-default panel-friends">
                <div class="panel-heading">
                  <h3 class="panel-title text-muted">Messages</h3>
                </div>
                <div class="panel-body">
                  <ul class="reset list-item">
                    <li> <a href="#" title="Inbox">Inbox</a> <span class="badge">10</span> </li>
                    <li><a href="#" title="Accepted">Accepted Interest</a> <span class="badge">2</span> </li>
                    <li><a href="#" title="Not Replied"> Not Replied </a> <span class="badge">1</span></li>
                    <li><a href="#" title="Sent"> Sent </a> <span class="badge">1</span></li>
                  </ul>
                </div>
              </div>
              <div class="divider no-mrg"></div>
              <div class="panel no-border padd-hr-10 panel-default panel-friends">
                <div class="panel-heading">
                  <h3 class="panel-title text-muted">My Preferences</h3>
                </div>
                <div class="refe-accord">
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOnes" aria-expanded="true" aria-controls="collapseOnes"> Location <span class="blue">(669)</span> <span class="badge">10</span> <i class="fa indicator fa-angle-up"></i> </a> </h4>
                      </div>
                      <div id="collapseOnes" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          <ul class="list-unstyled ad-prof">
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT">
                                  <!--<img src="images/profile1.jpg" alt="Profile">-->
                                  <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?>
                                </a></span> <span class="img-desc">
                                <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT">
                                  <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?>
                                </a></span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Profession <span class="blue">(669)</span> <span class="badge">10</span> <i class="fa indicator fa-angle-down"></i> </a> </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                          <ul class="list-unstyled ad-prof">
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT"> <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></a></span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT"> <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></a></span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Education <span class="blue">(669)</span> <span class="badge">10</span> <i class="fa indicator fa-angle-down"></i> </a> </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                          <ul class="list-unstyled ad-prof">
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT"> <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></a></span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT"> <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></a></span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingfour">
                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour"> Compatible Stars <span class="blue">(669)</span> <span class="badge">10</span> <i class="fa indicator fa-angle-down"></i> </a> </h4>
                      </div>
                      <div id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">
                        <div class="panel-body">
                          <ul class="list-unstyled ad-prof">
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT"> <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></a></span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT"> <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></a></span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingfive">
                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefive" aria-expanded="false" aria-controls="collapsefive"> Family values <span class="blue">(669)</span> <span class="badge">10</span> <i class="fa fa-angle-down"></i> </a> </h4>
                      </div>
                      <div id="collapsefive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfive">
                        <div class="panel-body">
                          <ul class="list-unstyled ad-prof">
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT"> <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></a></span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                            <li> <span class="imgarea"><a href="#" class="name" title="KP123WERT"> <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></a></span> <span class="img-desc"> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                              <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                              </span>
                              <div class="clearfix"></div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-8 col-md-6">
            <div class="dashboard-wrapper">
              <!-- profile status -->
              <div class="bg-white">
                <div class="radial-progress pull-right" data-progress="0">
                  <div class="circle">
                    <div class="mask full">
                      <div class="fill"></div>
                    </div>
                    <div class="mask half">
                      <div class="fill"></div>
                      <div class="fill fix"></div>
                    </div>
                    <div class="shadow"></div>
                  </div>
                  <div class="inset">
                    <div class="percentage">
                      <div class="numbers">
                        <span>-</span>
                        <span>0% Complete</span>
                        <?php for($i=1;$i<=100; $i++){?>
                          <span><?=$i?>% Complete</span>
                      <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="fb-profile-text">
                  <h1 class="user-name"><?= $model->First_Name.' '.$model->Last_Name; ?><span class="sub-text">(<?= ($model->Registration_Number !='') ? $model->Registration_Number : '-'; ?>)</span></h1>
                  <h5 class="user-line mrg-tp-20">Add more details to get better visibility</h5>
                  <div class="ad-title mrg-tp-10"><a href="<?=$HOME_URL_SITE?>basic-details">Complete your Profile Now!</a></div>
                </div>
                <div class="clearfix"></div>
              </div>
              <!-- view by -->
              <div class="bg-white mrg-tp-20"> <a href="#" title="View All" class="pull-right">View All &gt;</a>
                <h3 class="heading-xs">Your Profile Viewed By</h3>
                <div class="user-list">
                  <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-3">
                      <div class="item"> <a href="#" class="name-img" title="KP123WERT"><?= Html::img('@web/images/user.jpg', ['width' => '','height' => '','alt' => 'user','class'=>'']); ?> </a> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                        <p>27yrs , 5’5”</p>
                        <p> <a href="#" class="btn btn-info" role="button">Send Interest <i class="fa fa-heart-o"></i></a></p>
                      </div>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-3">
                      <div class="item"> <a href="#" class="name-img" title="KP123WERT"><?= Html::img('@web/images/user.jpg', ['width' => '','height' => '','alt' => 'user','class'=>'']); ?> </a> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                        <p>27yrs , 5’5”</p>
                        <p> <a href="#" class="btn btn-info" role="button">Send Interest <i class="fa fa-heart-o"></i></a></p>
                      </div>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-3">
                      <div class="item"> <a href="#" class="name-img" title="KP123WERT"><?= Html::img('@web/images/user.jpg', ['width' => '','height' => '','alt' => 'user','class'=>'']); ?> </a> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                        <p>27yrs , 5’5”</p>
                        <p> <a href="#" class="btn btn-link" role="button">Interest Send <i class="fa fa-heart"></i></a></p>
                      </div>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-3">
                      <div class="item"> <a href="#" class="name-img" title="KP123WERT"><?= Html::img('@web/images/user.jpg', ['width' => '','height' => '','alt' => 'user','class'=>'']); ?> </a> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                        <p>27yrs , 5’5”</p>
                        <p> <a href="#" class="btn btn-info" role="button">Send Interest <i class="fa fa-heart-o"></i></a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- recent member -->
              <div class="bg-white mrg-tp-20"> <a href="#" title="View All" class="pull-right">View All &gt;</a>
                <h3 class="heading-xs">Recently Joined Members</h3>
                <div class="user-list">
                  <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-3">
                      <div class="item"> <a href="#" class="name-img" title="KP123WERT"><?= Html::img('@web/images/user.jpg', ['width' => '','height' => '','alt' => 'user','class'=>'']); ?> </a> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                        <p>27yrs , 5’5”</p>
                        <p> <a href="#" class="btn btn-info" role="button">Send Interest <i class="fa fa-heart-o"></i></a></p>
                      </div>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-3">
                      <div class="item"> <a href="#" class="name-img" title="KP123WERT"><?= Html::img('@web/images/user.jpg', ['width' => '','height' => '','alt' => 'user','class'=>'']); ?> </a> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                        <p>27yrs , 5’5”</p>
                        <p> <a href="#" class="btn btn-info" role="button">Send Interest <i class="fa fa-heart-o"></i></a></p>
                      </div>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-3">
                      <div class="item"> <a href="#" class="name-img" title="KP123WERT"><?= Html::img('@web/images/no-user-img.jpg', ['width' => '','height' => '','alt' => 'user','class'=>'']); ?></a> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                        <p>27yrs , 5’5”</p>
                        <p> <a href="#" class="btn btn-link" role="button">Interest Send <i class="fa fa-heart"></i></a></p>
                      </div>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-3">
                      <div class="item"> <a href="#" class="name-img" title="KP123WERT"><?= Html::img('@web/images/user.jpg', ['width' => '','height' => '','alt' => 'user','class'=>'']); ?> </a> <a href="#" class="name" title="KP123WERT">KP123WERT</a>
                        <p>27yrs , 5’5”</p>
                        <p> <a href="#" class="btn btn-info" role="button">Send Interest <i class="fa fa-heart-o"></i></a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Short list block -->
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                  <div class="bg-white mrg-tp-20">
                    <h3 class="heading-xs">Your Profile Shortlisted By</h3>
                    <ul class="list-unstyled ad-prof mrg-tp-20">
                      <li> <span class="imgarea"><?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile','class'=>'']); ?></span> <span class="img-desc"> <a title="KP123WERT" class="name" href="#">KP123WERT</a>
                        <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                        </span>
                        <div class="clearfix"></div>
                      </li>
                      <li> <span class="imgarea"><?= Html::img('@web/images/profile2.jpg', ['width' => '','height' => '','alt' => 'Profile','class'=>'']); ?></span> <span class="img-desc"> <a title="KP123WERT" class="name" href="#">KP123WERT</a>
                        <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                        </span>
                        <div class="clearfix"></div>
                      </li>
                      <li> <span class="imgarea"><?= Html::img('@web/images/profile3.jpg', ['width' => '','height' => '','alt' => 'Profile','class'=>'']); ?></span> <span class="img-desc"> <a title="KP123WERT" class="name" href="#">KP123WERT</a>
                        <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                        </span>
                        <div class="clearfix"></div>
                      </li>
                    </ul>
                    <div class="text-right"> <a title="View All" href="#">View All &gt;</a></div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                  <div class="bg-white mrg-tp-20">
                    <h3 class="heading-xs">Your Phone No. Viewed By</h3>
                    <ul class="list-unstyled ad-prof mrg-tp-20">
                      <li> <span class="imgarea"><?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile','class'=>'']); ?></span> <span class="img-desc"> <a title="KP123WERT" class="name" href="#">KP123WERT</a>
                        <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                        </span>
                        <div class="clearfix"></div>
                      </li>
                      <li> <span class="imgarea"><?= Html::img('@web/images/profile2.jpg', ['width' => '','height' => '','alt' => 'Profile','class'=>'']); ?></span> <span class="img-desc"> <a title="KP123WERT" class="name" href="#">KP123WERT</a>
                        <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                        </span>
                        <div class="clearfix"></div>
                      </li>
                      <li> <span class="imgarea"><?= Html::img('@web/images/profile3.jpg', ['width' => '','height' => '','alt' => 'Profile','class'=>'']); ?></span> <span class="img-desc"> <a title="KP123WERT" class="name" href="#">KP123WERT</a>
                        <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                        </span>
                        <div class="clearfix"></div>
                      </li>
                    </ul>
                    <div class="text-right"> <a title="View All" href="#">View All &gt;</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-3">
            <div class="bg-white padd-20">
              <div class="ad-title">Similar Profiles</div>
              <ul class="list-unstyled ad-prof">
                <li> <span class="imgarea"> <?= Html::img('@web/images/profile1.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></span> <span class="img-desc">
                  <p class="name"><strong>Ishita J</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>
                  <div class="clearfix"></div>
                </li>
                <li> <span class="imgarea"> <?= Html::img('@web/images/profile2.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></span> <span class="img-desc">
                  <p class="name"><strong>Arathi B</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>
                  <div class="clearfix"></div>
                </li>
                <li> <span class="imgarea"> <?= Html::img('@web/images/profile3.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?></span> <span class="img-desc">
                  <p class="name"><strong>Arathi B</strong></p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>
                  <div class="clearfix"></div>
                </li>
              </ul>
              <span class="pull-right"><a href="#" class="text-right">See All <i class="fa fa-angle-right"></i></a></span>
              <div class="clearfix"></div>
              <div class="border"></div>
              <div class="ad-title">Success Stories</div>
              <div class="mrg-bt-10">

                <?= Html::img('@web/images/image1.jpg', ['width' => '','height' => '','alt' => 'Image','class'=>'img-responsive']); ?>
              </div>
              <span class="pull-right"><a href="#" class="text-right">Read All Stories <i class="fa fa-angle-right"></i></a></span>
              <div class="clearfix"></div>
              <div class="border"></div>
              <div class="ad-title">Interest Accepted</div>
              <ul class="list-unstyled ad-prof">
                <li> <span class="imgarea">
                    <?= Html::img('@web/images/profile4.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?>
                  </span> <span class="img-desc">
                  <p class="name">Mrunmal Sawant</p>
                  <p>27, 5'5", Hindu, Brahmin, Finance Manager, Indore, India</p>
                  </span>
                  <div class="clearfix"></div>
                </li>
                <li> <span class="imgarea">
                    <?= Html::img('@web/images/heart.jpg', ['width' => '','height' => '','alt' => 'Profile']); ?>
                    </span> <span class="img-desc">
                  <td width="87%" align="left" valign="top"><p><strong>Mrunmal Sawant</strong></p>
                    <p>has accepted your interest and would like to hear from you.</p></td>
                  </span>
                  <div class="clearfix"></div>
                </li>
              </ul>
              </table>
              <span class="pull-right"><a href="#" class="text-right">Get in touch with her <i class="fa fa-angle-right"></i></a></span>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
<!--  <footer>
    <div class="legal">
      <p>© 2016 Kande Pohe.com. All Rights Reserved.</p>
    </div>
  </footer>-->
</div>
<div class="chatwe">
  <div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne" id="chatbox"><i class="fa fa-comment"></i> Members Online</div>
    <div class="panel-collapse collapse" id="collapseOne">
      <div class="panel-body">
        <ul class="list-unstyled ad-prof">
          <li> <span class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
          <li class="active"> <span class="imgarea"><?= Html::img('@web/images/profile2.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="online"></span> </li>
          <li> <span class="imgarea"><?= Html::img('@web/images/profile3.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
          <li> <span class="imgarea"><?= Html::img('@web/images/profile1.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
          <li> <span class="imgarea"><?= Html::img('@web/images/profile2.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
          <li> <span class="imgarea"><?= Html::img('@web/images/profile3.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
          <li> <span class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
          <li> <span class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
          <li> <span class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
          <li> <span class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
          <li> <span class="imgarea"><?= Html::img('@web/images/profile4.jpg', ['width' => '40','height' => '40','alt' => 'Profile']); ?></span> <span class="img-desc">
            <p class="name">Ishita J </p>
            </span> <span class="time">12:24</span> </li>
        </ul>
      </div>
      <div class="panel-footer">
        <div class="input-group"> <span class="input-group-btn">
          <button class="btn btn-default btn-sm" id="btn-chat"><span class="glyphicon glyphicon-search"></span></button>
          </span>
          <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
          <span class="input-group-btn dropup">
          <button class="btn btn-default btn-sm" id="btn-chat"><i class="fa fa-pencil-square-o"></i></button>
          <button class="btn btn-default btn-sm" id="btn-chat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i> </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
          </ul>
          </span> </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Photo -->
<div class="modal fade" id="photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <p class="text-center mrg-bt-10"><img src="images/logo.png" width="157" height="61" alt="logo" ></p>
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span> </button>
        <h2 class="text-center">My Photo Gallery</h2>
        <div class="profile-control photo-btn">
          <button class="btn active" type="button"> Upload Video or Photo </button>
          <button class="btn " type="button"> Choose from Photos </button>
          <button class="btn" type="button"> Albums </button>
        </div>
      </div>
      <!-- Modal Body -->
      <div class="modal-body photo-gallery">
        <div class="choose-photo">
          <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#" class="selected"><?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class'=>'img-responsive']); ?></a> </div>
            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class'=>'img-responsive']); ?></a> </div>
            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class'=>'img-responsive']); ?></a> </div>
            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class'=>'img-responsive']); ?></a> </div>
            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class'=>'img-responsive']); ?></a> </div>
            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class'=>'img-responsive']); ?></a> </div>
            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class'=>'img-responsive']); ?></a> </div>
            <div class="col-md-3 col-sm-3 col-xs-6"> <a href="#"><?= Html::img('@web/images/placeholder.jpg', ['width' => '200','height' => '200','alt' => 'placeholder','class'=>'img-responsive']); ?></a> </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Footer -->
  </div>
</div>
<!-- Bootstrap core JavaScript
    ================================================== -->
<script type="text/javascript">
    var PRO_COMP = '80';
</script>
<script src="<?=$HOME_URL?>js/jquery.js" type="text/javascript"></script>
<script src="<?=$HOME_URL?>js/selectFx.js"></script>
<!--<script src="<?/*=$HOME_URL*/?>js/jquery.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="<?/*=$HOME_URL*/?>js/bootstrap.min.js"></script>
<script src="<?/*=$HOME_URL*/?>js/custom.js"></script>
<script src="<?/*=$HOME_URL*/?>js/classie.js"></script>
<script src="<?/*=$HOME_URL*/?>js/selectFx.js"></script>
<script src="<?/*=$HOME_URL*/?>js/modernizr.js"></script>-->
<!-- Modernizr -->
