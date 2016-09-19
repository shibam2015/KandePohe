<?php

use yii;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use backend\assets\AppAsset;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html <?= Yii::$app->language ?>>
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?= Html::csrfMetaTags() ?>
<title><?= ($this->title) ? Html::encode($this->title) . ' - ' . Yii::$app->name : Yii::$app->name ?>
</title>
<?php $this->head() ?>
<meta
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
	name="viewport">
</head>
<body
	class="hold-transition sidebar-mini fixed sidebar-mini skin-blue-light">
	<div class='main_overlay'></div>
	<div class="main_loader">
	<?= Html::img('@web/img/loading.gif', ['alt' => 'loading', 'class' => 'img-loading']); ?>
	</div>
	<?php $this->beginBody() ?>
	<!-- Site wrapper -->
	<div class="wrapper">

	<?= $this->render('_top_bar'); ?>
		<!-- =============================================== -->
		<!-- Left side column. contains the sidebar -->
	<?= $this->render('_left'); ?>
		<!-- =============================================== -->
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" id="sm-body-scroll">
			<section class="content">
			<?php Pjax::begin(['id' => 'main-alert-widget']); ?>
			<?= Alert::widget() ?>
			<?php Pjax::end(); ?>
			<?= $content?>
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2014-2015 <a href="javascript:void(0)">Ezbilling</a>.</strong>
			All rights reserved.
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Create the tabs -->
			<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
				<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i
						class="fa fa-home"></i> </a></li>
				<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i
						class="fa fa-gears"></i> </a></li>
				<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i
						class="fa fa-home"></i> </a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<!-- Home tab content -->
				<div class="tab-pane" id="control-sidebar-home-tab">
					<h3 class="control-sidebar-heading">Recent Activity</h3>
					<ul class="control-sidebar-menu">
						<li><a href="javascript::;"> <i
								class="menu-icon fa fa-birthday-cake bg-red"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
									<p>Will be 23 on April 24th</p>
								</div> </a>
						</li>
					</ul>
					<!-- /.control-sidebar-menu -->
					<h3 class="control-sidebar-heading">Tasks Progress</h3>
					<ul class="control-sidebar-menu">
						<li><a href="javascript::;">
								<h4 class="control-sidebar-subheading">
									Custom Template Design <span
										class="label label-danger pull-right">70%</span>
								</h4>
								<div class="progress progress-xxs">
									<div class="progress-bar progress-bar-danger"
										style="width: 70%"></div>
								</div> </a>
						</li>

					</ul>
				</div>
				<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab
					Content</div>
				<div class="tab-pane" id="control-sidebar-settings-tab">
					<form method="post">
						<h3 class="control-sidebar-heading">General Settings</h3>
						<div class="form-group">
							<label class="control-sidebar-subheading"> Report panel usage <input
								type="checkbox" class="pull-right" checked> </label>
							<p>Some information about this general settings option</p>
						</div>
						<!-- /.form-group -->
					</form>
				</div>
			</div>
		</aside>
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->
	<?php Modal::begin(['id'=>'modal-box', 'size' => 'modal-lg', 'header' => '<div class="box-header col-xs-11"><h4 class="box-title modal-title"></h4></div><div class="clearfix"></div>', 'clientOptions' => ['modal' => true]]); ?>
	<iframe id="modal_content" name="modal_content" width="100%"
		height="380px" style="border: none"
		src="<?= Url::to(['site/blank']) ?>"></iframe>
		<?php Modal::end();	?>
		<?php $this->endBody() ?>
</body>
</html>
		<?php $this->endPage() ?>