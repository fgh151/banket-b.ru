<?php

namespace app\common\models;

/**
 * This is the model class for table "organization_image".
 *
 * @property int $id
 * @property int $organization_id
 * @property int $upload_id
 */
class OrganizationImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'upload_id'], 'required'],
            [['organization_id', 'upload_id'], 'default', 'value' => null],
            [['organization_id', 'upload_id'], 'integer'],
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
            'upload_id' => 'Upload ID',
        ];
    }
}
