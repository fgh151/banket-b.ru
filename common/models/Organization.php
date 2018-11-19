<?php

namespace app\common\models;

use app\common\components\AuthTrait;
use app\common\components\behaviors\FileUploadBehavior;
use app\common\components\Constants;
use app\common\models\geo\GeoCity;
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
 * @property RestaurantHall $halls
 * @property RestaurantParams $params
 * @property \app\common\models\Metro[]|\yii\db\ActiveQuery    $metro
 * @property \yii\db\ActiveQuery|\app\common\models\Activity[] $activities
 * @property boolean                                           $state_direct
 * @property integer    $district_id
 * @property Upload[] $images
 *
 * @property OrganizationLinkMetro[] $linkMetro
 * @property OrganizationLinkActivity[] $linkActivity
 * @property RestaurantLinkCuisine[] $cuisineLinks
 * @property GeoCity $city
 *
 */
class Organization extends ActiveRecord implements IdentityInterface
{

    public $password;
    public $image_field;

    public $cuisine_field;

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
    public function behaviors()
    {
        return [
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'image_field',
                'storageClass' => OrganizationImage::class,
                'storageAttribute' => 'organization_id',
                'folder' => 'organization'
            ]
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
            [['password', 'url', 'image_field', 'cuisine_field'], 'safe'],
            ['city_id', ExistValidator::class, 'targetClass' => GeoCity::class, 'targetAttribute' => 'id']
        ];
    }

    public function fields()
    {
        return [
            'id', 'name', 'contact', 'phone', 'email', 'address',
            'images' => function (Organization $model) {
                $img = [];
                foreach ($model->images as $image) {
                    $img[] = 'https://banket-b.ru/upload/organization/' . $model->id . '/' . $image->fsFileName;
                }
                return $img;
            },
            'amount' => function (Organization $model) {
                return $model->params->amount;
            },
            'halls',
            'metro',
            'cuisines'
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

    public function getLinkActivity()
    {
        return $this->hasMany(OrganizationLinkActivity::class, ['organization_id' => 'id']);
    }

    public function isRestaurant()
    {
        foreach ($this->linkActivity as $activity) {
            if ($activity->activity_id === 1) {
                return true;
            }
        }
        return false;
    }


    public function getHalls()
    {
        return $this->hasMany(RestaurantHall::class, ['restaurant_id' => 'id']);
    }

    public function getLinkMetro()
    {
        return $this->hasMany(OrganizationLinkMetro::class, ['organization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery|Metro[]
     */
    public function getMetro()
    {
        return $this->hasMany(Metro::class, ['id' => 'metro_id'])
                    ->viaTable(OrganizationLinkMetro::tableName(), ['organization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery|RestaurantParams
     */
    public function getParams()
    {
        return $this->hasOne(RestaurantParams::class, ['organization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery| Upload[]
     */
    public function getImages()
    {
        return $this->hasMany(Upload::class, ['id' => 'upload_id'])
            ->viaTable(OrganizationImage::tableName(), ['organization_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getCuisines()
    {
        $result = [];
        foreach ($this->cuisineLinks as $cuisine) {
            $result[] = $cuisine->title;
        }
        return $result;
    }

    public function getCuisineLinks()
    {
        return $this->hasMany(RestaurantLinkCuisine::class, ['restaurant_id' => 'id']);
    }

    public function getCity()
    {
        return $this->hasOne(GeoCity::class, ['id' => 'city_id']);
    }
}
