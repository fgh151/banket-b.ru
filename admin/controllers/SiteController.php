<?php
namespace app\admin\controllers;

use app\common\models\District;
use app\common\models\LoginForm;
use app\common\models\Metro;
use app\common\models\MetroLine;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'district', 'metro'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        $db = Yii::$app->getDb();
        $sql = 'SELECT to_char(date, \'Day\') AS day, * FROM proposal ORDER BY day';
        $proposals = $db->createCommand($sql)->queryAll();

        $tmp = [];
        foreach ($proposals as $proposal) {
            $tmp[] = $proposal['day'];
        }
        $tmp = array_count_values($tmp);

        $byDay['Понедельник'] = isset($tmp['Monday   ']) ? $tmp['Monday   ']: 0;
        $byDay['Вторник'] = isset($tmp['Tuesday   ']) ? $tmp['Tuesday   ']: 0;
        $byDay['Среда'] = isset($tmp['Wednesday   ']) ? $tmp['Wednesday   ']: 0;
        $byDay['Четверг'] = isset($tmp['Thursday   ']) ? $tmp['Thursday   ']: 0;
        $byDay['Пятница'] = isset($tmp['Friday   ']) ? $tmp['Friday   ']: 0;
        $byDay['Суббота'] = isset($tmp['Saturday   ']) ? $tmp['Saturday   ']: 0;
        $byDay['Воскресенье'] = isset($tmp['Sunday   ']) ? $tmp['Sunday   ']: 0;


        return $this->render('index', [
            'byDay' => $byDay,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
//        Yii::$app->user->login(User::findOne(1));

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    public function actionDistrict()
    {
        $out = [];
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
        $out = [];
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
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
