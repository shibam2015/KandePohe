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
        'plugings/loader/pace.min.css'
    ];
    public $js = [
		// 'js/jquery.js',
		'js/bootstrap.min.js',
		'js/custom.js',
		'js/classie.js',
		// 'js/selectFx.js',
		'js/jquery.nice-select.min.js',
		'js/modernizr.js',
        'js/modernizr.js',
        'plugings/loader/pace.min.js'
    ];
}
