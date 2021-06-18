<?php


namespace app\user\controllers;


use app\common\models\Blog;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class BlogController extends \yii\web\Controller
{
    public $layout = 'landing';

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Blog::find()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($alias)
    {
        $model = Blog::find()->where(['alias' => $alias])->one();

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

}
