<?php

namespace app\admin\controllers;

use app\common\components\Model;
use app\common\models\District;
use app\common\models\Metro;
use app\common\models\Organization;
use app\common\models\OrganizationLinkMetro;
use app\common\models\OrganizationSearch;
use app\common\models\RestaurantHall;
use app\common\models\RestaurantLinkCuisine;
use app\common\models\RestaurantParams;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrganizationController implements the CRUD actions for Organization model.
 */
class OrganizationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Organization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organization model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Organization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Organization();

        if ($model->load(Yii::$app->request->post())) {
            $model->generateAuthKey();
            $model->created_at = time();
            $model->updated_at = time();
            $model->setPassword($model->password);
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Organization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $params = $model->params;

        if ($model->load(Yii::$app->request->post())) {

            if ($model->password !== '') {
                $model->setPassword($model->password);
            }
            if ($model->save()) {

                $params->load(Yii::$app->request->post());
                $params->save();


                if (!empty($model->linkActivity)) {
                    $model->linkActivity[0]->save();
                }

                OrganizationLinkMetro::deleteAll(['organization_id' => $model->id]);
                /** @var OrganizationLinkMetro[] $metros */
                $metros = Model::createMultiple(OrganizationLinkMetro::class);
                Model::loadMultiple($metros, Yii::$app->request->post());
                foreach ($metros as $station) {
                    $station->organization_id = $model->id;
                    $station->save();
                }


                RestaurantHall::deleteAll(['restaurant_id' => $model->id]);

                /** @var RestaurantHall[] $halls */
                $halls = Model::createMultiple(RestaurantHall::class);
                Model::loadMultiple($halls, Yii::$app->request->post());
                foreach ($halls as $hall) {
                    $hall->restaurant_id = $model->id;
                    $hall->save();
                }


                RestaurantLinkCuisine::deleteAll(['restaurant_id' => $model->id]);
                foreach ($model->cuisine_field as $cuisine) {
                    $link = new RestaurantLinkCuisine();
                    $link->cuisine_id = $cuisine;
                    $link->restaurant_id = $model->id;
                    $link->save();
                }

            }


            return $this->redirect(['view', 'id' => $model->id]);
        }


        $districts = ArrayHelper::map(District::find()
            ->select('id as id, title as name')
            ->where(['city_id' => $model->city_id])
            ->asArray()
            ->all(), 'id', 'name');

        if ($model->city_id) {
            $metros = ArrayHelper::map(Metro::findBySql('SELECT metro.id, concat(metro.title, \' (\', ml.title, \')\') as name FROM metro 
LEFT JOIN metro_line ml ON ml.id = metro.line_id
WHERE ml.city_id = ' . $model->city_id . ' ORDER BY name;')
                ->asArray()
                ->all(), 'id', 'name');
        } else {
            $metros = [];
        }

        return $this->render('update', [
            'model' => $model,
            'metro' => empty($model->linkMetro) ? [new OrganizationLinkMetro()] : $model->linkMetro,
            'districts' => $districts,
            'metros' => $metros,
            'params' => $params ? $params : new RestaurantParams(['organization_id' => $model->id]),
            'halls' => empty($model->halls) ? [new RestaurantHall()] : $model->halls,
            'cuisine' => empty($model->cuisines) ? [new RestaurantLinkCuisine()] : $model->cuisines
        ]);
    }

    /**
     * Deletes an existing Organization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Organization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
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
