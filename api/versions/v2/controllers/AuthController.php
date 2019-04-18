<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 11.01.2019
 * Time: 12:13
 */

namespace app\api\versions\v2\controllers;


use app\api\versions\v2\models\Auth;
use app\common\components\SmsInterface;
use Yii;
use yii\helpers\Json;
use yii\rest\Controller;

class AuthController extends Controller
{

    public function actionIndex()
    {

        $model = $this->loadModel(Auth::SCENARIO_LOGIN);

        if ($model !== false) {

            if (!$model->validate()) {
                $response = [];
                foreach ($model as $error) {
                    $response['error'] = $error[0];
                }
                Yii::$app->response->statusCode = 403;
                return $response;
            }

            $model->login();
            return [
                'access_token' => Yii::$app->getUser()->getIdentity()->getAuthKey(),
                'id' => (string)Yii::$app->getUser()->getId()
            ];
        }
    }

    /**
     * @param string $scenario
     * @return Auth|bool
     */
    private function loadModel($scenario = Auth::SCENARIO_SMS)
    {
        $model = new Auth();
        $model->scenario = $scenario;
        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);

        $load = $model->load($request, '');

        return $load ? $model : false;
    }

    public function actionSendcode()
    {
        $model = $this->loadModel();
        if ($model !== false) {
            $code = $model->getCode();
            if ($code) {
                /** @var SmsInterface $smsService */
                $smsService = Yii::$app->sms;
                if ($smsService->sendSms('Код подтверждения ' . $code, $model->phone)) {
                    return ['code' => $code];
                }
            }
        }
    }
}