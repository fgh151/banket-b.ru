<?php

namespace app\common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "read_message".
 *
 * @property int $id
 * @property int $organization_id
 * @property int $proposal_id
 * @property int $count
 * @property int $user_messages
 */
class ReadMessage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'read_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'proposal_id'], 'required'],
            [['organization_id', 'proposal_id', 'count'], 'default', 'value' => null],
            [['organization_id', 'proposal_id', 'count', 'user_messages'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'proposal_id' => 'Proposal ID',
            'count' => 'Count',
        ];
    }
}
