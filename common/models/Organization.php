<?php

namespace app\common\models;

use app\common\components\AuthTrait;
use app\common\components\behaviors\FileUploadBehavior;
use app\common\components\Constants;
use app\common\models\geo\GeoCity;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\validators\ExistValidator;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $name
 * @property string $address
 * @property string $contact
 * @property string $phone
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $state
 * @property string $url
 * @property int $state_promo
 * @property int $state_statistic
 * @property integer $city_id
 * @property RestaurantHall $halls
 * @property RestaurantParams $params
 * @property \app\common\models\Metro[]|\yii\db\ActiveQuery $metro
 * @property \yii\db\ActiveQuery|\app\common\models\Activity[] $activities
 * @property boolean $state_direct
 * @property integer $district_id
 * @property Upload[] $images
 *
 * @property OrganizationLinkMetro[] $linkMetro
 * @property OrganizationLinkActivity[] $linkActivity
 * @property GeoCity $city
 *
 * @property string $restogram_id
 *
 * @property double $rating
 *
 *
 * @property double $latitude
 * @property double $longitude
 * @property bool $unsubscribe [boolean]
 * @property string $hash
 * @property string $unsubscribeUrl
 * @property OrganizationLinkActivity $mainActivity
 * @property ProposalSearch $proposal_search
 *
 * @property string $last_visit
 * @property boolean $send_notify
 */
class Organization extends ActiveRecord implements IdentityInterface
{

    public $password;
    public $image_field;

    public $activity_field;

//public $rating = 0;
//public $profit = 0;

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
            [['status', 'created_at', 'updated_at', 'city_id', 'district_id', 'activity_field'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'name', 'contact', 'phone', /*'restogram_id' */], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['state', 'state_statistic', 'state_promo', 'state_direct'],'default', 'value' => Constants::ORGANIZATION_STATE_FREE],
            [['password', 'url', 'image_field'], 'safe'],
            ['city_id', ExistValidator::class, 'targetClass' => GeoCity::class, 'targetAttribute' => 'id'],
            ['rating', 'number', 'max' => 10, 'min' => 0],
            ['proposal_search', 'string'],
            [['unsubscribe', 'send_notify'], 'boolean'],
            [['last_visit'], 'safe']
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
//            'amount' => function (Organization $model) {
//                return $model->params->amount;
//            },
            'halls',
            'metro',
            'key' => function ($model) {
                return (string)$model->id;
            },
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
            'district_id' => 'Район',
            'unsubscribe' => 'Получать уведомления'
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->activity_field = $this->mainActivity ? $this->mainActivity->activity_id : null;

        if ($this->proposal_search === null || $this->proposal_search === '') {
            $this->proposal_search = new ProposalSearch();
        } else {
            $this->proposal_search = unserialize(base64_decode($this->proposal_search));
        }
    }

    public function getMainActivity()
    {
        return $this->hasOne(OrganizationLinkActivity::class, ['organization_id' => 'id']);
    }

    /**
     * Сериализация модели поиска перед сохранением
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->proposal_search === null) {
            $this->proposal_search = new ProposalSearch();
        }
        $this->proposal_search = base64_encode(serialize($this->proposal_search));

        return parent::beforeValidate();
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

    /**
     * @return bool
     */
    public function isRestaurant()
    {
        return OrganizationLinkActivity::find()
            ->where(['activity_id' => 1, 'organization_id' => $this->id])
            ->exists();
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

    public function getCity()
    {
        return $this->hasOne(GeoCity::class, ['id' => 'city_id']);
    }

    public function getUnsubscribeUrl()
    {
        return Url::to(['site/unsubscribe', 'uid' => $this->id, 'hash' => $this->getHash()], true);
    }

    /**
     * @return string
     */
    public function getHash()
    {
        $salt = '10tit9Waey8ffMo1quae7Halichu4e2OoZoo0Ah14d4';
        return substr(md5($salt . $this->id), 0, 40);
    }

}
