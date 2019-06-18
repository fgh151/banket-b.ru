<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-13
 * Time: 18:26
 */

namespace app\cabinet\components;


use app\common\models\Organization;
use yii\db\Expression;
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

    /**
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return mixed
     * @throws \Throwable
     */
    public function afterAction($action, $result)
    {
        /** @var Organization $user */
        $user = \Yii::$app->getUser()->getIdentity();
        if ($user !== null) {
            $user->last_visit = new Expression('now()');
            $user->send_notify = true;
            $user->save();
        }

        return parent::afterAction($action, $result);
    }
}