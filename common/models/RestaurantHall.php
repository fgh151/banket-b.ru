<?php

namespace app\common\models;


/**
 * This is the model class for table "restaurant_hall".
 *
 * @property int $id
 * @property int $restaurant_id
 * @property string $title
 * @property int $size
 */
class RestaurantHall extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant_hall';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurant_id', 'size'], 'required'],
            [['restaurant_id', 'size'], 'default', 'value' => null],
            [['restaurant_id', 'size'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'title' => 'Название зала',
            'size' => 'Вместимость (человек)',
        ];
    }

    public function fields()
    {
        return [
            'title', 'size'
        ];
    }
}
