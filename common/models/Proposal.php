<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace app\common\models;

use app\common\components\Constants;
use app\common\models\geo\GeoCity;
use app\jobs\SendNotifyAboutNewProposalJob;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\queue\Queue;
use yii\swiftmailer\Mailer;

/**
 * This is the model class for table "proposal".
 *
 * @property int $id
 * @property int $owner_id
 * @property string $City
 * @property string $date
 * @property string $time
 * @property int $guests_count
 * @property double $amount
 * @property int $event_type
 * @property int $metro
 * @property bool $dance
 * @property bool $private
 * @property bool $own_alcohol
 * @property bool $parking
 * @property string $comment
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property array $organizations
 *
 * @property \DateTime $when
 * @property int $cuisineString
 * @property int $eventType
 * @property MobileUser $owner
 * @property boolean $floristics
 * @property boolean $hall
 * @property boolean $photo
 * @property boolean $stylists
 * @property boolean $entertainment
 * @property boolean $cake
 * @property boolean $transport
 * @property boolean $present
 * @property integer $city_id
 * @property integer $region_id
 * @property bool|array|mixed $answers
 * @property \yii\db\ActiveQuery|\app\common\models\geo\GeoCity $geoCity
 * @property integer $all_regions
 *
 *
 *
 * @property integer $minCost
 *
 * @property boolean $send15
 * @property boolean $send120
 * @property string $type [integer]
 * @property string $cuisine [integer]
 *
 * @property Cost $bestCost
 */
//TODO: remove type
class Proposal extends ActiveRecord
{

    public $_minCost;

    public $type = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proposal';
    }

    /**
     * @param Proposal $proposal
     * @return float|int
     * @throws \yii\db\Exception
     */
    public static function getProfit(Proposal $proposal)
    {
        $cost = $proposal->amount * $proposal->guests_count; ///стоимость заявки
        $restaurantCost = $proposal->getMinCost(); // мин ставка
        if ($restaurantCost === null) {
            return 0;
        }
        return round(100 - ($restaurantCost * 100 / $cost));
    }

    /**
     * @return false|string|null
     * @throws \yii\db\Exception
     */
    public function getMinCost()
    {
        return self::getMinCostForRestaurant($this->id, false);
    }

    /**
     * @param $proposalId
     * @param null $restaurantId
     * @return false|int|null
     * @throws \yii\db\Exception
     */
    public static function getMinCostForRestaurant($proposalId, $restaurantId = null)
    {
        if ($restaurantId === false) {
            return Yii::$app
                ->getDb()
                ->createCommand(
                    'SELECT min(cost) FROM cost WHERE proposal_id = :pid;', [
                        ':pid' => $proposalId
                    ]
                )
                ->queryScalar();
        }

        if ($restaurantId === null) {
            $restaurantId = Yii::$app->getUser()->getId();
        }

        return Yii::$app
            ->getDb()
            ->createCommand(
                'SELECT min(cost) FROM cost WHERE restaurant_id = :rid AND proposal_id = :pid;', [
                    ':rid' => $restaurantId,
                    ':pid' => $proposalId
                ]
            )
            ->queryScalar();
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
            ['type', 'default', 'value' => 2],
            ['status', 'default', 'value' => Constants::PROPOSAL_STATUS_CREATED],
            [['status', 'owner_id', 'date', 'time', 'guests_count', 'amount', 'event_type'], 'required'],
            [['owner_id', 'guests_count', 'event_type', 'metro'], 'default', 'value' => null],
            [['owner_id', 'guests_count', 'event_type', 'metro'], 'integer'],
            [['date', 'time', 'send15', 'send120'], 'safe'],
            [['amount'], 'number'],
            [['dance', 'private', 'own_alcohol', 'parking'], 'boolean'],
            [['comment'], 'string'],
            [['City'], 'string', 'max' => 255],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => MobileUser::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['created_at', 'updated_at'], 'default', 'value' => time()],
            [['created_at', 'updated_at'], 'integer'],

            [['floristics', 'hall', 'photo', 'stylists', 'cake', 'entertainment', 'transport', 'present'], 'boolean'],

            [['city_id', 'region_id', 'all_regions'], 'integer'],

            ['organizations', 'safe'],
            ['organizations', 'default', 'value' => '[]']
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
            'date' => 'Дата банкета',
            'time' => 'Время банкета',
            'guests_count' => 'Количество гостей',
            'event_type' => 'Тип мероприятия',
            'eventType' => 'Тип мероприятия',
            'metro' => 'Метро',
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
            'created_at' => 'Дата создания',
            'status' => 'Статус заявки"',
            'city_id' => 'Город'
        ];
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'City', 'date',
            'time', 'guests_count',
            'amount',
            'event_type', 'metro',
            'dance',
            'private', 'own_alcohol',
            'parking', 'comment',
            'organizations', 'floristics', 'hall', 'photo', 'stylists', 'cake', 'transport', 'entertainment', 'present'
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
     * @throws \Exception
     */
    public function getWhen()
    {
        return new \DateTime($this->date);
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {

        if ($this->city_id && !$this->City) {
            $city = GeoCity::findOne($this->city_id);
            if ($city) {
                $this->City = $city->title;
            }
        }

        //TODO: Поправить ошибку приходящую из приложения
        if ($this->city_id !== 1 && $this->City === 'Москва') {
            $this->city_id = 1;
        }

        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery|GeoCity
     */
    public function getGeoCity()
    {
        return $this->hasOne(GeoCity::class, ['id' => 'city_id']);
    }

    /**
     * @return int
     */
    public function getCuisineString()
    {
        return self::cuisineLabels()[$this->cuisine];
    }

    /**
     * @return array
     */
    public static function cuisineLabels()
    {
        return [
            1 => 'Нет предпочтений',
            2 => 'Русская',
            3 => 'Европейская',
            4 => 'Паназиатская',
            5 => 'Восточная',
            6 => 'Итальянская',
            7 => 'Японская',
            8 => 'Китайская'
        ];
    }

    /**
     * @return int
     */
    public function getEventType()
    {
        return self::typeLabels()[$this->event_type];
    }

    /**
     * @return array
     */
    public static function typeLabels()
    {
        return [
            1 => 'Банкет',
            2 => 'Корпоратив',
            3 => 'Детский праздник',
            4 => 'День Рождения',
            5 => 'Юбилей',
            6 => 'Свадьба',
            7 => 'Другое'
        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            /** @var Queue $queue */
            $queue = Yii::$app->queue;
            $queue->push(new SendNotifyAboutNewProposalJob(['proposal' => $this]));

        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return array|bool|mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function getAnswers()
    {
//        $result = [];
//        $cache = \Yii::$app->cache;
//        $result = $cache->get('proposal-answers-' . $this->id);

//        if ($result == false) {
        $messages = Message::findAll($this->owner_id, $this->id);
        $tmp = $result = [];
        foreach ($messages as $organizationId => $messagesArray) {
            $tmp[$organizationId] = min(array_keys($messagesArray));
        }

        foreach ($tmp as $organizationId => $timestamp) {
            $result[Organization::findOne(intval($organizationId))->name] = \Yii::$app->formatter->asDatetime($timestamp);
        }
//        }

        return $result;
    }

    /**
     * @return false|string|null
     * @throws \yii\db\Exception
     */
    public function getMyMinCost()
    {
        return self::getMinCostForRestaurant($this->id);
    }

    /**
     * @return bool
     */
    public function isActual()
    {
        return $this->status === Constants::PROPOSAL_STATUS_CREATED && $this->date >= date('Y-m-d');
    }

    /**
     * @param $restaurant
     * @return Cost|ActiveRecord|null
     */
    public function getRestaurantMinCost($restaurant)
    {
        return Cost::find()->where(['proposal_id' => $this->id, 'restaurant_id' => $restaurant])->orderBy('cost')->one();
    }

    /**
     * @param $restaurant
     * @return bool|null
     */
    public function getIsRestaurantBest($restaurant)
    {
        if ($this->bestCost) {
            return $this->bestCost->restaurant_id === $restaurant;
        }
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery|Cost
     */
    public function getBestCost()
    {
        return $this->hasOne(Cost::class, ['proposal_id' => 'id'])->orderBy('cost');
    }

    public function getCostsCount()
    {
        return $this->getCosts()->count();
    }

    public function getCosts()
    {
        return $this->hasMany(Cost::class, ['proposal_id' => 'id']);
    }

    public function getUniqueCosts()
    {
        return $this->hasMany(Cost::class, ['proposal_id' => 'id'])
            ->select('count(*)')
            ->groupBy('restaurant_id');
    }


    public function sendNotify()
    {
        Yii::$app->mailer->compose()
            ->setFrom('noreply@banket-b.ru')
            ->setTo('zkzrr@yandex.ru')
            ->setSubject('Новая заявка')
            ->setHtmlBody('В разделе заявок появилась новая заявка <a href="https://admin.banket-b.ru/proposal/update/' . $this->id . '">посмотреть</a>')
            ->send();

        $recipients = Organization::find()
            ->where(['state' => Constants::ORGANIZATION_STATE_PAID])
            ->andFilterWhere(['unsubscribe' => true])
            ->andFilterWhere(['NOT ILIKE', 'email', 'banket-b.ru'])
            ->all();
        foreach ($recipients as $recipient) {


            /** @var Mailer $mailer */
            $mailer = Yii::$app->mailer;

            $mailer->getView()->params['recipient'] = $recipient;

            /** @var \Swift_Message $message */
            $mailer->compose('proposal-html', [
                'proposal' => $this,
                'recipient' => $recipient
            ])->setFrom('noreply@banket-b.ru')
                ->setTo($recipient->email)
                ->setSubject('Новая заявка')
                ->send();
        }
    }

}
