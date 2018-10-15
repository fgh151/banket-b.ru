<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 12.10.2018
 * Time: 10:09
 */

namespace app\api\controllers;


use app\common\models\geo\GeoRegion;
use yii\rest\Controller;

class CityController extends Controller
{

    public function actionIndex()
    {
        return GeoRegion::find()->orderBy('order')->with('cities')->all();
    }

}