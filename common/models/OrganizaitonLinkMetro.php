<?php

namespace app\models;

/**
 * This is the model class for table "organization_link_metro".
 *
 * @property int $id
 * @property int $metro_id
 * @property int $organization_id
 */
class OrganizaitonLinkMetro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_link_metro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['metro_id', 'organization_id'], 'default', 'value' => null],
            [['metro_id', 'organization_id'], 'integer'],
            [['organization_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'metro_id' => 'Metro ID',
            'organization_id' => 'Organization ID',
        ];
    }
}
