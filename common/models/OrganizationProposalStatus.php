<?php

namespace app\common\models;

/**
 * This is the model class for table "organization_proposal_status".
 *
 * @property int          $id
 * @property int          $organization_id
 * @property int          $proposal_id
 * @property int          $status
 *
 * @property Organization $organization
 * @property Proposal     $proposal
 */
class OrganizationProposalStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_proposal_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'proposal_id'], 'required'],
            [['organization_id', 'proposal_id', 'status'], 'default', 'value' => null],
            [['organization_id', 'proposal_id', 'status'], 'integer'],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
            [['proposal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proposal::class, 'targetAttribute' => ['proposal_id' => 'id']],
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
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProposal()
    {
        return $this->hasOne(Proposal::class, ['id' => 'proposal_id']);
    }
}
