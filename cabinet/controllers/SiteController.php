<?php /** @noinspection MissedViewInspection */

namespace app\cabinet\controllers;

use app\cabinet\components\CabinetController;
use app\cabinet\models\ContactForm;
use app\cabinet\models\LoginForm;
use app\cabinet\models\PasswordResetRequestForm;
use app\cabinet\models\ResetPasswordForm;
use app\cabinet\models\SignupForm;
use app\common\components\Model;
use app\common\models\District;
use app\common\models\Metro;
use app\common\models\MetroLine;
use app\common\models\Organization;
use app\common\models\OrganizationImage;
use app\common\models\OrganizationLinkMetro;
use app\common\models\Proposal;
use app\common\models\RestaurantHall;
use app\common\models\RestaurantParams;
use app\common\models\Upload;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends CabinetController
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
                        'actions' => ['signup', 'test'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'request-password-reset',
                            'reset-password',
                            'about',
                            'district',
                            'metro'
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @param null $proposals
     *
     * @param null $month
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionIndex($proposals = null, $month = null)
    {
        /** @var Organization $organization */
        $organization = Yii::$app->getUser()->getIdentity();

        if ($month) {
            $firstDay = date('Y-m-d') . ' first day of last month';
            $lastDay = date('Y-m-d') . ' last day of last month';

            $createdAtCriteria = [
                'between', 'created_at', date_create($firstDay)->getTimestamp(), date_create($lastDay)->getTimestamp()
            ];
        }

        $proposalsCount = Proposal::find();
        if ($proposals === 'my') {
            $proposalsCount->where(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $proposalsCount->andFilterWhere($createdAtCriteria);
        }
        $proposalsCount = $proposalsCount->count();
        $onePercent = $proposalsCount / 10;

        $criteriaSql = '';
        if ($proposals === 'my') {
            $criteriaSql = 'WHERE city_id = ' . $organization->city_id;
        }
        if ($month) {
            $criteriaSql .= $proposals === 'my' ? ' AND ' : '';

            $criteriaSql .= 'WHERE  created_at BETWEEN  ' . date_create($firstDay)->getTimestamp() . ' AND ' . date_create($lastDay)->getTimestamp();
        }


        $this->throwIfNotPay('state_statistic');

        $db = Yii::$app->getDb();
        $sql = 'SELECT to_char(date, \'Day\') AS day, * FROM proposal ' . $criteriaSql . ' ORDER BY day';
        $proposalsAr = $db->createCommand($sql)->queryAll();

        $tmp = [];
        foreach ($proposalsAr as $proposal) {
            $tmp[] = $proposal['day'];
        }
        $tmp = array_count_values($tmp);

        $byDay['Понедельник'] = (isset($tmp['Monday   ']) ? $tmp['Monday   '] : 0) + Yii::$app->params['chart']['byDay']['Понедельник'];
        $byDay['Вторник'] = (isset($tmp['Tuesday   ']) ? $tmp['Tuesday   '] : 0) + Yii::$app->params['chart']['byDay']['Вторник'];
        $byDay['Среда'] = (isset($tmp['Wednesday   ']) ? $tmp['Wednesday   '] : 0) + Yii::$app->params['chart']['byDay']['Среда'];
        $byDay['Четверг'] = (isset($tmp['Thursday   ']) ? $tmp['Thursday   '] : 0) + Yii::$app->params['chart']['byDay']['Четверг'];
        $byDay['Пятница'] = (isset($tmp['Friday   ']) ? $tmp['Friday   '] : 0) + Yii::$app->params['chart']['byDay']['Пятница'];
        $byDay['Суббота'] = (isset($tmp['Saturday   ']) ? $tmp['Saturday   '] : 0) + Yii::$app->params['chart']['byDay']['Суббота'];
        $byDay['Воскресенье'] = (isset($tmp['Sunday   ']) ? $tmp['Sunday   '] : 0) + Yii::$app->params['chart']['byDay']['Воскресенье'];


        array_walk($byDay, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $sql = 'SELECT to_char(date, \'Month\') AS month, * FROM proposal ' . $criteriaSql . ' ORDER BY month';
        $proposalsAr = $db->createCommand($sql)->queryAll();

        $tmp = [];
        foreach ($proposalsAr as $proposal) {
            $tmp[] = str_replace(
                ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                trim($proposal['month'])
            );
        }
        $byMonth = array_count_values($tmp);
        $byMonth = Yii::$app->params['chart']['byMonth'] + $byMonth;
        array_walk($byMonth, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });


        $byPrice = [];
        $proposalsByPrice = Proposal::find()->select(['amount']);

        if ($proposals === 'my') {
            $proposalsByPrice->where(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $proposalsByPrice->andFilterWhere($createdAtCriteria);
        }
        $proposalsByPrice = $proposalsByPrice->asArray()->all();
        foreach ($proposalsByPrice as $p) {
            $amount = $p['amount'];
            $byPrice[$amount] = isset($byPrice[$amount]) ? $byPrice[$amount] + 1 : 1;
        }
        $byPrice = Yii::$app->params['chart']['byPrice'] + $byPrice;
        ksort($byPrice);
        array_walk($byPrice, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $byPeoples = [];
        $proposalsByPeoples = Proposal::find()->select(['guests_count']);
        if ($proposals === 'my') {
            $proposalsByPeoples->where(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $proposalsByPeoples->andFilterWhere($createdAtCriteria);
        }
        $proposalsByPeoples = $proposalsByPeoples->asArray()->all();
        foreach ($proposalsByPeoples as $p) {
            $count = $p['guests_count'];
            $byPeoples[$count] = isset($byPeoples[$count]) ? $byPeoples[$count] + 1 : 1;
        }
        $byPeoples = Yii::$app->params['chart']['byPeoples'] + $byPeoples;
        ksort($byPeoples);
        array_walk($byPrice, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $proposalsCount = Proposal::find();
        if ($proposals === 'my') {
            $proposalsCount->where(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $proposalsCount->andFilterWhere($createdAtCriteria);
        }
        $proposalsCount = $proposalsCount->count();

        $hall = Proposal::find()->where(['hall' => true]);
        if ($proposals === 'my') {
            $hall->andWhere(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $hall->andFilterWhere($createdAtCriteria);
        }
        $hall = $hall->count();
        $byHall = ['Нужен' => $hall, 'Не нужен' => $proposalsCount - $hall];

        array_walk($byHall, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $dance = Proposal::find()->where(['dance' => true]);
        if ($proposals === 'my') {
            $dance->andWhere(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $dance->andFilterWhere($createdAtCriteria);
        }
        $dance = $dance->count();
        $byDance = ['Нужен' => $dance, 'Не нужен' => $proposalsCount - $dance];
        array_walk($byDance, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $alko = Proposal::find()->where(['own_alcohol' => true]);
        if ($proposals === 'my') {
            $alko->andWhere(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $alko->andFilterWhere($createdAtCriteria);
        }
        $alko = $alko->count();
        $byAlko = ['Нужен' => $alko, 'Не нужен' => $proposalsCount - $alko];
        array_walk($byAlko, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        $parking = Proposal::find()->where(['parking' => true]);
        if ($proposals === 'my') {
            $parking->andWhere(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $parking->andFilterWhere($createdAtCriteria);
        }
        $parking = $parking->count();
        $byParking = ['Нужна' => $parking, 'Не нужна' => $proposalsCount - $parking];
        array_walk($byParking, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });


        $kitchen = Proposal::find()->select(['types']);
        if ($proposals === 'my') {
            $kitchen->where(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $kitchen->andFilterWhere($createdAtCriteria);
        }
//        $kitchen = $kitchen->asArray()->all();

        $type = Proposal::find()->select(['event_type']);
        if ($proposals === 'my') {
            $type->where(['city_id' => $organization->city_id]);
        }
        if ($month) {
            $type->andFilterWhere($createdAtCriteria);
        }
        $type = $type->asArray()->all();
        $byTypes = [];
        foreach ($type as $item) {
            $types = $item['event_type'];
            $byTypes[$types] = isset($byTypes[$types]) ? $byTypes[$types] + 1 : 1;
        }
        ksort($byTypes);
        array_walk($byTypes, function (&$val, $key) use ($onePercent) {
            $val = round($val * $onePercent, 2);
        });

        return $this->render('index', [
            'byDay' => $byDay,
            'byPrice' => $byPrice,
            'byPeoples' => $byPeoples,
            'byHall' => $byHall,
            'byDance' => $byDance,
            'byAlko' => $byAlko,
            'byParking' => $byParking,
            'byTypes' => $byTypes,
            'byMonth' => $byMonth,
            'organization' => $organization
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
            return $this->redirect(['battle/index']);
        }

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
            return $this->redirect(['battle/index']);
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
        $modelParams = new RestaurantParams();
        $halls = [new RestaurantHall(['scenario' => RestaurantHall::SCENARIO_REGISTER])];
        $metro = [new OrganizationLinkMetro()];

        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            if ($this->checkRecaptcha()) {
                if ($user = $model->signup()) {
                    $this->uploadOrganizationImage($model, $user);

                    if ($modelParams->load($post)) {
                        $modelParams->organization_id = $user->id;
                        $modelParams->save();
                    }

                    /** @var RestaurantHall[] $halls */
                    $halls = Model::createMultiple(RestaurantHall::class);
                    Model::loadMultiple($halls, Yii::$app->request->post());
                    foreach ($halls as $hall) {
                        $hall->restaurant_id = $user->id;
                        $hall->save();
                    }

                    /** @var OrganizationLinkMetro[] $metros */
                    $metros = Model::createMultiple(OrganizationLinkMetro::class);
                    Model::loadMultiple($metros, Yii::$app->request->post());
                    foreach ($metros as $station) {
                        $station->organization_id = $user->id;
                        $station->save();
                    }

                    if (Yii::$app->getUser()->login($user)) {
                        Yii::$app->homeUrl = Url::to(['/battle/index']);
                        return $this->goHome();
                    }
                }
            } else {
                $model->addError('title', 'Необходимо указать что вы не робот');
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'modelParams' => $modelParams,
            'halls' => (empty($halls) ? [new RestaurantHall()] : $halls),
            'metro' => (empty($metro) ? [new OrganizationLinkMetro()] : $metro),
        ]);
    }

    private function checkRecaptcha()
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => '6LcFr6QUAAAAAM6IFLvubkKGYViVaFIWkSng8RyN',
            'response' => Yii::$app->request->post('g-recaptcha-response')
        ];
        $query = http_build_query($data);
        $options = [
            'http' => [
                'method' => 'POST',
                'content' => $query,
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: " . strlen($query) . "\r\n" .
                    "User-Agent:banket-b.server/1.0\r\n",
            ]
        ];
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);

        return $captcha_success->success;
    }

    /**
     * @param SignupForm $model
     * @param Organization $organization
     * @throws \yii\base\Exception
     */
    protected function uploadOrganizationImage(SignupForm $model, Organization $organization)
    {
        $files = UploadedFile::getInstances($model, 'image_field');


        foreach ($files as $file) {


            /** @noinspection PhpUndefinedFieldInspection */
            $path = '/web/upload' . DIRECTORY_SEPARATOR . 'organization' . DIRECTORY_SEPARATOR . $organization->id;

            $path = \Yii::getAlias('@cabinet') . $path;

            FileHelper::createDirectory($path);

            $fileBaseName = substr(md5(microtime() . rand(0, 9999)), 0, 8);
            $fileName = $fileBaseName . '_' . $this->owner->id . '.' . $file->extension;

            $file->saveAs($path . '/' . $fileName);
            $upload = new Upload();
            $upload->fsFileName = $fileName;
            $upload->save();

            $storage = new OrganizationImage();
            $storage->organization_id = $organization->id;
            $storage->upload_id = $upload->id;
            $storage->save();
        }
    }


    public function actionDistrict()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $city_id = $parents[0];
                $out = District::find()
                    ->select('id as id, title as name')
                    ->where(['city_id' => $city_id])
                    ->asArray()
                    ->all();
                return Json::encode(['output' => $out, 'selected' => '']);
            }
        }

        return Json::encode(['output' => '', 'selected' => '']);
    }


    public function actionMetro()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $city_id = $parents[0];
                $out = Metro::find()
                    ->select('id as id, title as name')
                    ->where([
                        'in',
                        'line_id',
                        MetroLine::find()->where(['city_id' => $city_id])->select('id')
                    ])
                    ->orderBy('title')
                    ->asArray()
                    ->all();
                return Json::encode(['output' => $out, 'selected' => '']);
            }
        }

        return Json::encode(['output' => '', 'selected' => '']);
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

    public function actionUnsubscribe()
    {

        return $this->render('unsubscribe');
    }

//    public function actionTest()
//    {
//        Yii::$app->getUser()->login(Organization::findOne(125));
//    }
}
