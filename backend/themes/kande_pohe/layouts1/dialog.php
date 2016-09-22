<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\web\View;
use backend\assets\AppAsset;
use common\widgets\Alert;
use common\models\SiteSettings;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" style="background-color:#fffeff">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="#" id="site_favicon" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<?php $this->registerJs('var resizefunc = [];',View::POS_HEAD); ?>
</head>
<body style="background-color:#fffeff">
    <?php $this->beginBody() ?>
        <div class="container-fluid">
            <div class="row" style="margin-top:10px">
    	        <?php Pjax::begin(['id' => 'main-alert-widget']); ?><?= Alert::widget() ?><?php Pjax::end(); ?>
    	        <?= $content ?>
            </div>
        </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
