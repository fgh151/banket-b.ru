<?php

namespace app\common\models;

/**
 * This is the model class for table "promo_statistic".
 *
 * @property int $id
 * @property int $promo_id
 * @property int $created_at
 */
class PromoStatistic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promo_statistic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promo_id', 'created_at'], 'required'],
            [['promo_id', 'created_at'], 'default', 'value' => null],
            [['promo_id', 'created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promo_id' => 'Promo ID',
            'created_at' => 'Created At',
        ];
    }
}
