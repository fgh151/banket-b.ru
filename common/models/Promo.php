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
 * @property mixed             $browsingCount
 * @property mixed             $browsing
 * @property int               $sort
 */
class Promo extends ActiveRecord
{
    public $file_input;

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
            [['organization_id', 'title'], 'required'],
            [['organization_id'], 'default', 'value' => null],
            [['organization_id'], 'integer'],
            [['title', 'image', 'link'], 'string', 'max' => 255],
            ['sort', 'default', 'value' => 500],
            ['image', 'safe'],
            ['file_input', 'file']
        ];
    }

    public function fields()
    {
        return [
            'title', 'image', 'link'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Организация',
            'title' => 'Заголовок',
            'image' => 'Картинка',
            'link' => 'Ссылка для перехода',
            'sort' => 'Сортировка'
        ];
    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    public function getBrowsingCount()
    {
        return $this->getBrowsing()->count();
    }

    public function getBrowsing()
    {
        return $this->hasMany(PromoStatistic::class, ['promo_id' => 'id']);
    }
}
