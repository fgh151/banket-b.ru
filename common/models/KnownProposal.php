<?php

namespace app\common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "known_proposal".
 *
 * @property int $id
 * @property int $organization_id
 * @property int $proposal_id
 */
class KnownProposal extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'known_proposal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'proposal_id'], 'required'],
            [['organization_id', 'proposal_id'], 'default', 'value' => null],
            [['organization_id', 'proposal_id'], 'integer'],
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
        ];
    }
}
