<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 14:24
 */

namespace app\cabinet\controllers;


use app\common\models\Organization;
use yii\web\Controller;

class UserController extends Controller
{

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionEdit()
    {
        /** @var Organization $model */
        $model = \Yii::$app->getUser()->getIdentity();

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->password !== '') {
                $model->setPassword($model->password);
            }
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Данные успешно сохранены');
            }
        }

        return $this->render('edit', ['model' => $model]);
    }

}