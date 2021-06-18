<?php

namespace app\common\models;

use app\common\components\behaviors\FileUploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $created_at
 * @property string $title
 * @property string $alias
 * @property string $preview_text
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 *
 * @property-read string $imagePath
 * @property-read \yii\db\ActiveQuery|\app\common\models\Upload $image
 * @property string $content
 *
 *
 */
class Blog extends ActiveRecord
{
    public $image_field;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'image_field'], 'safe'],
            [['title', 'alias'], 'required'],
            [['preview_text', 'content', 'seo_title', 'seo_keywords', 'seo_description'], 'string'],
            [['title', 'alias'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'slugAttribute' => 'alias',
                'attribute' => 'title'
            ],
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'image_field',
                'storageClass' => BlogImage::class,
                'storageAttribute' => 'blog_id',
                'folder' => 'blog',
                'path' => '@user'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'title' => 'Title',
            'alias' => 'Alias',
            'preview_text' => 'Preview Text',
            'content' => 'Content',
        ];
    }

    /**
     * @return ActiveQuery| Upload[]
     * @throws \yii\base\InvalidConfigException
     */
    public function getImage()
    {
        return $this->hasOne(Upload::class, ['id' => 'upload_id'])
            ->viaTable(BlogImage::tableName(), ['blog_id' => 'id']);
    }

    public function getImagePath()
    {
        return '/upload/blog/' . $this->id . '/' . $this->image->fsFileName;
    }
}
