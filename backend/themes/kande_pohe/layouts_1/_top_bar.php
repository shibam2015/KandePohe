<?php
//use backend\components\UserHelpers;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\helpers\Url;
?>
<?php //= Yii::$app->request->baseUrl.'/img/logo.png';?>
<div class="topbar-left">
     <div class="text-center">
          <?= html::a('<i class="md-album icon-c-logo"></i><span>' . str_replace('o', '<i class="md md-album"></i>', Yii::$app->name) . '</span>', ['/site/index'], ['class' => 'logo']); ?>
     </div>
</div>
<!-- Button mobile view to collapse sidebar menu -->
<div class="navbar navbar-default" role="navigation">
     <div class="container">
          <div class="">
               <div class="pull-left">
                    <button class="button-menu-mobile open-left">
                         <i class="ion-navicon"></i>
                    </button>
                    <span class="clearfix"></span>
               </div>
<!--                <form role="search" class="navbar-left app-search pull-left hidden-xs"> -->
<!--                     <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i> </a> -->
<!--                </form> -->
			  	<?= Menu::widget([
	          		'options'         => ['class'=>'nav navbar-nav navbar-right pull-right'],
					'itemOptions'     => ['class' => 'hidden-xs'],
	          		'submenuTemplate' => "\n<ul class='dropdown-menu dropdown-menu-lg'>\n{items}\n</ul>\n",
	          		'activateParents' => true,
	          		'items' => [
          				[
							'template' => html::a('<i class="icon-clock"></i> <span class="title">{label}</span><span class="selected"></span>', 'javascript:;', ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-close-others' => 'true']),
                        	'items' => [
								[
									'label' => 'Flush Cache',
									'url' => Url::to(['/site/flush-cache', 'back' => Yii::$app->request->url]),
							        //'visible'  => (Yii::$app->user->can('SHS Staff')),
									'template' => html::a('<i class="icon-energy"></i> {label}', '{url}'),
								],
                        	],
          				],/*
						[
							'template' => html::a('<i class="icon-bell"></i> <span class="badge badge-xs badge-danger">3</span>', '#', ['class' => 'dropdown-toggle', 'data-target' => '#', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-close-others' => 'true', 'aria-expanded' => 'true']),
							'items' => [
								[
									'options' => ['class' => 'notifi-title'],
									'template' => '<span class="label label-default pull-right">New 3</span>Notification',
								],
								[
									'options' => ['class' => 'list-group nicescroll notification-list'],
									'template' => '<!-- list item--> <a href="javascript:void(0);" class="list-group-item">
                                             <div class="media">
                                                  <div class="pull-left p-r-10">
                                                       <em class="fa fa-diamond fa-2x text-primary"></em>
                                                  </div>
                                                  <div class="media-body">
                                                       <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                                       <p class="m-0">
                                                            <small>There are new settings available</small>
                                                       </p>
                                                  </div>
                                             </div></a>
											<!-- list item--> <a href="javascript:void(0);" class="list-group-item">
                                             <div class="media">
                                                  <div class="pull-left p-r-10">
                                                       <em class="fa fa-cog fa-2x text-custom"></em>
                                                  </div>
                                                  <div class="media-body">
                                                       <h5 class="media-heading">New settings</h5>
                                                       <p class="m-0">
                                                            <small>There are new settings available</small>
                                                       </p>
                                                  </div>
                                             </div></a>
											<!-- list item--> <a href="javascript:void(0);" class="list-group-item">
                                             <div class="media">
                                                  <div class="pull-left p-r-10">
                                                       <em class="fa fa-bell-o fa-2x text-danger"></em>
                                                  </div>
                                                  <div class="media-body">
                                                       <h5 class="media-heading">Updates</h5>
                                                       <p class="m-0">
                                                            <small>There are <span class="text-primary font-600">2</span> new updates
                                                                 available
                                                            </small>
                                                       </p>
                                                  </div>
                                             </div></a>
											<!-- list item--> <a href="javascript:void(0);" class="list-group-item">
                                             <div class="media">
                                                  <div class="pull-left p-r-10">
                                                       <em class="fa fa-user-plus fa-2x text-info"></em>
                                                  </div>
                                                  <div class="media-body">
                                                       <h5 class="media-heading">New user registered</h5>
                                                       <p class="m-0">
                                                            <small>You have 10 unread messages</small>
                                                       </p>
                                                  </div>
                                             </div></a>
											<!-- list item--> <a href="javascript:void(0);" class="list-group-item">
                                             <div class="media">
                                                  <div class="pull-left p-r-10">
                                                       <em class="fa fa-diamond fa-2x text-primary"></em>
                                                  </div>
                                                  <div class="media-body">
                                                       <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                                       <p class="m-0">
                                                            <small>There are new settings available</small>
                                                       </p>
                                                  </div>
                                             </div></a>
											<!-- list item--> <a href="javascript:void(0);" class="list-group-item">
                                             <div class="media">
                                                  <div class="pull-left p-r-10">
                                                       <em class="fa fa-cog fa-2x text-custom"></em>
                                                  </div>
                                                  <div class="media-body">
                                                       <h5 class="media-heading">New settings</h5>
                                                       <p class="m-0">
                                                            <small>There are new settings available</small>
                                                       </p>
                                                  </div>
                                             </div></a>',
								],
								[
									'template' => html::a('<small class="font-600">See all notifications</small>', '#', ['class' => 'list-group-item text-right']),
								],
							],
						],*/
						[
							'template' => html::a('<i class="icon-size-fullscreen"></i>', '#', ['class' => 'waves-effect waves-light', 'id' => 'btn-fullscreen']),
						],
// 						[
// 							'template' => html::a('<i class="icon-settings"></i>', '#', ['class' => 'right-bar-toggle waves-effect waves-light']),
// 						],
						[
							'submenuTemplate' => "\n<ul class='dropdown-menu'>\n{items}\n</ul>\n",
							'template' => html::a(html::img('vishal', ['class' => 'img-circle user_avatar', 'alt' => 'user-img']), '#', ['class' => 'dropdown-toggle profile', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-close-others' => 'true', 'aria-expanded' => 'true']),
							'items' => [
								[
									'template' => html::a('<i class="ti-user m-r-5"></i> Profile', ['user/profile'],[]),
								],
 								[
 									'template' => html::a('<i class="ti-settings m-r-5"></i> Change Password</a>', ['user/change-password']),
 								],
// 								[
// 									'template' => html::a('<i class="ti-lock m-r-5"></i> Lock screen</a>', 'javascript:void(0)'),
// 								],
								[
									'template' => html::a('<i class="ti-power-off m-r-5"></i> Logout</a>', ['site/logout'], ['data-method' => 'post']),
								]
							]
						]
			         ],
				]);
			 ?>
          </div>
          <!--/.nav-collapse -->
     </div>
</div>

