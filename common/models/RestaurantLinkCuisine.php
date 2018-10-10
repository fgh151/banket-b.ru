<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "restaurant_link_cuisine".
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int $cuisine_id
 */
class RestaurantLinkCuisine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant_link_cuisine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurant_id', 'cuisine_id'], 'required'],
            [['restaurant_id', 'cuisine_id'], 'default', 'value' => null],
            [['restaurant_id', 'cuisine_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurant_id' => 'Restaurant ID',
            'cuisine_id' => 'Cuisine ID',
        ];
    }
}
