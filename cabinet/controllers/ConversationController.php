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
use app\common\models\ReadMessage;
use Yii;
use yii\db\Expression;
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
        $model = new Message([
            'proposal_id' => $proposalId,
            'user_id' => $proposal->owner_id
        ]);

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
        $model = new Message([
            'proposal_id' => $proposalId,
            'user_id' => $proposal->owner_id
        ]);
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
        $model = new Message([
            'proposal_id' => $proposalId,
            'user_id' => $proposal->owner_id
        ]);
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post()) && $model->save()) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => true, 'element' => $this->renderAjax('_message', ['message' => $model])];
        }
        return ['success' => false];
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


            Yii::$app->db->createCommand()->upsert(ReadMessage::tableName(), [
                'proposal_id' => $proposalId,
                'organization_id' => Yii::$app->getUser()->getId(),
                'count' => 0
            ], [
                'count' => new Expression('count + 1')
            ])->execute();


            array_shift($messages);
            return $this->renderAjax('_message_list', ['messages' => $messages]);
        }
        return '';
    }

}