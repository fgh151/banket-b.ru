<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 13:31
 */

namespace app\cabinet\controllers;


use app\common\models\Promo;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class PromoController extends Controller
{
    use CheckPayTrait;

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
     * @param $action
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->throwIfNotPay('state_promo');
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Promo::find()
                ->where(['organization_id' => \Yii::$app->getUser()->getId()])
                ->andFilterWhere(['<=', 'start', date('Y-M-d')])
                ->andFilterWhere(['>=', 'end', date('Y-M-d')])
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);

    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Promo();
        $model->organization_id = \Yii::$app->getUser()->getId();

        if ($model->load(\Yii::$app->request->post())) {
            $this->saveImage($model);
            $model->save();
            return $this->redirect('index');
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->organization_id !== \Yii::$app->getUser()->getId()) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($model->load(\Yii::$app->request->post())) {
            $this->saveImage($model);
            $model->save();
            return $this->redirect('index');
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * @param Promo $model
     *
     * @throws \yii\base\Exception
     */
    protected function saveImage(Promo $model)
    {
        $model->file_input = UploadedFile::getInstance($model, 'file_input');
        if ($model->file_input && $model->validate()) {
            $relativePath = 'promo/' . $model->organization_id . '/' . time() . '/';
            $path = \Yii::getAlias('@app/web/' . $relativePath);
            FileHelper::createDirectory($path);
            $file = $path . $model->file_input->baseName . '.' . $model->file_input->extension;
            $model->file_input->saveAs($file);
            $model->image = $relativePath . $model->file_input->baseName . '.' . $model->file_input->extension;
        }
    }

    /**
     * @param $id
     *
     * @return Promo|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Promo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}