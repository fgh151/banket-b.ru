<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-04-23
 * Time: 12:55
 */

namespace app\cabinet\assets;


use yii\web\AssetBundle;

class ConversationAsset extends AssetBundle
{
    public $css = [
        '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css',
        'css/Messenger.css'
    ];

    public $js = [
        'js/Messenger.js?v2'
    ];

    public $jsOptions = [
        'type' => 'text/babel'
    ];

    public $depends = [
        MomentJsAsset::class,
        FirebaseAsset::class,
        ReactAsset::class
    ];

}