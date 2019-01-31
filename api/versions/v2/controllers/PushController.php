<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 16.01.2019
 * Time: 12:45
 */

namespace app\api\versions\v2\controllers;


use app\common\models\PushToken;
use Yii;
use yii\helpers\Json;
use yii\rest\Controller;

class PushController extends Controller
{

    private $token = 'cUeRfPWnqxU:APA91bFC9CuPyf5URxSu5SihGH0zW2VyuHm1DBW0y_mRFGILyobcgVxmjhYMTdRJVqH4yQjXH0gePFa-wJLgtnC8pwtURnHGUxTHyF7zUmB5cOHSTY6HsIkmweYxAdm_lqwGGLHVQhfK';


    /**
     * Save push token
     */
    public function actionIndex()
    {
        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);
        $userId = $request['user'];
        $pushToken = $request['token'];
        $device = $request['device'];
        $apns = $request['apns'] ?? '';

        $token = new PushToken();
        $token->user_id = $userId;
        $token->token = $pushToken;
        $token->device = $device;
        $token->apns = $apns;
        $token->save();
    }


}