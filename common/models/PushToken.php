<?php

namespace app\common\models;

/**
 * This is the model class for table "push_token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $device
 * @property string $apns
 */
class PushToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'push_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['token', 'device', 'apns'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'token' => 'Token',
        ];
    }
}
