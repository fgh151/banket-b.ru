<?php

namespace app\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\swiftmailer\Mailer;

/**
 * This is the model class for table "funnel".
 *
 * @property int $id
 * @property string $event
 * @property string $uid
 * @property int $user_id
 * @property string $extra
 */
class Funnel extends ActiveRecord
{

    const OPEN_APP_EVENT = 'open-app';
    const CREATE_BTN_CLICK = 'create-btn-click';
    const GOTO_SERVICES = 'go-to-services';
    const GOFROM_SERVICE = 'go-from-service';
    const GOFROM_REGISTER = 'go-from-register';
    const CONFIRM_REGISTER = 'confirm-register';
    const BATTLE_CREATED = 'battle-created';
    const CHAT_ENTER = 'chat-enter';
    const CHAT_ANSWER = 'chan-answer';

    const NEW_COST = 'new_cost';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funnel';
    }

    public function fields()
    {
        return [
            'id', 'event'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event', 'uid'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['extra'], 'safe'],
            [['event', 'uid'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'uid' => 'Uid',
            'user_id' => 'User ID',
            'extra' => 'Extra',
        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->event === 'chan-answer') {


            $extra = $this->extra; //Json::decode($this->extra);
            $organizationId = intval($extra['organization']);
            $proposalId = intval($extra['proposal']);

            $rm = ReadMessage::find()->where(['organization_id' => $organizationId, 'proposal_id' => $proposalId])->one();
            if ($rm !== null) {
                $rm->user_messages++;
                $rm->save();
            } else {
                $rm = new ReadMessage();
                $rm->organization_id = $organizationId;
                $rm->proposal_id = $proposalId;
                $rm->count = 0;
                $rm->user_messages = 1;
                $rm->save();
            }


            $proposal = Proposal::findOne($proposalId);

            $period = Yii::$app->params['offlinePeriod'];
            $organization = Organization::find()
                ->where(['id' => $organizationId, 'send_notify' => true])
                ->andWhere(new Expression(
                    "last_visit <= NOW() - INTERVAL '{$period} minutes'"
                ))
                ->one();
            if ($organization !== null) {

                /** @var Mailer $mailer */
                $mailer = Yii::$app->mailer;

                $mailer->getView()->params['recipient'] = $organization;

                /** @var \Swift_Message $message */
                $mailer->compose('new-message-html', [
                    'proposal' => $proposal,
                    'recipient' => $organization
                ])->setFrom('noreply@banket-b.ru')
                    ->setTo($organization->email)
                    ->setSubject('Новая заявка')
                    ->send();

                $organization->send_notify = false;
                $organization->save();
            }

        }
        parent::afterSave($insert, $changedAttributes);
    }

}
