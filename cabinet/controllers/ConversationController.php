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
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ConversationController extends Controller
{
    use ProposalFindOneTrait;

    /**
     * @param $proposalId
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($proposalId)
    {
        $proposal = $this->findModel($proposalId);
        $model = new Message(['proposal_id' => $proposalId]);

        $messages = Message::getConversation($proposalId, Yii::$app->getUser()->getId());

//        $model->author_class = MobileUser::class;
//        $model->message = 'NOOOO )';
//        $model->save(); die;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'saved');
        }

        return $this->render('index', [
            'model' => $model,
            'messages' => $messages,
            'proposal' => $proposal
        ]);
    }

    public function actionValidateMessage($proposalId)
    {
        $model = new Message(['proposal_id' => $proposalId]);
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return ['success' => false];
    }

    public function actionSendMessage($proposalId)
    {
        $model = new Message(['proposal_id' => $proposalId]);
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
     */
    public function actionNewMessages()
    {
        $proposalId = Yii::$app->request->post('proposalId');
        $lastMessage = Yii::$app->request->post('lastMessage');

        $this->findModel($proposalId);
        $messages = Message::getConversationFromMessage($proposalId, Yii::$app->getUser()->getId(), $lastMessage);
        if (count($messages) > 1) {
            array_shift($messages);
            return $this->renderAjax('_message_list', ['messages' => $messages]);
        }
        return '';
    }

}