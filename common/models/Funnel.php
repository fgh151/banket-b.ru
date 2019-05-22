<?php

namespace app\common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "funnel".
 *
 * @property int $id
 * @property string $event
 * @property string $uid
 * @property int $user_id
 * @property array $extra
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
}
