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
 * @property string            $start [date]
 * @property string            $end [date]
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
    public static function findActive($id)
    {

        $organizationQuery = Organization::find()
                                         ->where(['state' => Constants::ORGANIZATION_STATE_PAID])
                                         ->select('id');
        if ($id) {
            $organizationQuery->andFilterWhere([
                'in',
                'id',
                OrganizationLinkActivity::find()
                                        ->where(['activity_id' => $id])
                                        ->select('organization_id')
            ]);
        }

        return self::find()
                   ->where([
                       'in',
                       'organization_id',
                       $organizationQuery
                   ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['start', 'default', 'value' => date('Y-m-d')],
            ['end', 'default', 'value' => '2020-01-01'],
            [['organization_id', 'title', 'start', 'end'], 'required'],
            [['organization_id'], 'default', 'value' => null],
            [['organization_id'], 'integer'],
            [['title', 'image', 'link'], 'string', 'max' => 255],
            ['sort', 'default', 'value' => 500],
            [['image'], 'safe'],
            ['file_input', 'file']
        ];
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'image' => function ($model) {
                return '/' . $model->image;
            },
            'organizationName',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'organization_id' => 'Организация',
            'title'           => 'Текст предложения',
            'image'           => 'Картинка',
            'link'            => 'Ссылка для перехода',
            'sort'            => 'Сортировка',
            'start'           => 'Дата начала показа',
            'end'             => 'Дата окончания показа'
        ];
    }

    /**
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->organization->name;
    }

    /**
     * @return \yii\db\ActiveQuery|Organization
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    /**
     * @return int
     */
    public function getBrowsingCount()
    {
        return $this->getBrowsing()->count();
    }

    /**
     * @return \yii\db\ActiveQuery|PromoStatistic{}
     */
    public function getBrowsing()
    {
        return $this->hasMany(PromoStatistic::class, ['promo_id' => 'id']);
    }

    /**
     * @return int
     */
    public function getRedirectCount()
    {
        return $this->getRedirects()->count();
    }

    /**
     * @return \yii\db\ActiveQuery | PromoRedirect[]
     */
    public function getRedirects()
    {
        return $this->hasMany(PromoRedirect::class, ['promo_id' => 'id']);
    }
}
