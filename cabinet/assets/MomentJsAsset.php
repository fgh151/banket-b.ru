<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-04-24
 * Time: 10:55
 */

namespace app\cabinet\assets;


use yii\web\AssetBundle;

class MomentJsAsset extends AssetBundle
{
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/ru.js',
    ];
}