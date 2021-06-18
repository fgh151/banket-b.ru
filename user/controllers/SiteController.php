<?php /** @noinspection MissedViewInspection */

namespace app\user\controllers;

use app\cabinet\models\LoginForm;
use app\cabinet\models\PasswordResetRequestForm;
use app\cabinet\models\ResetPasswordForm;
use app\common\components\OauthClient;
use app\common\models\Blog;
use app\user\models\ProposalForm;
use Yii;
use yii\authclient\BaseOAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function oAuthSuccess(BaseOAuth $client)
    {
        $user = OauthClient::getUserFromRemote($client);
        Yii::$app->getUser()->login($user, Yii::$app->params['durationAuth']);
        echo $user->name;
    }

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
                        'actions' => [
                            'signup',
                            'create',
                            'login',
                            'auth',
                            'index',
                            'request-password-reset',
                            'reset-password',
                        ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['*'],
                        'allow' => false,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
                'redirectView' => ProposalForm::hasDataInStore() ? '@app/views/oauthRedirectCreate.php' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     */
    public function actionIndex()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(['battle/index']);
        }

        $this->layout = 'landing';

        $model = new ProposalForm();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->store()) {
            return $this->redirect(['/site/create']);
        }

        $blogItems = Blog::find()->limit(4)->orderBy(['id' => SORT_DESC])->all();

        return $this->render('index', [
            'model' => $model,
            'blogItems' => $blogItems,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['site/index']);
        }

        $this->layout = 'landing';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['battle/index']);
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('index');
    }

    public function actionCreate()
    {
        $model = ProposalForm::restoreOrCreate();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {

            ProposalForm::clearStore();
            Yii::$app->getSession()->setFlash('success', 'Банкет создан!');
            return $this->redirect(['/site/index']);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * @param $action
     *
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            Yii::$app->homeUrl = Url::to('about');
        }
        return parent::beforeAction($action);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'landing';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте вашу почту.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Мы не можем сбросить пароль.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionResetPassword($token)
    {
        $model = new ResetPasswordForm($token);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен');

            return $this->redirect(['site/index']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
