<?php
use yii\helpers\Html;
use yii\widgets\Menu;
// use backend\components\UserHelpers;
?>
<?php //$slug = UserHelpers::getSitePageSlugByUser();?>
<div class="sidebar-inner slimscrollleft">
	<div id="sidebar-menu">
		<?= Menu::widget([
          		'activateParents' => true,
          		'items'           => [
                    [
                        'label'    => 'Dashboard',
                        'url'      => ['/site/index'],
                        'template' => '<a href="{url}"><i class="fa fa-dashboard"></i> <span>{label}</span></a>'
                    ],
					
          		],
            ]); ?>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</div>
