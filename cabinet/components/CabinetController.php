<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-13
 * Time: 18:26
 */

namespace app\cabinet\components;


use app\common\models\Organization;
use yii\web\Controller;

class CabinetController extends Controller
{

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $uid = \Yii::$app->request->get('uid', false);
        $Hash = \Yii::$app->request->get('hash', false);
        if ($uid && $Hash) {
            $this->FastAuth($uid, $Hash);
        }
        return parent::beforeAction($action);
    }

    private function FastAuth($id, $Hash)
    {
        $user = Organization::findOne($id);
        if ($user) {
            if ($Hash === $user->getHash()) {
                \Yii::$app->user->login($user, 3600 * 24 * 30);
            }
        }
    }
}