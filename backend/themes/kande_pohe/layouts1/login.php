<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\web\View;
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
	<link rel="shortcut icon" href="assets/images/favicon_1.ico">
	<title><?= ($this->title) ? Html::encode($this->title) . ' - ' . Yii::$app->name : Yii::$app->name ?></title>
	<?php $this->head() ?>
	<?php $this->registerJs('var resizefunc = [];',View::POS_HEAD); ?>

	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	        <![endif]-->

</head>
<body>
<?php $this->beginBody() ?>
	<div class="account-pages"></div>
	<div class="clearfix"></div>
	<div class="wrapper-page">
		<?= Alert::widget() ?>
		<?= $content ?>
	</div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>