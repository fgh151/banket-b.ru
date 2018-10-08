<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 08.10.2018
 * Time: 16:41
 */

namespace app\api\models;



use yii\data\ActiveDataProvider;

class OrganizationSearch extends Organization
{

    public $ownAlko;
    public $scene;
    public $dance;
    public $parking;


    public function rules()
    {
        return [
            [['ownAlko', 'scene', 'dance', 'parking'], 'boolean']
        ];
    }

    public function search($params) {
        $query = Organization::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }




        return $dataProvider;
    }

}