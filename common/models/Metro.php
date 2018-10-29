<?php

namespace app\common\models;

/**
 * This is the model class for table "metro".
 *
 * @property int $id
 * @property string $external_id
 * @property int $line_id
 * @property string $title
 *
 * @property MetroLine $line
 */
class Metro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['line_id', 'title'], 'required'],
            [['line_id'], 'default', 'value' => null],
            [['line_id'], 'integer'],
            [['external_id', 'title'], 'string', 'max' => 255],
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
            'line_id' => 'Line ID',
            'title' => 'Title',
        ];
    }

    public function getLine()
    {
        return $this->hasOne(MetroLine::class, ['id' => 'line_id']);
    }

    public function fields()
    {
        return [
            'id', 'title',
            'color' => function (Metro $model) {
                return $model->line->color;
            }
        ];
    }
}
