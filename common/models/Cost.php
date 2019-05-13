<?php

namespace app\common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "cost".
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int $proposal_id
 * @property int $cost
 * @property string $created_at
 */
class Cost extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cost';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurant_id', 'proposal_id', 'cost'], 'required'],
            [['restaurant_id', 'proposal_id', 'cost'], 'default', 'value' => null],
            [['restaurant_id', 'proposal_id', 'cost'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->cost = str_replace(' ', '', $this->cost);
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurant_id' => 'Ресторан',
            'proposal_id' => 'Заявка',
            'cost' => 'Ставка',
            'created_at' => 'Created At',
        ];
    }
}
