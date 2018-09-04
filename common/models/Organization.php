<?php

namespace app\common\models;

use app\common\components\AuthTrait;
use app\common\components\Constants;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "organization".
 *
 * @property int    $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $name
 * @property string $address
 * @property string $contact
 * @property string $phone
 * @property int    $status
 * @property int    $created_at
 * @property int    $updated_at
 * @property int    $state
 * @property string $url
 * @property int $state_promo
 * @property int $state_statistic
 */
class Organization extends ActiveRecord implements IdentityInterface
{

    public $password;

    use AuthTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    public static function stateLabels()
    {
        return [
            Constants::ORGANIZATION_STATE_FREE => 'Не оплачено',
            Constants::ORGANIZATION_STATE_PAID => 'Оплачено'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state', 'auth_key', 'password_hash', 'email', 'name', 'address', 'contact', 'phone', 'created_at', 'updated_at'], 'required'],
            [['address'], 'string'],
            [['status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'name', 'contact', 'phone'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['state', 'state_statistic', 'state_promo'],'default', 'value' => Constants::ORGANIZATION_STATE_FREE],
            [['password', 'url'], 'safe']
        ];
    }

    public function fields()
    {
        return [
            'id', 'name', 'contact', 'phone', 'email', 'address'
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
            'name' => 'Название',
            'address' => 'Адрес',
            'contact' => 'Контактное лицо',
            'phone' => 'Телефон',
            'status' => 'Статус',
            'state' => 'Оплата участия в аукционах',
            'state_promo' => 'Оплата возможности размещения рекамы',
            'state_statistic' => 'Оплата работы со статистикой',
            'password' => 'Пароль',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery | Activity[]
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::class, ['id' => 'activity_id'])
            ->viaTable(OrganizationLinkActivity::tableName(), ['organization_id', 'id']);
    }
}
