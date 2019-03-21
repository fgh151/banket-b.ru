<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 26.07.18
 * Time: 9:49
 */

namespace app\api\controllers;


use app\api\models\Organization;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class OrganizationController extends Controller
{

    /**
     * @param $id
     *
     * @return Organization
     * @throws NotFoundHttpException
     */
    public function actionGet($id)
    {
        return $this->findModel($id);
    }

    /**
     * Finds the Organization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Organization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organization::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}