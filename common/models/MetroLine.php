<?php

namespace app\common\models;

/**
 * This is the model class for table "metro_line".
 *
 * @property int                                          $id
 * @property int                                          $external_id
 * @property int                                          $city_id
 * @property string                                       $title
 * @property \yii\db\ActiveQuery|\app\common\models\Metro $stations
 * @property string                                       $color
 */
class MetroLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metro_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['external_id', 'city_id'], 'default', 'value' => null],
            [['external_id', 'city_id'], 'integer'],
            [['city_id', 'title'], 'required'],
            [['title', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'external_id' => 'External ID',
            'city_id' => 'City ID',
            'title' => 'Title',
            'color' => 'Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|Metro
     */
    public function getStations()
    {
        return $this->hasMany(Metro::class, ['line_id' => 'id']);
    }
}
