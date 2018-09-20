<?php
/**
 * Модели для работы с гео данными
 */

namespace app\common\models\geo;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Модель хранения регионов
 *
 * @property int    $id
 * @property string $title
 * @property int    $sort
 */
class GeoRegion extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return array
     */
    public static function getSelectData(): array
    {
        $regions    = ArrayHelper::map(self::find()->orderBy(['title' => SORT_ASC])->all(), 'id',
            'title');
        $topRegions = [78 => $regions[78], 79 => $regions[79]];
        unset($regions[78]);
        unset($regions[79]);

        return $topRegions + $regions;
    }

    /**
     * Метод вывода обьекта
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
