<?php

//use Yii;
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

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Sports Hub Soccer">
	<meta name="author" content="Sports Hub Soccer">
	<?= Html::csrfMetaTags() ?>
    <link href="<?= Url::to("@web") ?>/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

	<title><?= ($this->title) ? Html::encode($this->title) . ' - ' . Yii::$app->name : Yii::$app->name ?></title>
	<?php $this->head() ?>
    <?php Yii::$app->view->registerJs('var resizefunc = [], href_blank = "'. Url::to(['/site/blank']) . '";',  View::POS_HEAD); ?>

	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

</head>
<body class="fixed-left">
	<!-- Begin page -->
	<div id="wrapper">
	<?php $this->beginBody() ?>
		<!-- Top Bar Start -->
		<div class="topbar">
		<?= $this->render('_top_bar'); ?>
		</div>
		<!-- Top Bar End -->
		<!-- ========== Left Sidebar Start ========== -->
		<div class="left side-menu">
		<?= $this->render('_left'); ?>
		</div>
		<div class="content-page">
			<!-- Start content -->
			<div class="content">
				<div class="container">
					<?php /*?>
					<!-- Page-Title -->
					<div class="row">
						<div class="col-sm-12">
							<h4 class="page-title"><?= $this->title;?></h4>
							<ol class="breadcrumb">
								<li><a href="#">Ubold</a>
								</li>
								<li><a href="#">Pages</a>
								</li>
								<li class="active">Blank Page</li>
							</ol>
						</div>
					</div> <?php /**/?>
					<?php Pjax::begin(['id' => 'main-alert-widget']); ?><?= Alert::widget() ?><?php Pjax::end(); ?>
					<?= $content?>
				</div>
				<!-- container -->
			</div>
			<!-- content -->
			<footer class="footer"><?= date("Y") ?> @ <?= \Yii::$app->name ?></footer>
		</div>
		<?php Modal::begin(['id'=>'modal-box', 'size' => 'modal-lg', 'header' => '<h4 class="modal-title"></h4>', 'clientOptions' => ['modal' => true], 'closeButton' => ['label' => '<i class="fa fa-times-circle"></i>']]); ?><iframe id="modal_content" name="modal_content" width="100%" height="380px" style="border:none" src="<?= Url::to(['/site/blank']) ?>"></iframe><?php Modal::end(); ?>
		<?php $this->endBody() ?>
	</div>
	<!-- END wrapper -->
</body>
</html><?php $this->endPage() ?>