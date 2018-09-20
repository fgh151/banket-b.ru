<?php
/**
 * Модели для работы с гео данными
 */

namespace app\common\models\geo;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Модель хранения городов
 *
 * @property int       $id
 * @property string    $title
 * @property int       $region_id
 *
 * @property GeoRegion $region
 */
class GeoCity extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['region_id'], 'default', 'value' => null],
            [['region_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [
                ['region_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => GeoRegion::class,
                'targetAttribute' => ['region_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'title'     => 'Title',
            'region_id' => 'Region ID',
            'base'      => 'Base',
            'approved'  => 'Approved',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(GeoRegion::class, ['id' => 'region_id']);
    }

    /**
     * Массив городов (id => title)
     *
     * @return array
     */
    public static function getSelectData(): array
    {
        $cities = self::find()

                      ->orderBy(['title' => SORT_ASC])
                      ->all();

        $cities    = ArrayHelper::map($cities, 'id', 'title');
        $topCities = [1 => $cities[1], 2 => $cities[2]];
        unset($cities[1]);
        unset($cities[2]);
        $cities = $topCities + $cities;

        return $cities;
    }
}
