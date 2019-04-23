<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-04-23
 * Time: 12:54
 */

namespace app\cabinet\assets;


use yii\web\AssetBundle;

class ReactAsset extends AssetBundle
{
    public $sourcePath = '@bower-asset/react';

    public $js = [
        'https://unpkg.com/babel-standalone@6/babel.min.js',
        'react.production.min.js',
        'react-dom.production.min.js',
    ];
}