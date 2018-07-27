<?php

namespace app\common\models;

use app\common\components\Constants;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "promo".
 *
 * @property int               $id
 * @property int               $organization_id
 * @property string            $title
 * @property string            $image
 * @property Organization|null $organization
 * @property string            $link
 */
class Promo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promo';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function findActive()
    {
        return self::find()->where(['in', 'organization_id', Organization::find()->where(['state' => Constants::ORGANIZATION_STATE_PAID])]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'title', 'image'], 'required'],
            [['organization_id'], 'default', 'value' => null],
            [['organization_id'], 'integer'],
            [['title', 'image', 'link'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'image' => 'Image',
            'link' => 'Link',
        ];
    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }
}
