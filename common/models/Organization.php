<?php

namespace app\common\models;

use app\common\components\AuthTrait;
use app\common\components\Constants;
use app\common\models\geo\GeoCity;
use app\models\OrganizaitonLinkMetro;
use yii\db\ActiveRecord;
use yii\validators\ExistValidator;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "organization".
 *
 * @property int                                               $id
 * @property string                                            $auth_key
 * @property string                                            $password_hash
 * @property string                                            $password_reset_token
 * @property string                                            $email
 * @property string                                            $name
 * @property string                                            $address
 * @property string                                            $contact
 * @property string                                            $phone
 * @property int                                               $status
 * @property int                                               $created_at
 * @property int                                               $updated_at
 * @property int                                               $state
 * @property string                                            $url
 * @property int                                               $state_promo
 * @property int                                               $state_statistic
 * @property integer                                           $city_id
 * @property mixed                                             $halls
 * @property mixed                                             $params
 * @property \app\common\models\Metro[]|\yii\db\ActiveQuery    $metro
 * @property \yii\db\ActiveQuery|\app\common\models\Activity[] $activities
 * @property boolean                                           $state_direct
 * @property integer    $district_id
 *
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
            [['status', 'created_at', 'updated_at', 'city_id', 'district_id'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'name', 'contact', 'phone'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['state', 'state_statistic', 'state_promo', 'state_direct'],'default', 'value' => Constants::ORGANIZATION_STATE_FREE],
            [['password', 'url'], 'safe'],
            ['city_id', ExistValidator::class, 'targetClass' => GeoCity::class, 'targetAttribute' => 'id']
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
            'state_direct' => 'Оплата возможности получения прямых заявок',
            'password' => 'Пароль',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'district_id' => 'Район'
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


    public function getHalls()
    {
        return $this->hasMany(RestaurantHall::class, ['restaurant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery|Metro[]
     */
    public function getMetro()
    {
        return $this->hasMany(Metro::class, ['id' => 'metro_id'])
            ->viaTable(OrganizaitonLinkMetro::tableName(), ['organization_id' => 'id']);
    }

    public function getParams()
    {
        return $this->hasOne(RestaurantParams::class, ['organization_id', 'id']);
    }
}
