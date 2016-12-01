<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'css/bootstrap.min.css',
        'css/style.css',
        'css/nice-select.css',
		'css/cs-select.css',
		'css/cs-skin-border.css',
		'css/style-responsive.css',
        'plugings/loader/pace.min.css',
        'css/customstyle.css',
        'plugings/l1/waitMe.css'
    ];
    public $js = [
		// 'js/jquery.js',
		'js/bootstrap.min.js',
		'js/custom.js',
		'js/classie.js',
		// 'js/selectFx.js',
		'js/jquery.nice-select.min.js',
		'js/modernizr.js',
        #'js/modernizr.js',
        'plugings/loader/pace.min.js',
        #'js/cover/jquery-ui.min.js', //Cover Photo
        'js/cover/jquery.wallform.js', //Cover Photo
        'plugings/l1/waitMe.js', // Loader
        'js/angular/controller/commonController.js' // Angular Controller
    ];
}
