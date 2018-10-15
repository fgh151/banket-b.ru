<?php

namespace app\common\models;

/**
 * This is the model class for table "district".
 *
 * @property int $id
 * @property int $city_id
 * @property string $title
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'district';
    }

    public function fields()
    {
        return ['id', 'title'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'default', 'value' => null],
            [['city_id'], 'integer'],
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
            'city_id' => 'City ID',
            'title' => 'Title',
        ];
    }
}
