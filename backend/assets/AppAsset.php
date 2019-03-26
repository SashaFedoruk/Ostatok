<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.css',
        'css/font-awesome.min.css',
        'css/select2.css',
        'css/main.css',
    ];
    public $js = [
        // 'js/jquery.js',
        'js/bootstrap.min.js',
        'js/select2.js',
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];


}
