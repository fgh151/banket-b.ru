<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 13:05
 */

namespace app\api\controllers;


use app\common\models\Promo as PromoModel;
use yii\rest\Controller;

class PromoController extends Controller
{

    public function actionList()
    {
        return PromoModel::findActive()
            ->orderBy('sort')
            ->all();
    }

}