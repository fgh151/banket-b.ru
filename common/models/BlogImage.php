<?php

namespace app\common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "blog_image".
 *
 * @property int $id
 * @property int $blog_id
 * @property int $upload_id
 */
class BlogImage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_id', 'upload_id'], 'required'],
            [['blog_id', 'upload_id'], 'default', 'value' => null],
            [['blog_id', 'upload_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blog_id' => 'Blog ID',
            'upload_id' => 'Upload ID',
        ];
    }
}
