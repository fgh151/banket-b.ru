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
use app\common\components\Constants;
use app\common\components\SmsInterface;
use app\common\models\MobileUser;
use app\common\models\Proposal;
use yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;

class AuthController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['except'][] = 'index';
        $behaviors['authenticator']['except'][] = 'register';
        $behaviors['authenticator']['except'][] = 'recover';
        $behaviors['authenticator']['except'][] = 'change-password';
        $behaviors['authenticator']['except'][] = 'create';

        return $behaviors;
    }

    /**
     * @return \stdClass | array
     * @throws \Throwable
     */
    public function actionIndex()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->getRequest()->get(), '') && $model->login()) {
            return [
                'access_token' => Yii::$app->getUser()->getIdentity()->getAuthKey(),
                'id' => (string)Yii::$app->getUser()->getId()
            ];
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

            $reg = $model->register();

            if (!is_array($reg)) {
                return [
                    'access_token' => $reg->getAuthKey(),
                    'id' => $reg->id
                ];
            } else {

                $response = [];
                foreach ($reg as $error) {
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

            $user->password_reset_token = (string) rand(100000, 999999);
            $user->save();

            /** @var SmsInterface $smsService */
            $smsService = Yii::$app->sms;
            return $smsService->sendSms(
                'Код подтверждения '.$user->password_reset_token,
                $user->phone
            );
        }
        return false;
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
            $user->save();

            return [
                'access_token' => $user->getAuthKey(),
                'id' => $user->id
            ];
        }

        return [
            'access_token' => $user->getAuthKey(),
            'id' => $user->id
        ];

    }

    /**
     * @return array
     * @throws Exception
     */
    public function actionCreate()
    {
        $response = [];
        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);

        $email = $request['email'];
        $phone = $request['phone'];
        $name = $request['name'];
        $password = $request['password'];
        $user = new MobileUser();
        $user->email = $email;
        $user->name = $name;
        $user->phone = $phone;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->created_at = $user->updated_at = time();
        $user->status = Constants::USER_STATUS_ACTIVE;
        $user->save();
        if ($user->errors) {
            return $user->errors;
        }
        Yii::$app->user->login($user, 3600 * 24 * 30);
        $response['access_token'] = $user->auth_key;
        $response['id'] = $user->id;

        $request['owner_id'] = Yii::$app->getUser()->getId();
        $request['City'] = $request['city'];
        $request['city_id'] = $request['cityId'];
        $request['region_id'] = $request['regionId'];
        $request['all_regions'] = $request['allRegions'];

        $proposal = new Proposal();
        $proposal->load($request, '');
        $proposal->save();
        $response = ArrayHelper::merge($response, $proposal->errors);

        return $response;
    }

}