<?php
/**
 * Загрузка файлов
 */

namespace app\common\models;


use Yii;
use yii\db\ActiveRecord;


/**
 * Модель хранения загружаемых файлов.
 *
 * @property int $id
 * @property string $fsFileName
 * @property string $virtualFileName
 */
class Upload extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%upload}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fsFileName'], 'required'],
            [['fsFileName', 'virtualFileName'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fsFileName' => Yii::t('app', 'Fs File Name'),
            'virtualFileName' => Yii::t('app', 'Virtual File Name'),
        ];
    }
}
