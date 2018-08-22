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
                         ->andWhere(['<=', 'start', date('Y-M-d')])
                         ->andWhere(['>=', 'end', date('Y-M-d')])
                         ->limit(20)
                         ->orderBy('random()')
                         ->all();
    }

}