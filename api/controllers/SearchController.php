<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 08.10.2018
 * Time: 16:35
 */

namespace app\api\controllers;


use app\api\models\OrganizationSearch;
use Yii;
use yii\rest\Controller;

class SearchController extends Controller
{
    public function actionIndex()
    {

        $searchModel = new OrganizationSearch();
        return $searchModel->search(Yii::$app->request->queryParams);

    }

}