<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 15:15
 */

namespace app\cabinet\controllers;


use app\common\components\Constants;
use app\common\models\Organization;
use app\common\models\OrganizationProposalStatus;
use app\common\models\Proposal;
use app\common\models\ProposalSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class BattleController extends Controller
{

    use CheckPayTrait;
    /**
     * @param $action
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->throwIfNotPay('state');
        return parent::beforeAction($action);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionIndex()
    {
        $searchModel = new ProposalSearch();

        /** @var Organization $organization */
        $organization = Yii::$app->getUser()->getIdentity();
        if ($organization->state == Constants::ORGANIZATION_STATE_PAID) {

            $rejected = OrganizationProposalStatus::find()
                ->where([
                    'organization_id' => $organization->getId(),
                    'status' => Constants::ORGANIZATION_PROPOSAL_STATUS_REJECT
                ])
                ->select('proposal_id')->asArray()->all();

            foreach ($rejected as $record) {
                $searchModel->rejected[] = $record['proposal_id'];
            }
            $searchModel->status = Constants::PROPOSAL_STATUS_CREATED;

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        } else {
            // Формируем запрос, который заведомо ничего не вернет
            $dataProvider = new ActiveDataProvider();
            $dataProvider->query = Proposal::find()->where(['id' => 0]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'organization' => $organization,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionDirect()
    {
        $searchModel = new ProposalSearch();

        /** @var Organization $organization */
        $organization = Yii::$app->getUser()->getIdentity();
        if ($organization->state == Constants::ORGANIZATION_STATE_PAID) {


            $rejected = OrganizationProposalStatus::find()
                ->where([
                    'organization_id' => $organization->getId(),
                    'status' => Constants::ORGANIZATION_PROPOSAL_STATUS_REJECT
                ])
                ->select('proposal_id')->asArray()->all();

            foreach ($rejected as $record) {
                $searchModel->rejected[] = $record['proposal_id'];
            }
            $searchModel->status = Constants::PROPOSAL_STATUS_CREATED;

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->getUser()->getId());



        } else {
            // Формируем запрос, который заведомо ничего не вернет
            $dataProvider = new ActiveDataProvider();
            $dataProvider->query = Proposal::find()->where(['id' => 0]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'organization' => $organization,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionReject($id)
    {
        $model = new OrganizationProposalStatus();
        $model->organization_id = Yii::$app->getUser()->getId();
        $model->proposal_id = $id;
        $model->status = Constants::ORGANIZATION_PROPOSAL_STATUS_REJECT;
        $model->save();
        $this->redirect(['index']);
    }
}