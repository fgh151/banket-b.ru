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
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class BattleController extends Controller
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider();
        /** @var Organization $organization */
        $organization = Yii::$app->getUser()->getIdentity();
        if ($organization->state == Constants::ORGANIZATION_STATE_PAID) {
            $dataProvider->query = Proposal::find()
                ->where(['status' => Constants::PROPOSAL_STATUS_CREATED])
                ->andWhere([
                    'not in',
                    'id',
                    OrganizationProposalStatus::find()
                        ->where([
                            'organization_id' => $organization->getId(),
                            'status' => Constants::ORGANIZATION_PROPOSAL_STATUS_REJECT
                        ])
                        ->select('proposal_id')
                ]);
        } else {
            // Формируем запрос, который заведомо ничего не вернет

            $dataProvider->query = Proposal::find()->where(['id' => 0]);
        }

        return $this->render('index', [
            'organization' => $organization,
            'dataProvider' => $dataProvider
        ]);
    }
}