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
use yii;
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
                $response = new \stdClass();
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
        if ($model->load($request, '') ) {
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
}