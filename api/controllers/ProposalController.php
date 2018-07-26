<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 25.07.18
 * Time: 13:34
 */

namespace app\api\controllers;


use app\common\components\Constants;
use app\common\models\Message;
use app\common\models\Organization;
use app\common\models\OrganizationProposalStatus;
use app\common\models\Proposal;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

class ProposalController extends Controller
{

    public function behaviors()
    {
        return [
//            'authenticator' => [
//                'class' => HttpBearerAuth::class
//            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]
            ],
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'actions' => ['create'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ]
        ];
    }

    public function verbs()
    {
        return [
            'create' => ['post']
        ];
    }

    public function actionCreate()
    {


        var_dump(\Yii::$app->request->post());

    }

    public function actionList()
    {
        return Proposal::find()->where(['owner_id' => 1])->all();
    }

    public function actionDialogs($proposalId)
    {
        $organizationsFromMessages = array_keys(Message::findAll($proposalId));
        /** @var OrganizationProposalStatus[] $rejected */
        $rejected = OrganizationProposalStatus::find()->where(['proposal_id' => $proposalId])
            ->andWhere(['!=', 'status', Constants::ORGANIZATION_PROPOSAL_STATUS_REJECT])
            ->all();
        foreach ($rejected as $item) {
            unset($organizationsFromMessages[$item->organization_id]);
        }

        return Organization::find()
            ->where(['in', 'id', $organizationsFromMessages])
            ->all();
    }

}