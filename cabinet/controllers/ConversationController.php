<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 23.07.18
 * Time: 13:09
 */

namespace app\cabinet\controllers;

use app\admin\components\ProposalFindOneTrait;
use app\common\models\Cost;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

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
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($proposalId)
    {
        $proposal = $this->findModel($proposalId);
        $cost = new Cost();

        $cost->cost = Yii::$app->formatter->asRubles($proposal->getMyMinCost() ?: $proposal->amount);
        $cost->restaurant_id = \Yii::$app->getUser()->getId();
        $cost->proposal_id = $proposalId;

        if ($cost->load(\Yii::$app->request->post()) && $cost->save()) {
            if (\Yii::$app->request->isAjax) {
                return $this->asJson(['success' => true]);
            }
        }

        return $this->render('index', [
            'proposal' => $proposal,
            'model' => $cost
        ]);
    }

}