<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 13:05
 */

namespace app\api\controllers;


use app\common\models\Activity;
use app\common\models\Promo;
use app\common\models\PromoRedirect;
use yii\rest\Controller;

class PromoController extends Controller
{

    public function actionList($id = null)
    {
        return [];
//        return PromoModel::findActive($id)
//                         ->andWhere(['<=', 'start', date('Y-m-d')])
//                         ->andWhere(['>=', 'end', date('Y-m-d')])
//                         ->limit(20)
//                         ->orderBy('random()')
//                         ->all();
    }

    public function actionRedirect($id)
    {
        $model = Promo::findOne($id);

        $redirect = new PromoRedirect();
        $redirect->promo_id = $model->id;
        $redirect->created_at = time();
        $redirect->save();

        $this->redirect($model->link);
    }

    public function actionActivity()
    {
        return Activity::find()->all();
    }

}