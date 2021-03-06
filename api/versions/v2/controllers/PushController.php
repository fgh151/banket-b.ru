<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 16.01.2019
 * Time: 12:45
 */

namespace app\api\versions\v2\controllers;


use app\api\models\Organization;
use app\api\models\Proposal;
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

        $existToken = PushToken::find()->where(['token' => $pushToken])->one();

        if ($existToken) {
            $existToken->user_id = $userId;

            return [
                'success' => $existToken->save(),
                'id' => $existToken->user_id
            ];

        } else {
            $token = new PushToken();
            $token->user_id = $userId;
            $token->token = $pushToken;
            $token->device = $device;
            $token->apns = $apns;
            return [
                'success' => $token->save(),
                'id' => $token->user_id
            ];
        }
    }

    public function actionInfo($organizationId, $proposalId)
    {
        $proposal = Proposal::findOne($proposalId);
        $organization = Organization::findOne($organizationId);
        $organization->proposal = $proposal;
        return [
            'organization' => $organization,
            'proposal' => $proposal
        ];
    }


}