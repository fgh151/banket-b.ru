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
            foreach ($model->errors as $field => $error) {
                $response = new \stdClass();
                $response->name = $field;
                $response->message = $error[0];
                $response->code = 0;
                $response->status = 403;
            }
            Yii::$app->response->statusCode = 403;
            return $response;
        }
    }

    /**
     * @return bool | array
     * @throws yii\base\Exception
     */
    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return ['access_token' => $model->getAuthKey()];
        }
        return false;
    }
}