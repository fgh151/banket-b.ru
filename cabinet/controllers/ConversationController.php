<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 23.07.18
 * Time: 13:09
 */

namespace app\cabinet\controllers;

use app\admin\components\ProposalFindOneTrait;
use app\cabinet\components\CabinetController;
use app\common\components\Push;
use app\common\models\Cost;
use app\common\models\KnownProposal;
use app\common\models\ReadMessage;
use Yii;
use yii\filters\AccessControl;

class ConversationController extends CabinetController
{
    use ProposalFindOneTrait, CheckPayTrait;

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
        $this->throwIfNotPay('state');
        return parent::beforeAction($action);
    }

    /**
     * @param $proposalId
     *
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($proposalId)
    {
        $proposal = $this->findModel($proposalId);
        $cost = new Cost();
        $cost->cost = Yii::$app->formatter->asRubles($proposal->getMyMinCost());
        $cost->restaurant_id = \Yii::$app->getUser()->getId();
        $cost->proposal_id = $proposalId;

        $known = KnownProposal::find()->where(['proposal_id' => $proposalId, 'organization_id' => Yii::$app->getUser()->getId()])->one();
        if ($known === null) {
            $known = new KnownProposal();
            $known->organization_id = Yii::$app->getUser()->getId();
            $known->proposal_id = $proposalId;
            $known->save();
        }

        $rm = ReadMessage::find()->where(['proposal_id' => $proposalId, 'organization_id' => Yii::$app->getUser()->getId()])->one();
        if ($rm !== null) {
            $rm->count = $rm->user_messages;
            $rm->save();
        } else {
            $rm = new ReadMessage();
            $rm->organization_id = Yii::$app->getUser()->getId();
            $rm->proposal_id = $proposalId;
            $rm->count = $rm->user_messages = 0;
            $rm->save();
        }

        if ($cost->load(\Yii::$app->request->post())) {
            $save = $cost->save();
            if ($save) {
                $push = Yii::$app->push;
                $sendResult = $push->send(
                    $proposal->owner,
                    'У Вас новое сообщение', 'Для вашей заявки появилась новая ставка',
                    [
                        'proposalId' => $proposalId,
                        'organizationId' => Yii::$app->getUser()->getId()
                    ]
                );
            }

            if (\Yii::$app->request->isAjax) {
                return $this->asJson(['success' => $save]);
            }
        }

        return $this->render('index', [
            'proposal' => $proposal,
            'model' => $cost
        ]);
    }

    public function actionPush($proposalId)
    {

        $proposal = $this->findModel($proposalId);
        /** @var Push $push */
        $push = Yii::$app->push;
        $sendResult = $push->send(
            $proposal->owner,
            'У Вас новое сообщение', 'У Вас новое сообщение',
            [
                'proposalId' => $proposalId,
                'organizationId' => Yii::$app->getUser()->getId()
            ]
        );
    }

}