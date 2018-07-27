<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 23.07.18
 * Time: 13:17
 */

namespace app\common\models;


use Kreait\Firebase\Database\Query;
use Kreait\Firebase\Database\Reference;
use Yii;
use yii\base\Model;
use yii\helpers\Json;

/**
 *
 * @property \app\common\models\MobileUser|null|\app\common\models\Organization $author
 */
class Message extends Model
{
    public $author_class = 'app\common\models\Organization';

    public $organization_id;

    public $proposal_id;

    public $created_at;

    public $message;

    public static function findAll($proposalId)
    {
        $result = [];

        $path = 'proposal/' . $proposalId;

        $database = Yii::$app->firebase->getDatabase();
        $reference = $database->getReference($path);

        $response = $reference->getValue();

        if (is_array($response)) {
            foreach ($response as $organizationId => $messages) {
                if (is_array($messages)) {
                    foreach ($messages as $message) {
                        /** @var self $decodedMessage */
                        $decodedMessage = self::decode($message);
                        $result[$organizationId][$decodedMessage->created_at] = $decodedMessage;
                    }
                } else {
                    $decodedMessage = self::decode($messages);
                    $result[$organizationId][$decodedMessage->created_at] = $decodedMessage;
                }
            }
            return $result;
        }
        return null;
    }

    public function attributeLabels()
    {
        return [
            'message' => 'Сообщение'
        ];
    }

    /**
     * @param $proposalId
     * @param $organizationId
     * Аналог Message::findAll($proposalId)[$organizationId] Но передает меньше данных
     *
     * @return array|null
     */
    public static function getConversation($proposalId, $organizationId)
    {
        $path = 'proposal/' . $proposalId . '/' . $organizationId;

        $database = Yii::$app->firebase->getDatabase();
        $reference = $database->getReference($path);

        return self::getReferenceValues($reference);
    }

    private static function getReferenceValues($reference)
    {
        /** @var Reference | Query $reference */
        $response = $reference->getValue();

        if (is_array($response)) {
            foreach ($response as $message) {
                /** @var self $decodedMessage */
                $decodedMessage = self::decode($message);
                $result[$decodedMessage->created_at] = $decodedMessage;
            }
            return $result;
        }
        return null;
    }

    public static function getConversationFromMessage($proposalId, $organizationId, $from)
    {
        $path = 'proposal/' . $proposalId . '/' . $organizationId;

        $database = Yii::$app->firebase->getDatabase();
        $reference = $database->getReference($path)
            ->startAt((string)$from)
            ->orderByKey();

        return self::getReferenceValues($reference);
    }

    public function rules()
    {
        return [
            ['created_at', 'default', 'value' => time()],
            ['organization_id', 'default', 'value' => Yii::$app->getUser()->getId()],
            ['message', 'string'],
            ['message', 'required'],
            ['author_class', 'ownerClassValidator'],
            [['proposal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proposal::class, 'targetAttribute' => ['proposal_id' => 'id']],
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

        if ($runValidation && !$this->validate()) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        $path = 'proposal/' . $this->proposal_id . '/' . $this->organization_id . '/' . $this->created_at;

        $database = Yii::$app->firebase->getDatabase();
        $reference = $database->getReference($path);
        $reference->set(self::encode($this));

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
        return Json::encode($message);
    }

    private static function decode($json)
    {
        return new Message(Json::decode($json, true));
    }

}