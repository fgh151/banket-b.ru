<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 23.07.18
 * Time: 13:09
 */

namespace app\user\controllers;

use app\admin\components\ProposalFindOneTrait;
use app\common\components\Push;
use app\common\models\Cost;
use app\common\models\KnownProposal;
use app\common\models\Message;
use app\common\models\Organization;
use app\common\models\ReadMessage;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ConversationController extends Controller
{
    use ProposalFindOneTrait;

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
     * @param $proposalId
     *
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     * @throws \Throwable
     */
    public function actionIndex($proposalId)
    {
        $proposal = $this->findModel($proposalId);
        if ($proposal->isActual() === false) {
            return $this->render('closed');
        }
        $cost = new Cost();
        $cost->cost = Yii::$app->formatter->asRubles($proposal->getMyMinCost());
        $cost->restaurant_id = \Yii::$app->getUser()->getId();
        $cost->proposal_id = $proposalId;

        $known = KnownProposal::find()->where([
            'proposal_id' => $proposalId,
            'organization_id' => Yii::$app->getUser()->getId()
        ])->one();
        if ($known === null) {
            $known = new KnownProposal();
            $known->organization_id = Yii::$app->getUser()->getId();
            $known->proposal_id = $proposalId;
            $known->save();
        }

        $rm = ReadMessage::find()->where([
            'proposal_id' => $proposalId,
            'organization_id' => Yii::$app->getUser()->getId()
        ])->one();
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

//                $m = Message::getConversation($proposal->owner_id, $proposalId, $this->organizationId);


//                var_dump($m); die;

//                if (empty($m) || $m === null) {
                $message = new Message();

                $message->organization_id = $this->organizationId;
                $message->proposal_id = $proposalId;
                $message->user_id = $proposal->owner_id;
                $message->author_class = Organization::class;
                $message->message = 'Ресторан сделал ставку ' . $cost->cost . ' руб. / чел';
                $message->save();

//                } else {
                $push = Yii::$app->push;
                /** @var Organization $restaurant */
                $restaurant = Yii::$app->getUser()->getIdentity();
                $sendResult = $push->send(
                    $proposal->owner,
                    $restaurant->name, 'Для вашей заявки появилась новая ставка',
                    [
                        'proposalId' => $proposalId,
                        'organizationId' => Yii::$app->getUser()->getId(),
                        'cost' => $cost->cost
                    ]
                );
//                }
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
        $restaurant = Yii::$app->request->post('organization');
        $restaurant = Organization::findOne($restaurant);
        $message = Yii::$app->request->post('message');

        $notifyText = 'У Вас новое сообщение';

        if ($restaurant !== null && $message !== '') {
            $notifyText = $message;
        }

        $title = $restaurant ? 'Ответ от ресторана ' . $restaurant->name : 'У Вас новое сообщение';

        $proposal = $this->findModel($proposalId);
        /** @var Push $push */
        $push = Yii::$app->push;
        $sendResult = $push->send(
            $proposal->owner,
            $title, $notifyText,
            [
                'proposalId' => $proposalId,
                'organizationId' => Yii::$app->getUser()->getId()
            ]
        );
    }

}
