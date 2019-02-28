<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 08.10.2018
 * Time: 16:41
 */

namespace app\api\models;


use app\common\models\District;
use app\common\models\Metro;
use app\common\models\OrganizationLinkMetro;
use app\common\models\RestaurantHall;
use app\common\models\RestaurantParams;
use yii\data\ActiveDataProvider;

class OrganizationSearch extends Organization
{

    public $ownAlko = false;
    public $scene = false;
    public $dance = false;
    public $parking = false;

    public $size = 0;

    public $districtId;
    public $cityId;
    public $metroId;

    public $amount;

    public $districtTitle;
    public $metroTitle;


    public function rules()
    {
        return [
            [['ownAlko', 'scene', 'dance', 'parking', 'cityId', 'amount'], 'safe'],
            [['size', 'districtId', 'metroId'], 'integer'],
            [['districtTitle', 'metroTitle'], 'string']
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * TODO: refactoring JOIN
     */
    public function search($params)
    {
        $query = Organization::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $this->load($params, '');


        $query->where(['state_direct' => true]);


        if ( ! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');

            return $dataProvider;
        }


        if ($this->ownAlko !== 'false') {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantParams::find()
                    ->where(['ownAlko' => true])
                    ->select('organization_id')
            ]);
        }
        if ($this->scene !== 'false') {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantParams::find()
                    ->where(['scene' => true])
                    ->select('organization_id')
            ]);
        }
        if ($this->dance !== 'false') {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantParams::find()
                    ->where(['dance' => true])
                    ->select('organization_id')
            ]);
        }
        if ($this->parking !== 'false') {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantParams::find()
                    ->where(['parking' => true])
                    ->select('organization_id')
            ]);
        }

        if ($this->amount) {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantParams::find()
                    ->where(['<=', 'amount', $this->amount])
                    ->select('organization_id')
            ]);
        }

        if (intval($this->size) > 0) {
            $query->andFilterWhere([
                'in',
                'id',
                RestaurantHall::find()
                    ->where(['>=', 'size', $this->size])
                    ->select('restaurant_id')
            ]);
        }

        if ($this->metroId) {
            $query->andFilterWhere([
                'in',
                'id',
                OrganizationLinkMetro::find()->select(['organization_id'])->where(['metro_id' => $this->metroId])
            ]);
        } elseif ($this->districtId) {
            $query->andFilterWhere(['district_id' => $this->districtId]);
        }

        if ($this->metroTitle) {
            $query->andFilterWhere([
                'in',
                'id',
                OrganizationLinkMetro::find()
                    ->select(['organization_id'])
                    ->where(['in', 'metro_id',
                            Metro::find()->where(['title' => $this->metroTitle])->select('id')]
                    )
            ]);
        } elseif ($this->districtTitle) {
            $query->andFilterWhere([
                'in',
                'district_id',
                District::find()
                    ->select(['id'])
                    ->where(['ilike', 'title', $this->districtTitle])
            ]);
        }

        $query->andFilterWhere(['city_id' => $this->cityId]);

        $query->orFilterWhere(['id' => 1]);
        $query->orderBy(['id' => SORT_ASC]);


//        Yii::error($query->createCommand()->getRawSql());


        return $dataProvider;
    }

}