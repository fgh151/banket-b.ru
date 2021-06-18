<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 14:24
 */

namespace app\user\controllers;


use app\common\models\MobileUser;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class UserController extends Controller
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
     * @throws Throwable
     */
    public function actionEdit()
    {
        /** @var MobileUser $model */
        $model = Yii::$app->getUser()->getIdentity();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->password !== '') {
                $model->setPassword($model->password);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Данные успешно сохранены');
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

}
