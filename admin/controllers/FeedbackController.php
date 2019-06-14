<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-06-05
 * Time: 15:14
 */

namespace app\admin\controllers;


use app\common\models\Feedback;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class FeedbackController extends Controller
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => Feedback::find(), 'sort' => ['defaultOrder' => ['id' => SORT_DESC]]]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
}