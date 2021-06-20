<?php
/**
 * Поведения моделей приложения
 */

namespace app\common\components\behaviors;

use app\common\models\Upload;
use yii\base\Behavior;
use yii\base\Exception;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Поведение для загрузки файлов
 * @package app\components\behaviors
 * @example
 *
 * ```php
 *public function behaviors()
 *{
 *    return [
 *        [
 *            'class' => FileUploadBehavior::class,
 *            'attribute' => 'photo_field',
 *            'storageClass' => UserLinkPhoto::class,
 *            'storageAttribute' => 'user_id',
 *            'folder' => 'user'
 *        ]
 *    ];
 *}
 * ```
 * @property Model $owner
 */
class FileUploadBehavior extends Behavior
{
    /** @var  string Класс связи с моделью */
    public $storageClass;
    /** @var  string Аттрибут модели, в котором храним связь */
    public $attribute;
    /** @var  string Путь к папке, где хранить файлы */
    public $folder;
    /** @var  string Аттрибут хранения */
    public $storageAttribute;
    /** @var  string Аттрибут хранения идентификатора */
    public $storageAttributeId = 'upload_id';

    public $path = '@cabinet';

    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'upload',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'upload'
        ];
    }

    /**
     * Загрузка файлов
     * @throws \InvalidArgumentException
     * @throws Exception
     * @throws \Exception
     */
    public function upload()
    {
        $files = UploadedFile::getInstances($this->owner, $this->attribute);
        $storageAttribute = $this->storageAttribute;
        $storageAttributeId = $this->storageAttributeId;

        foreach ($files as $file) {
            $path = $this->path . '/web/upload' . DIRECTORY_SEPARATOR . $this->folder . DIRECTORY_SEPARATOR . $this->owner->id;

            $path = \Yii::getAlias($path);

            FileHelper::createDirectory($path);

            $fileBaseName = substr(md5(microtime() . random_int(0, 9999)), 0, 8);
            $fileName = $fileBaseName . '_' . $this->owner->id . '.' . $file->extension;

            $file->saveAs($path . '/' . $fileName);
            $upload = new Upload();
            $upload->fsFileName = $fileName;
            $upload->save();

            $storage = new $this->storageClass();
            /** @var ActiveRecord $storage */
            $storage->$storageAttribute = $this->owner->id;
            $storage->$storageAttributeId = $upload->id;
            $storage->save();
        }
    }

}
