<?php

namespace app\common\models;

/**
 * This is the model class for table "read_message".
 *
 * @property int $id
 * @property int $organization_id
 * @property int $proposal_id
 * @property int $count
 */
class ReadMessage extends \yii\db\ActiveRecord
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
            [['organization_id', 'proposal_id', 'count'], 'integer'],
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
