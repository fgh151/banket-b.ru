<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 15:15
 */

namespace app\user\controllers;

use app\common\models\Proposal;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class BattleController extends Controller
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
                    ]
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider();
        $dataProvider->query = Proposal::find()->where(['owner_id' => Yii::$app->getUser()->getId()]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
