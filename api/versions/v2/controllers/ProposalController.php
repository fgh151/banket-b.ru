<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-17
 * Time: 15:48
 */

namespace app\api\versions\v2\controllers;

use app\api\models\Proposal;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class ProposalController extends Controller
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
            'create' => ['post']
        ];
    }

    /**
     * @return Proposal|array
     * @throws \Exception
     */
    public function actionCreate()
    {
        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);
        $request['owner_id'] = Yii::$app->getUser()->getId();
        $request['city_id'] = $request['cityId'];

        $proposal = new Proposal();
        $proposal->load($request, '');
        if ($proposal->save()) {
            return $proposal;
        }
        return $proposal->errors;
    }
}