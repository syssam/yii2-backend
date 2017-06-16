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
        'plugin/bootstrap-3.3.7-dist/css/bootstrap.min.css',
        'plugin/font-awesome-4.7.0/css/font-awesome.min.css',
        'css/style.css',
    ];
    public $js = [
        'plugin/bootstrap-3.3.7-dist/js/bootstrap.min.js',
        'javascript/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
