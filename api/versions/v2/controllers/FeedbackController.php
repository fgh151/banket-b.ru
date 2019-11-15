<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-17
 * Time: 13:51
 */

namespace app\api\versions\v2\controllers;


use app\common\models\Feedback;
use app\jobs\SendFeedbackNotifyJob;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class FeedbackController extends Controller
{

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => HttpBearerAuth::class
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]
            ],
        ];
    }

    public function verbs()
    {
        return [
            'add' => ['post']
        ];
    }

    /**
     * @return Feedback|array
     */
    public function actionAdd()
    {
        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);

        $model = new Feedback();
        if ($model->load($request, '')) {
            $model->user_id = Yii::$app->getUser()->getId();
            if ($model->save()) {
                $queue = Yii::$app->queue;
                $queue->push(new SendFeedbackNotifyJob());

                Yii::$app->response->statusCode = 201;
                return $model;
            }
        }
        return $model->errors;
    }

}