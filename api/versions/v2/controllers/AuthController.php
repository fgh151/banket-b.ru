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
                'access_token' => $model->getUser()->getAuthKey(),
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
        return $this->sendCode($model);
    }

    public function actionSendregistercode()
    {
        $model = $this->loadModel(Auth::SCENARIO_REGISTER);
        return $this->sendCode($model);
    }

    /**
     * @param Auth|null $model
     * @return array
     * @throws \yii\base\Exception
     */
    protected function sendCode(?Auth $model)
    {
        if ($model !== false) {
            $code = $model->getCode();
            if ($code) {
                /** @var SmsInterface $smsService */
                $smsService = Yii::$app->sms;
                $r = $smsService->sendSms('Код подтверждения ' . $code, $model->phone);
                if ($r) {
                    return ['code' => $code];
                }
            }
        }
    }
}