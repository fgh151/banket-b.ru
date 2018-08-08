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
use app\common\models\MobileUser;
use app\common\models\Organization;
use app\common\models\OrganizationProposalStatus;
use app\common\models\Proposal;
use Prophecy\Exception\Doubler\MethodNotExtendableException;
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

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $response = [];
        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);

        $loggedIn = $request['loggedIn'];
        $email = $request['email'];
        $password = $request['password'];


        if (!$loggedIn) {
            $user = new MobileUser();
            $user->email = $email;
            $user->setPassword($password);
            $user->generateAuthKey();
            $user->created_at = $user->updated_at = time();
            $user->phone = time();
            $user->save();
            if ($user->errors) {
                return $user->errors;
            }
            Yii::$app->user->login($user, 3600 * 24 * 30);
            $response['access_token'] = $user->auth_key;
        }

        $request['owner_id'] = Yii::$app->getUser()->getId();
        $request['City'] = $request['city'];

        $proposal = new Proposal();
        $proposal->load($request, '');
        $proposal->save();

        return $proposal->errors;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionList()
    {
        return Proposal::find()->where(['owner_id' => Yii::$app->user->id])->all();
    }

    /**
     * @param $proposalId
     *
     * @return array|\yii\db\ActiveRecord[]
     */
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

    public function actionDelete($proposalId, $organizationId) {
        $status = new OrganizationProposalStatus();
        $status->organization_id = $organizationId;
        $status->proposal_id = $proposalId;
        $status->status = Constants::PROPOSAL_STATUS_REJECT;
        return $status->save();
    }

    /**
     * @param $id
     */
    public function actionClose($id) {
        throw new MethodNotExtendableException('метод еще не реализован');

    }

}