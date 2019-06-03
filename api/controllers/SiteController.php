<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 22.08.2018
 * Time: 18:30
 */

namespace app\api\controllers;


use Yii;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function actionError()
    {
        if (Yii::$app->getErrorHandler()->exception === null) {
            Yii::$app->getErrorHandler()->exception = new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return Yii::$app->getErrorHandler()->exception;
    }
}