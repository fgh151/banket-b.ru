<?php

namespace app\common\models;


/**
 * This is the model class for table "restaurant_params".
 *
 * @property int $id
 * @property int $organization_id
 * @property bool $ownAlko
 * @property bool $scene
 * @property bool $dance
 * @property bool $parking
 * @property double $amount
 */
class RestaurantParams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant_params';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id'], 'required'],
            [['organization_id'], 'default', 'value' => null],
            [['organization_id'], 'integer'],
            [['ownAlko', 'scene', 'dance', 'parking'], 'boolean'],
            [['amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'ownAlko' => 'Возможность прийти со своим алкоголем',
            'scene' => 'Наличие сцены',
            'dance' => 'Наличие танцпола',
            'parking' => 'Наличие парковки',
            'amount' => 'Средняя стоимость на человека',
        ];
    }
}
