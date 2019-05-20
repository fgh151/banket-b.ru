<?php

namespace app\common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "funnel".
 *
 * @property int $id
 * @property string $event
 * @property string $uid
 * @property int $user_id
 * @property array $extra
 */
class Funnel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funnel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event', 'uid'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['extra'], 'safe'],
            [['event', 'uid'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'uid' => 'Uid',
            'user_id' => 'User ID',
            'extra' => 'Extra',
        ];
    }
}
