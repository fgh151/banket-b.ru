<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 23.07.18
 * Time: 13:09
 */

namespace app\cabinet\controllers;


use app\admin\components\ProposalFindOneTrait;
use app\common\models\Message;
use app\common\models\Proposal;
use app\common\models\ReadMessage;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ConversationController extends Controller
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
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($proposalId)
    {
        $proposal = $this->findModel($proposalId);
        $model = $this->createBlankMessage($proposal);

        $messages = Message::getConversation($proposal->owner_id, $proposal->id, Yii::$app->getUser()->getId());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'saved');
        }

        return $this->render('index', [
            'model' => $model,
            'messages' => $messages,
            'proposal' => $proposal
        ]);
    }

    /**
     * @param $proposalId
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionValidateMessage($proposalId)
    {
        $proposal = $this->findModel($proposalId);
        $model = $this->createBlankMessage($proposal);
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return ['success' => false];
    }

    /**
     * @param $proposalId
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSendMessage($proposalId)
    {
        $proposal = $this->findModel($proposalId);
        $model = $this->createBlankMessage($proposal);
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post()) && $model->save()) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => true, 'element' => $this->renderAjax('_message', ['message' => $model])];
        }
        return ['success' => false];
    }

    /**
     * @param Proposal $proposal
     * @return Message
     */
    private function createBlankMessage(Proposal $proposal)
    {
        return new Message([
            'proposal_id' => $proposal->id,
            'user_id' => $proposal->owner_id,
            'cost' => $proposal->amount * $proposal->guests_count
        ]);
    }

    /**
     * @return string
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionNewMessages()
    {
        $proposalId = Yii::$app->request->post('proposalId');
        $lastMessage = Yii::$app->request->post('lastMessage');

        $proposal = $this->findModel($proposalId);
        $messages = Message::getConversationFromMessage($proposal->owner_id, $proposal->id, Yii::$app->getUser()->getId(), $lastMessage);
        if (count($messages) > 1) {

            // upsert не работает корректно
            $exist = ReadMessage::find()->where(['organization_id' => Yii::$app->getUser()->getId(), 'proposal_id' => $proposalId])->exists();
            if ($exist) {
                $rm = ReadMessage::find()->where(['organization_id' => Yii::$app->getUser()->getId(), 'proposal_id' => $proposalId])->one();
                $rm->count++;
                $rm->save();
            } else {
                $rm = new ReadMessage();
                $rm->count = 0;
                $rm->organization_id = Yii::$app->getUser()->getId();
                $rm->proposal_id = $proposalId;
                $rm->save();
            }
            array_shift($messages);
            return $this->renderAjax('_message_list', ['messages' => $messages]);
        }
        return '';
    }

}