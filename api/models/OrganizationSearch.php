<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 08.10.2018
 * Time: 16:41
 */

namespace app\api\models;


use app\common\models\RestaurantHall;
use app\common\models\RestaurantLinkCuisine;
use app\common\models\RestaurantParams;
use app\models\OrganizaitonLinkMetro;
use yii\data\ActiveDataProvider;

class OrganizationSearch extends Organization
{

    public $ownAlko;
    public $scene;
    public $dance;
    public $parking;

    public $size = 0;

    public $cuisine = [];


    public $districtId;
    public $cityId;
    public $metroId;



    public function rules()
    {
        return [
            [['ownAlko', 'scene', 'dance', 'parking'], 'boolean'],
            [['size', 'districtId', 'cityId', 'metroId'], 'integer'],
            ['cuisine', 'each', 'rule' => ['integer']]
        ];
    }

    public function search($params)
    {
        $query = Organization::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->where(['state_direct' => true]);

        if ( ! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');

            return $dataProvider;
        }


        if ($this->ownAlko) {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantParams::find()
                                ->where(['ownAlko' => true])
                                ->select('organization_id')
            ]);
        }
        if ($this->scene) {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantParams::find()
                                ->where(['scene' => true])
                                ->select('organization_id')
            ]);
        }
        if ($this->dance) {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantParams::find()
                                ->where(['dance' => true])
                                ->select('organization_id')
            ]);
        }
        if ($this->parking) {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantParams::find()
                                ->where(['parking' => true])
                                ->select('organization_id')
            ]);
        }
        if ($this->size > 0) {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantHall::find()
                              ->where(['>', 'size', $this->size])
                              ->select('restaurant_id')
            ]);
        }
        if ( ! empty($this->cuisine)) {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantLinkCuisine::find()
                                     ->where(['in', 'cuisine_id', $this->cuisine])
                                     ->select('restaurant_id')
            ]);
        }

        if ($this->metroId) {
            $query->andFilterWhere(['in', 'id', OrganizaitonLinkMetro::find()->select(['organization_id'])->where(['metro_id' => $this->metroId])]);
        } elseif ($this->districtId) {
            $query->andFilterWhere(['district_id' => $this->districtId]);
        }

        $query->andFilterWhere(['city_id' => $this->city_id]);


        return $dataProvider;
    }

}