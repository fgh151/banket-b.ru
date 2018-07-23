<?php

namespace app\common\models;

use app\common\components\AuthTrait;
use app\common\components\Constants;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string  $username
 * @property string  $password_hash
 * @property string  $password_reset_token
 * @property string  $email
 * @property string  $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string  $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{

    use AuthTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => Constants::USER_STATUS_ACTIVE],
            ['status', 'in', 'range' => [Constants::USER_STATUS_ACTIVE, Constants::USER_STATUS_DELETED]],
            [['auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

}
