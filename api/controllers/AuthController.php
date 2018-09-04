<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 18.05.17
 * Time: 9:07
 */

namespace app\api\controllers;

use app\api\models\LoginForm;
use app\api\models\RegisterForm;
use app\common\models\MobileUser;
use yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;

class AuthController extends Controller
{

    /**
     * @return \stdClass | array
     */
    public function actionIndex()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->getRequest()->get(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $response = null;
            foreach ($model->errors as $error) {
                $response        = new \stdClass();
                $response->error = $error[0];
            }
            Yii::$app->response->statusCode = 403;

            return $response;
        }
    }

    /**
     * @return array|boolean
     * @throws yii\base\Exception
     */
    public function actionRegister()
    {
        $model = new RegisterForm();

        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);

        if ($model->load($request, '')) {
            if ($key = $model->register()) {
                return ['access_token' => $key];
            } else {

                $response = [];
                foreach ($model->getUser()->errors as $error) {
                    $response['error'] = $error[0];
                }
                Yii::$app->response->statusCode = 403;

                return $response;
            }
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function actionRecover()
    {
        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);
        $phone   = $request['phone'];

        /**
         * Находим человека и отправляем еу СМС
         */
        $user = MobileUser::find()->where(['phone' => $phone])->one();


        if ($user) {

            $user->password_reset_token = Yii::$app->security->generateRandomString(6);
            $user->save();

            return $this->sendSms(
                'Код подтверждения '.$user->password_reset_token,
                $user->phone,
                '0012c0439ade32a5c19974d4053b22f8',
                'ac2ea781ced8dd8a479849addcd758a6'
            );
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function actionChangePassword()
    {

        $request     = Json::decode(Yii::$app->getRequest()->getRawBody(), true);
        $code        = $request['code'];
        $newPassword = $request['newPassword'];

        /** @var MobileUser $user */
        $user = MobileUser::find()->where(['password_reset_token' => $code])->one();
        if ($user) {

            $user->password_reset_token = null;
            $user->setPassword($newPassword);
            $user->generateAuthKey();

            return ['access_token' => $user->getAuthKey()];
        }

        return $user;

    }


    /**
     * @param $text
     * @param $phone
     * @param $key
     * @param $secret
     *
     * @throws Exception
     */
    private function sendSms($text, $phone, $key, $secret)
    {
        $smsParams = [
            'datetime'     => '',
            'key'          => $key,
            'sender'       => 'restorate',
            'sms_lifetime' => 1,
            'type'         => 2,

        ];

        $resultParams = yii\helpers\ArrayHelper::merge($smsParams, [
            'phone' => $phone,
            'text' => $text
        ]);

        $hash = $this->getSum($resultParams, $secret);
        $resultParams['sum'] = $hash;

        $Curl = curl_init();
        $CurlOptions = [
            CURLOPT_URL            => 'http://api.myatompark.com/sms/3.0/sendSMS',
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_POST           => true,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT        => 100,
            CURLOPT_POSTFIELDS     => $resultParams,
        ];
        curl_setopt_array($Curl, $CurlOptions);
        if (false === ($Result = curl_exec($Curl))) {
            throw new Exception('Http request failed');
        }

        curl_close($Curl);

        echo $Result;
    }

    private function  getSum($options, $secret)
    {
        $sumParams = [
            'action'  => 'sendSMS',
            'version' => '3.0'
        ];
        $resultParams = ArrayHelper::merge($options, $sumParams);
        ksort($resultParams);
        $resultString = '';

        foreach ($resultParams as $param) {
            $resultString .=$param;
        }
        $resultString .= $secret;
        return md5($resultString);
    }
}