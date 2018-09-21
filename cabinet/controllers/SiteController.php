<?php
namespace app\cabinet\controllers;

use app\cabinet\models\ContactForm;
use app\cabinet\models\LoginForm;
use app\cabinet\models\PasswordResetRequestForm;
use app\cabinet\models\ResetPasswordForm;
use app\cabinet\models\SignupForm;
use app\common\models\Organization;
use app\common\models\Proposal;
use Yii;
use yii\base\InvalidArgumentException;
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
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['request-password-reset', 'reset-password', 'about'],
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
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @param null $proposals
     *
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionIndex($proposals = null)
    {
        /** @var Organization $organization */
        $organization = Yii::$app->getUser()->getIdentity();

        $proposalsCount = Proposal::find();
        if ($proposals === 'my') {
            $proposalsCount->where(['city_id' => $organization->city_id]);
        }
        $proposalsCount->count();
        $onePercent = $proposalsCount / 10;

        $criteriaSql = '';
        if ($proposals === 'my') {
            $criteriaSql = 'WHERE city_id = '.$organization->city_id;
        }


        $this->throwIfNotPay('state_statistic');

        $db = Yii::$app->getDb();
        $sql = 'SELECT to_char(date, \'Day\') AS day, * FROM proposal '.$criteriaSql.' ORDER BY day';
        $proposalsAr = $db->createCommand($sql)->queryAll();

        $tmp = [];
        foreach ($proposalsAr as $proposal) {
            $tmp[] = $proposal['day'];
        }
        $tmp = array_count_values($tmp);

        $byDay['Понедельник'] = (isset($tmp['Monday   ']) ? $tmp['Monday   ']: 0) + Yii::$app->params['chart']['byDay']['Понедельник'];
        $byDay['Вторник'] = (isset($tmp['Tuesday   ']) ? $tmp['Tuesday   ']: 0) + Yii::$app->params['chart']['byDay']['Вторник'];
        $byDay['Среда'] = (isset($tmp['Wednesday   ']) ? $tmp['Wednesday   ']: 0) + Yii::$app->params['chart']['byDay']['Среда'];
        $byDay['Четверг'] = (isset($tmp['Thursday   ']) ? $tmp['Thursday   ']: 0) + Yii::$app->params['chart']['byDay']['Четверг'];
        $byDay['Пятница'] = (isset($tmp['Friday   ']) ? $tmp['Friday   ']: 0) + Yii::$app->params['chart']['byDay']['Пятница'];
        $byDay['Суббота'] = (isset($tmp['Saturday   ']) ? $tmp['Saturday   ']: 0) + Yii::$app->params['chart']['byDay']['Суббота'];
        $byDay['Воскресенье'] = (isset($tmp['Sunday   ']) ? $tmp['Sunday   ']: 0) + Yii::$app->params['chart']['byDay']['Воскресенье'];


        array_walk($byDay, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });




        $sql = 'SELECT date_part(\'hour\', time) AS hour, * FROM proposal '.$criteriaSql.' ORDER BY hour';
        $proposalsAr = $db->createCommand($sql)->queryAll();
        foreach ($proposalsAr as $proposal) {
            $tmp[] = $proposal['hour'];
        }
        $tmp = array_count_values($tmp);
        $hours = Yii::$app->params['chart']['byHours'];
        $byHours = $tmp+$hours;
        ksort($byHours);

        array_walk($byHours, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });


        $sql = 'SELECT to_char(date, \'Month\') AS month, * FROM proposal '.$criteriaSql.' ORDER BY month';
        $proposalsAr = $db->createCommand($sql)->queryAll();

        $tmp = [];
        foreach ($proposalsAr as $proposal) {
            $tmp[] = str_replace(
                ['January','February','March','April','May','June','July','August','September','October','November', 'December'],
                ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь', 'Декабрь'],
                trim($proposal['month'])
            );
        }
        $byMonth = array_count_values($tmp);
        $byMonth =  Yii::$app->params['chart']['byMonth'] + $byMonth;
        array_walk($byMonth, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });





        $byPrice = [];
        $proposalsByPrice = Proposal::find()->select(['amount']);

        if ($proposals === 'my') {
            $proposalsByPrice->where(['city_id' => $organization->city_id]);
        }
        $proposalsByPrice = $proposalsByPrice->asArray()->all();
        foreach ($proposalsByPrice as $p) {
            $amount = $p['amount'];
            $byPrice[$amount] = isset($byPrice[$amount]) ? $byPrice[$amount] +1: 1;
        }
        $byPrice = Yii::$app->params['chart']['byPrice'] + $byPrice;
        ksort($byPrice);
        array_walk($byPrice, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $byPeoples =[];
        $proposalsByPrice = Proposal::find()->select(['guests_count']);
        if ($proposals === 'my') {
            $proposalsByPrice->where(['city_id' => $organization->city_id]);
        }
        $proposalsByPrice = $proposalsByPrice->asArray()->all();
        foreach ($proposalsByPrice as $p) {
            $count = $p['guests_count'];
            $byPeoples[$count] = isset($byPeoples[$count]) ? $byPeoples[$count] +1: 1;
        }
        $byPeoples =  Yii::$app->params['chart']['byPeoples'] + $byPeoples;
        ksort($byPeoples);
        array_walk($byPrice, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $proposalsCount = Proposal::find();
        if ($proposals === 'my') {
            $proposalsCount->where(['city_id' => $organization->city_id]);
        }
        $proposalsCount = $proposalsCount->count();

        $hall = Proposal::find()->where(['hall' => true]);
        if ($proposals === 'my') {
            $hall->andWhere(['city_id' => $organization->city_id]);
        }
        $hall = $hall->count();
        $byHall = ['Нужен' => $hall, 'Не нужен' => $proposalsCount-$hall];

        array_walk($byHall, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $dance = Proposal::find()->where(['dance' => true]);
        if ($proposals === 'my') {
            $dance->andWhere(['city_id' => $organization->city_id]);
        }
        $dance = $dance->count();
        $byDance = ['Нужен' => $dance, 'Не нужен' => $proposalsCount-$dance];
        array_walk($byDance, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $alko = Proposal::find()->where(['own_alcohol' => true]);
        if ($proposals === 'my') {
            $alko->andWhere(['city_id' => $organization->city_id]);
        }
        $alko = $alko->count();
        $byAlko = ['Нужен' => $alko, 'Не нужен' => $proposalsCount-$alko];
        array_walk($byAlko, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $parking = Proposal::find()->where(['parking' => true]);
        if ($proposals === 'my') {
            $parking->andWhere(['city_id' => $organization->city_id]);
        }
        $parking = $parking->count();
        $byParking = ['Нужна' => $parking, 'Не нужна' => $proposalsCount-$parking];
        array_walk($byParking, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });


        $kitchen = Proposal::find()->select(['cuisine']);
        if ($proposals === 'my') {
            $kitchen->where(['city_id' => $organization->city_id]);
        }
        $kitchen = $kitchen->asArray()->all();

        $byCuisine =[];
        foreach ($kitchen as $item) {
            $cuisine = $item['cuisine'];
            $byCuisine[$cuisine] = isset($byCuisine[$cuisine]) ? $byCuisine[$cuisine]+1:1;
        }
        ksort($byCuisine);
        array_walk($byCuisine, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $type = Proposal::find()->select(['event_type']);
        if ($proposals === 'my') {
            $type->where(['city_id' => $organization->city_id]);
        }
        $type = $type->asArray()->all();
        $byTypes =[];
        foreach ($type as $item) {
            $cuisine = $item['event_type'];
            $byTypes[$cuisine] = isset($byTypes[$cuisine]) ? $byTypes[$cuisine]+1:1;
        }
        ksort($byTypes);
        array_walk($byTypes, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });


        return $this->render('index', [
            'byDay' => $byDay,
            'byHours' => $byHours,
            'byPrice' => $byPrice,
            'byPeoples' => $byPeoples,
            'byHall' => $byHall,
            'byDance' => $byDance,
            'byAlko' => $byAlko,
            'byParking' => $byParking,
            'byCuisine' => $byCuisine,
            'byTypes' => $byTypes,
            'byMonth' => $byMonth
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {

//        $u = Organization::findOne(1);
//        Yii::$app->user->login($u);


        if (!Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->homeUrl = Url::to('index');
            return $this->goBack();
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

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect('site/index');
        }
        $this->layout = 'blank';
        return $this->render('about');
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
     * Signs user up.
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->homeUrl = Url::to('/site/index');
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionRequestPasswordReset()
    {
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
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
