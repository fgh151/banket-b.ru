<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-17
 * Time: 13:51
 */

namespace app\api\versions\v2\controllers;


use app\common\models\Funnel;
use Yii;
use yii\helpers\Json;
use yii\rest\Controller;

class FunnelController extends Controller
{
    /**
     * @return Funnel|array
     */
    public function actionIndex()
    {
        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);

        $model = new Funnel();
        $model->event = $request['event'];
        $model->uid = $request['uid'];
        $model->user_id = $request['userId'];
        $model->extra = json_decode($request['extra']);
        if ($model->save()) {
            return $model;
        }
        return $model->errors;
    }

}