<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 13:05
 */

namespace app\api\controllers;


use app\api\models\Promo as PromoModel;
use yii\rest\Controller;

class PromoController extends Controller
{

    public function actionList()
    {
        return PromoModel::findActive()
                         ->andWhere(['<=', 'start', date('Y-m-d')])
                         ->andWhere(['>=', 'end', date('Y-m-d')])
                         ->limit(20)
                         ->orderBy('random()')
                         ->all();
    }

}