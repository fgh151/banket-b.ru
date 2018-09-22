<?php

namespace app\common\models;

use app\common\components\AuthTrait;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "mobile_user".
 *
 * @property int $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $name
 */
class MobileUser extends ActiveRecord implements IdentityInterface
{
    use AuthTrait;

    public $password;

    public $name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mobile_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_hash', 'email', 'phone', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['auth_key', 'name'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['phone'], 'unique'],
            ['password', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'phone' => 'Телефон',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
