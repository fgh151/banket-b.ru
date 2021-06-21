<?php

namespace app\user\assets;

use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class LandingAsset extends AssetBundle
{

    public $css = [
        'landing/css/bootstrap-theme.min.css',
        'landing/css/fontAwesome.css',
        'landing/css/hero-slider.css',
        'landing/css/owl-carousel.css',
        'landing/css/templatemo-style.css',
        'https://fonts.googleapis.com/css?family=Spectral:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i',
        'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900',
        'css/landing.css',
    ];

    public $js = [
        'landing/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js',
        'landing/js/plugins.js',
        'landing/js/main.js',
    ];

    public $depends = [
        BootstrapPluginAsset::class,
        JqueryAsset::class,
    ];
}
