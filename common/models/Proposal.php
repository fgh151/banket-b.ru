<?php

namespace app\common\models;

use app\common\components\Constants;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "proposal".
 *
 * @property int        $id
 * @property int        $owner_id
 * @property string     $City
 * @property string     $date
 * @property string     $time
 * @property int        $guests_count
 * @property double     $amount
 * @property int        $type
 * @property int        $event_type
 * @property int        $metro
 * @property int        $cuisine
 * @property bool       $dance
 * @property bool       $private
 * @property bool       $own_alcohol
 * @property bool       $parking
 * @property string     $comment
 * @property int        $status
 * @property int        $created_at
 * @property int        $updated_at
 *
 * @property \DateTime  $when
 * @property int        $cuisineString
 * @property int        $eventType
 * @property $this      $isConstructor
 * @property MobileUser $owner
 * @property boolean    $floristics
 * @property boolean    $hall
 * @property boolean    $photo
 * @property boolean    $stylists
 * @property boolean    $entertainment
 * @property boolean    $cake
 * @property boolean    $transport
 * @property boolean    $present
 * @property integer    $city_id
 * @property integer    $region_id
 * @property integer    $all_regions
 */
class Proposal extends ActiveRecord
{
    public $constructorComment;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proposal';
    }

    public static function cuisineLabels()
    {
        return [
            1 => 'Нет предпочтений',
            2 => 'Русская',
            3 => 'Европейская',
            4 => 'Азиатская',
            5 => 'Восточная',
            6 => 'Латиноамериканская',
        ];
    }

    public static function typeLabels()
    {
        return [
            1 => 'Встреча друзей',
            2 => 'Корпоратив',
            3 => 'Свадьба',
            4 => 'День Рождения',
            5 => 'Презентация',
            6 => 'Поминки',
        ];
    }

    public static function types()
    {
        return [
            1 => 'Банкет',
            2 => 'Фукршет'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => Constants::PROPOSAL_STATUS_CREATED],
            [['status', 'owner_id', 'date', 'time', 'guests_count', 'amount', 'type', 'event_type', 'cuisine'], 'required'],
            [['owner_id', 'guests_count', 'type', 'event_type', 'metro', 'cuisine'], 'default', 'value' => null],
            [['owner_id', 'guests_count', 'type', 'event_type', 'metro', 'cuisine'], 'integer'],
            [['date', 'time', 'constructorComment'], 'safe'],
            [['amount'], 'number'],
            [['dance', 'private', 'own_alcohol', 'parking'], 'boolean'],
            [['comment'], 'string'],
            [['City'], 'string', 'max' => 255],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => MobileUser::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['created_at', 'updated_at'], 'default', 'value' => time()],
            [['created_at', 'updated_at'], 'integer'],

            [['floristics', 'hall', 'photo', 'stylists', 'cake', 'entertainment', 'transport', 'present'], 'boolean'],

            [['city_id', 'region_id', 'all_regions'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Заявитель',
            'City' => 'Город',
            'date' => 'Дата',
            'time' => 'Время',
            'guests_count' => 'Количество гостей',
            'type' => 'Мероприятие',
            'event_type' => 'Тип мероприятия',
            'eventType' => 'Тип мероприятия',
            'metro' => 'Метро',
            'cuisine' => 'Кухня',
            'cuisineString' => 'Кухня',
            'dance' => 'Танцпол',
            'private' => 'Отдельный зал',
            'own_alcohol' => 'Свой алкоголь',
            'parking' => 'Парковка',
            'comment' => 'Комментарий',
            'amount' => 'Сумма на человека',

            'floristics' => 'Флористика',
            'hall' => 'Оформление зала',
            'photo' => 'Фото / видео',
            'stylists' => 'Стилисты',
            'cake' => 'Торты на заказ',
            'entertainment' => 'Развлекательная программа',
            'transport' => 'Транспорт на заказа',
            'present' => 'Подарки',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'City', 'date',
            'time', 'guests_count',
            'amount', 'type',
            'event_type', 'metro',
            'cuisine', 'dance',
            'private', 'own_alcohol',
            'parking', 'comment'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(MobileUser::class, ['id' => 'owner_id']);
    }

    /**
     * @return \DateTime
     */
    public function getWhen()
    {
        return new \DateTime($this->date . ' ' . $this->time);
    }

    public function beforeValidate()
    {
        $this->comment .= $this->constructorComment;
        return parent::beforeValidate();
    }

    /**
     * @return bool
     */
    public function getIsConstructor()
    {
        return $this->floristics ||
            $this->hall ||
            $this->photo ||
            $this->stylists ||
            $this->cake ||
            $this->entertainment ||
            $this->transport ||
            $this->present;
    }

    /**
     * @return int
     */
    public function getEventType()
    {
        return self::typeLabels()[$this->event_type];
    }

    /**
     * @return int
     */
    public function getCuisineString()
    {
        return self::cuisineLabels()[$this->cuisine];
    }
}
