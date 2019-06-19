<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 15:15
 */

namespace app\cabinet\controllers;

use app\cabinet\components\CabinetController;
use app\common\components\Constants;
use app\common\models\Organization;
use app\common\models\OrganizationProposalStatus;
use app\common\models\Proposal;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class BattleController extends CabinetController
{
    use CheckPayTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    /**
     * @param $action
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionIndex()
    {
        /** @var Organization $organization */
        $organization = Organization::findOne(Yii::$app->getUser()->getId());
//        $this->throwIfNotPay('state');
        $searchModel = $organization->proposalSearchModel;
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
            $searchModel->with = ['owner', 'known', 'readMessage'];

            $searchModel->date = date('Y-m-d');
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            // Формируем запрос, который заведомо ничего не вернет
            $dataProvider = new ActiveDataProvider();
            $dataProvider->query = Proposal::find()->where(['id' => 0]);
        }

        return $this->render('index', [
            'organization' => $organization,
            'dataProvider' => $dataProvider
        ]);
    }
}