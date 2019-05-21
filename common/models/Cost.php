<?php

namespace app\common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "cost".
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int $proposal_id
 * @property int $cost
 * @property Proposal $proposal
 * @property string $created_at
 */
class Cost extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cost';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurant_id', 'proposal_id', 'cost'], 'required'],
            [['restaurant_id', 'proposal_id', 'cost'], 'default', 'value' => null],
            [['restaurant_id', 'proposal_id', 'cost'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->cost = str_replace(' ', '', $this->cost);
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurant_id' => 'Ресторан',
            'proposal_id' => 'Заявка',
            'cost' => 'Ставка',
            'created_at' => 'Created At',
        ];
    }

    public function getProposal()
    {
        return $this->hasOne(Proposal::class, ['id' => 'proposal_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {

            try {

                $proposalFunnel = ProposalFunnel::find()->where(['id' => $this->proposal_id])->one();
                $funnel = new Funnel();
                $funnel->user_id = $proposalFunnel->owner_id;
                $funnel->event = Funnel::NEW_COST;
                $funnel->uid = $proposalFunnel->uid;
                $funnel->save();
            } catch (\Exception $e) {
                \Yii::error($funnel->errors, 'Save funnel error');
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
