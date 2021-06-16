<?php

namespace app\user\assets;

use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class LandingAsset extends AssetBundle
{
    public $baseUrl = 'landing';

    public $css = [
        'css/bootstrap-theme.min.css',
        'css/fontAwesome.css',
        'css/hero-slider.css',
        'css/owl-carousel.css',
        'css/templatemo-style.css',
        'https://fonts.googleapis.com/css?family=Spectral:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i',
        'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900',
    ];

    public $js = [
        'js/vendor/modernizr-2.8.3-respond-1.4.2.min.js',
        'js/plugins.js',
        'js/main.js',
    ];

    public $depends = [
        BootstrapPluginAsset::class,
        JqueryAsset::class,
    ];
}
