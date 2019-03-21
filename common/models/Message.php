<?php /** @noinspection PhpUndefinedFieldInspection */

/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 23.07.18
 * Time: 13:17
 */

namespace app\common\models;


use Kreait\Firebase\Database;
use Kreait\Firebase\Database\Query;
use Kreait\Firebase\Database\Reference;
use Yii;
use yii\base\Model;

/**
 *
 * @property \app\common\models\MobileUser|null|\app\common\models\Organization $author
 */
class Message extends Model
{
    /** @var string */
    public $author_class = 'app\common\models\Organization';

    /** @var integer */
    public $organization_id;

    /** @var integer */
    public $proposal_id;

    /** @var string */
    public $created_at;

    /** @var string */
    public $message;

    /** @var integer */
    public $user_id;

    /** @var integer */
    public $cost = 0;

    public $btnDisabled;
    public $btnStyle;

    /**
     * @param $user_id
     * @param $proposalId
     * @return array
     */
    public static function findAll($user_id, $proposalId)
    {
        $result = [];

        $path = 'proposal_2/u_' . $user_id . '/p_' . $proposalId;
        /** @var Database $database */
        $database = Yii::$app->firebase->getDatabase();
        $reference = $database->getReference($path);

        $response = $reference->getValue();

        if (is_array($response)) {
            foreach ($response as $organizationId => $messages) {
                if (is_array($messages)) {
                    foreach ($messages as $message) {
                        /** @var self $decodedMessage */
                        $decodedMessage = self::decode($message);
                        $result[str_replace('o_', '', $organizationId)][$decodedMessage->created_at] = $decodedMessage;
                    }
                } else {
                    $decodedMessage = self::decode($messages);
                    $result[str_replace('o_', '', $organizationId)][$decodedMessage->created_at] = $decodedMessage;
                }
            }
        }
        return $result;
    }

    public function attributeLabels()
    {
        return [
            'message' => 'Сообщение',
            'organization_id' => 'Организация',
            'created_at' => 'Дата',
            'cost' => 'Стоимость банкета'
        ];
    }

    /**
     * @param $user_id
     * @param $proposalId
     * @param $organizationId
     * Аналог Message::findAll($proposalId)[$organizationId] Но передает меньше данных
     *
     * @return Message[]|null
     */
    public static function getConversation($user_id, $proposalId, $organizationId)
    {
        $path = 'proposal_2/u_' . $user_id . '/p_' . $proposalId . '/o_' . $organizationId;

        /** @var Database $database */
        $database = Yii::$app->firebase->getDatabase();
        $reference = $database->getReference($path);

        return self::getReferenceValues($reference);
    }

    /**
     * @param $reference
     * @return null|Message[]
     */
    private static function getReferenceValues($reference)
    {
        /** @var Reference | Query $reference */
        $response = $reference->getValue();

        if (is_array($response)) {
            $result = [];
            foreach ($response as $message) {
                /** @var self $decodedMessage */
                $decodedMessage = self::decode($message);

//                var_dump($message); die;

                $result[$decodedMessage->created_at] = $decodedMessage;
            }
            return $result ?? null;
        }
        return null;
    }

    public static function getConversationFromMessage($user_id, $proposalId, $organizationId, $from)
    {
        $path = 'proposal_2/u_' . $user_id . '/p_' . $proposalId . '/o_' . $organizationId;
        /** @var Database $database */
        $database = Yii::$app->firebase->getDatabase();
        $reference = $database->getReference($path)
            ->startAt((string)$from)
            ->orderByKey();

        return self::getReferenceValues($reference);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['organization_id', 'integer'],
            ['created_at', 'default', 'value' => time()],
            ['message', 'string'],
            ['message', 'required'],
            ['author_class', 'ownerClassValidator'],
            [['proposal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proposal::class, 'targetAttribute' => ['proposal_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => MobileUser::class, 'targetAttribute' => ['user_id' => 'id']],
            ['cost', 'integer', 'min' => 0, 'max' => $this->cost, 'tooSmall' => 'Стоимость не может быть меньше 0', 'tooBig' => 'Стоимость не может быть больше ' . $this->cost]
        ];
    }

    /**
     * @param $attribute
     * @param $params
     *
     * @return bool
     */
    public function ownerClassValidator($attribute, $params)
    {
        return class_exists($this->$attribute);
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return $this|bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->beforeSave();
        if ($runValidation && !$this->validate()) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        $path = 'proposal_2/u_' . $this->user_id . '/p_' . $this->proposal_id . '/o_' . $this->organization_id . '/' . $this->created_at;

        /** @var Database $database */
        $database = Yii::$app->firebase->getDatabase();
        $reference = $database->getReference($path);
        $reference->set(self::encode($this));
        $this->afterSave();
        return $this;
    }

    /**
     * @return MobileUser|Organization|null
     */
    public function getAuthor()
    {
        if ($this->author_class == Organization::class) {
            return Organization::findOne($this->organization_id);
        } else {
            return Proposal::findOne($this->proposal_id)->owner;
        }
    }

    private static function encode(Message $message)
    {
        return $message;// Json::encode($message);
    }

    public static function decode($message)
    {


        $object = new Message();

        foreach ($message as $key => $value) {
            $object->$key = $value;
        }
        return $object;// new Message(Json::decode($json, true));
    }

    public function beforeSave()
    {
        if ($this->organization_id == null) {
            $this->organization_id = Yii::$app->getUser()->getId();
        }
    }

    public function afterSave()
    {
        if ($this->user_id == Yii::$app->params['restorateUserId']) {
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo('RR@restorate.ru')
                ->setSubject('Новый ответ на заявку')
                ->setHtmlBody('На заявку ' . $this->proposal_id . ' поступил ответ от ресторана ' . $this->author->name . ' <a href="https://admin.banket-b.ru/proposal/answers/' . $this->proposal_id . '">посмотреть</a>')
                ->send();
        }
    }

}