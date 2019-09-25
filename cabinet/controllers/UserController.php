<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 14:24
 */

namespace app\cabinet\controllers;


use app\cabinet\components\CabinetController;
use app\common\components\Model;
use app\common\models\District;
use app\common\models\Metro;
use app\common\models\Organization;
use app\common\models\OrganizationImage;
use app\common\models\OrganizationLinkMetro;
use app\common\models\RestaurantHall;
use app\common\models\RestaurantParams;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class UserController extends CabinetController
{
    /** @noinspection PhpUndefinedClassInspection */

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


    private function saveAttributes($containerClass, $modelId)
    {
        /** @var ActiveRecord $containerClass */
        $containerClass::deleteAll(['organization_id' => $modelId]);
        /** @var OrganizationLinkMetro[] $receivers */
        $receivers = Model::createMultiple($containerClass);
        Model::loadMultiple($receivers, Yii::$app->request->post());
        foreach ($receivers as $receiver) {
            $receiver->organization_id = $modelId;
            $receiver->save();
        }
    }

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

                if (!empty($model->linkActivity)) {
                    $model->linkActivity[0]->save();
                }

                $this->saveAttributes(OrganizationLinkMetro::class, $model->id);
                $this->saveAttributes(RestaurantHall::class, $model->id);

                \Yii::$app->session->setFlash('success', 'Данные успешно сохранены');
            }
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

        /** @noinspection MissedViewInspection */
        return $this->render('edit', [
            'model' => $model,
            'metro' => empty($model->linkMetro) ? [new OrganizationLinkMetro()] : $model->linkMetro,
            'districts' => $districts,
            'metros' => $metros,
            'params' => $params ? $params : new RestaurantParams(['organization_id' => $model->id]),
            'halls' => empty($model->halls) ? [new RestaurantHall()] : $model->halls,
        ]);
    }


    public function actionImgDelete($id)
    {
        OrganizationImage::deleteAll(['upload_id' => $id]);
        return $this->redirect(['user/edit']);
    }

}