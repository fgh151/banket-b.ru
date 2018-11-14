<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 14:24
 */

namespace app\cabinet\controllers;


use app\common\components\Model;
use app\common\models\District;
use app\common\models\Metro;
use app\common\models\Organization;
use app\common\models\OrganizationLinkMetro;
use app\common\models\RestaurantHall;
use app\common\models\RestaurantLinkCuisine;
use Yii;
use yii\helpers\ArrayHelper;
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


        $params = $model->params;

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->password !== '') {
                $model->setPassword($model->password);
            }
            if ($model->save()) {

                $params->load(Yii::$app->request->post());
                $params->save();

                $model->linkActivity[0]->save();

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


                \Yii::$app->session->setFlash('success', 'Данные успешно сохранены');
            }
        }

        $districts = ArrayHelper::map(District::find()
            ->select('id as id, title as name')
            ->where(['city_id' => $model->city_id])
            ->asArray()
            ->all(), 'id', 'name');

        $metros = ArrayHelper::map(Metro::findBySql('SELECT metro.id, concat(metro.title, \' (\', ml.title, \')\') as name FROM metro 
LEFT JOIN metro_line ml ON ml.id = metro.line_id
WHERE ml.city_id = ' . $model->city_id . ' ORDER BY name;')
            ->asArray()
            ->all(), 'id', 'name');

        return $this->render('edit', [
            'model' => $model,
            'metro' => empty($model->linkMetro) ? [new OrganizationLinkMetro()] : $model->linkMetro,
            'districts' => $districts,
            'metros' => $metros,
            'params' => $params,
            'halls' => empty($model->halls) ? [new RestaurantHall()] : $model->halls,
            'cuisine' => empty($model->cuisines) ? [new RestaurantLinkCuisine()] : $model->cuisines
        ]);
    }

}