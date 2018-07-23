<?php

namespace app\common\models;

use Yii;
use yii\db\ActiveRecord;

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
 * @property int $type
 * @property int $event_type
 * @property int $metro
 * @property int $cuisine
 * @property bool $dance
 * @property bool $private
 * @property bool $own_alcohol
 * @property bool $parking
 * @property string $comment
 *
 * @property MobileUser $owner
 */
class Proposal extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proposal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner_id', 'City', 'date', 'time', 'guests_count', 'amount', 'type', 'event_type', 'metro', 'cuisine'], 'required'],
            [['owner_id', 'guests_count', 'type', 'event_type', 'metro', 'cuisine'], 'default', 'value' => null],
            [['owner_id', 'guests_count', 'type', 'event_type', 'metro', 'cuisine'], 'integer'],
            [['date', 'time'], 'safe'],
            [['amount'], 'number'],
            [['dance', 'private', 'own_alcohol', 'parking'], 'boolean'],
            [['comment'], 'string'],
            [['City'], 'string', 'max' => 255],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => MobileUser::class, 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'City' => 'City',
            'date' => 'Date',
            'time' => 'Time',
            'guests_count' => 'Guests Count',
            'amount' => 'Amount',
            'type' => 'Type',
            'event_type' => 'Event Type',
            'metro' => 'Metro',
            'cuisine' => 'Cuisine',
            'dance' => 'Dance',
            'private' => 'Private',
            'own_alcohol' => 'Own Alcohol',
            'parking' => 'Parking',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(MobileUser::class, ['id' => 'owner_id']);
    }
}
