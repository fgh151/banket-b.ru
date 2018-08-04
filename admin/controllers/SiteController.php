<?php
namespace app\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\common\models\LoginForm;

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
                        'actions' => ['logout', 'index'],
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

        $sql = 'SELECT date_part(\'hour\', time) AS hour, * FROM proposal ORDER BY hour';
        $proposals = $db->createCommand($sql)->queryAll();
        foreach ($proposals as $proposal) {
            $tmp[] = $proposal['hour'];
        }
        $tmp = array_count_values($tmp);
        $hours = array_fill(1, 24, 0);
        $byHours = $tmp+$hours;
        ksort($byHours);

        return $this->render('index', [
            'byDay' => $byDay,
            'byHours' => $byHours
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
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
