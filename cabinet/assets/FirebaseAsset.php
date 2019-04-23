<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-04-23
 * Time: 12:30
 */

namespace app\cabinet\assets;


use yii\web\AssetBundle;

class FirebaseAsset extends AssetBundle
{
    public $js = [
        'https://www.gstatic.com/firebasejs/5.10.0/firebase-app.js',
        'https://www.gstatic.com/firebasejs/5.10.0/firebase-database.js',
    ];
}