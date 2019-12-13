<?php

namespace app\admin\controllers;

use app\admin\components\ProposalFindOneTrait;
use app\common\components\Constants;
use app\common\models\Message;
use app\common\models\Organization;
use app\common\models\Proposal;
use app\common\models\ProposalSearch;
use Kreait\Firebase\Database;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProposalController implements the CRUD actions for Proposal model.
 */
class ProposalController extends Controller
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
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Proposal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProposalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false, true);
        $dataProvider->pagination->pageSize = 15;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proposal model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Proposal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Proposal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Proposal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateRr()
    {
        $model = new Proposal(['owner_id' => 45, 'type' => 2]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Proposal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Proposal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionClose($id)
    {
        $proposal = Proposal::findOne($id);
        $proposal->status = Constants::PROPOSAL_STATUS_CLOSED;
        $proposal->save();
        return $this->redirect(['proposal/index']);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionAnswers($id)
    {
        $proposal = Proposal::findOne($id);
        $answers = [];

        $path = 'proposal_2/u_' . Yii::$app->params['restorateUserId'] . '/p_' . $id;
        /** @var Database $database */
        $database = Yii::$app->firebase->getDatabase();
        $reference = $database->getReference($path);

        $response = $reference->getValue();
        foreach ($response as $oId => $messages) {
            foreach ($messages as $firbaseMessage) {
                $message = Message::decode($firbaseMessage);
                if ($message->author_class == Organization::class) {
                    $answers[] = $message;
                }
            }
        }

        return $this->render('answers', [
            'proposal' => $proposal,
            'answers' => $answers
        ]);
    }

    public function actionAnswer($proposalId, $organizationId, $userId)
    {
        $message = new Message();
        $message->proposal_id = $proposalId;
        $message->organization_id = $organizationId;
        $message->user_id = $userId;
        if ($message->load(Yii::$app->request->post())) {
            $message->save();
        }

        return $this->render('answer_form', [
            'model' => $message
        ]);

    }
}
