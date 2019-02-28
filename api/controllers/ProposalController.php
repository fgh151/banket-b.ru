<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 25.07.18
 * Time: 13:34
 */

namespace app\api\controllers;


use app\admin\components\ProposalFindOneTrait;
use app\api\models\Organization;
use app\api\models\Proposal;
use app\common\components\Constants;
use app\common\models\Message;
use app\common\models\OrganizationProposalStatus;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class ProposalController extends Controller
{
    use ProposalFindOneTrait;

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
     * @return array
     */
    public function actionCreate()
    {
        $response = [];
        $request = Json::decode(Yii::$app->getRequest()->getRawBody(), true);

        $request['owner_id'] = Yii::$app->getUser()->getId();
//        $request['City'] = $request['city'];
        $request['city_id'] = $request['cityId'];

        $proposal = new Proposal();
        $proposal->load($request, '');
        $proposal->save();
        $response = ArrayHelper::merge($response, $proposal->errors);

        return $response;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionList()
    {

        return Proposal::find()
            ->where([
                'owner_id' => Yii::$app->user->id,
                'status' => Constants::PROPOSAL_STATUS_CREATED
            ])
            ->andFilterWhere(['>=', 'date', date('Y-m-d')])
            ->orderBy(['date' => SORT_ASC])
            ->all();
    }

    /**
     * @param $proposalId
     *
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDialogs($proposalId)
    {
        $proposal = $this->findModel($proposalId);

        $organizationsFromMessages = array_keys(Message::findAll($proposal->owner_id, $proposal->id) ?: []);
        /** @var OrganizationProposalStatus[] $rejected */
        $rejected = OrganizationProposalStatus::find()->where(['proposal_id' => $proposalId])
            ->andWhere(['<>', 'status', Constants::ORGANIZATION_PROPOSAL_STATUS_REJECT])
            ->all();
        foreach ($rejected as $item) {
            unset($organizationsFromMessages[$item->organization_id]);
        }

        $organizations = Organization::find()
            ->where(['in', 'id', $organizationsFromMessages])
            ->andFilterWhere(['state' => Constants::ORGANIZATION_STATE_PAID])
            ->all();
        foreach ($organizations as $record) {
            $record->proposal = $proposal;
        }

        return $organizations;
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
        $proposal = Proposal::findOne($id);
        $proposal->status = Constants::PROPOSAL_STATUS_CLOSED;
        $proposal->save(false);
    }

}