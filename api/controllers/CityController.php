<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 12.10.2018
 * Time: 10:09
 */

namespace app\api\controllers;


use app\api\models\Organization;
use app\common\models\geo\GeoCity;
use app\common\models\geo\GeoRegion;
use Yii;
use yii\rest\Controller;

class CityController extends Controller
{

    public function actionIndex()
    {
        return GeoRegion::find()
            ->where([
                'in',
                'id',
                GeoCity::find()->select('region_id')->where(['in', 'id', Organization::find()->select(['city_id'])])
            ])
            ->orderBy(['order' => SORT_ASC])
            ->with('cities')
            ->cache(Yii::$app->params['cacheTimeDefault'])
            ->all();
    }

    public function actionCity()
    {
        return GeoCity::find()
            ->where(['in', 'id', Organization::find()->select(['city_id'])])
            ->with('metro')
            ->cache(Yii::$app->params['cacheTimeDefault'])
            ->all();
    }

    public function actionOrganizations()
    {
        return GeoRegion::find()
            ->where([
                'in',
                'id',
                GeoCity::find()->select('region_id')->where(['in', 'id', Organization::find()->select(['city_id'])])
            ])
            ->orderBy(['order' => SORT_ASC])
            ->with('cities')
            ->cache(Yii::$app->params['cacheTimeDefault'])
            ->all();
    }

}