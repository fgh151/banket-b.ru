<?php

namespace app\common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "organization_link_activity".
 *
 * @property int $id
 * @property int $organization_id
 * @property int $activity_id
 */
class OrganizationLinkActivity extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_link_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'activity_id'], 'required'],
            [['organization_id', 'activity_id'], 'default', 'value' => null],
            [['organization_id', 'activity_id'], 'integer'],
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
            'activity_id' => 'Activity ID',
        ];
    }
}
