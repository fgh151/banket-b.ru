<?php

namespace app\cabinet\controllers;

use app\common\models\Organization;
use app\common\models\OrganizationImage;
use app\common\models\Upload;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class MediaController extends Controller
{
    public function actionUpload($id)
    {
        $model = new Organization();

        $imageFile = UploadedFile::getInstance($model, 'image_field');

        $directory = Yii::getAlias('@cabinet/web/upload') . DIRECTORY_SEPARATOR . 'organization' . DIRECTORY_SEPARATOR . $id;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        if ($imageFile) {
            $fileBaseName = substr(md5(microtime() . rand(0, 9999)), 0, 8);
            $fileName = $fileBaseName . '_' . $id . '.' . $imageFile->extension;

            $imageFile->saveAs($directory . '/' . $fileName);
            $upload = new Upload();
            $upload->fsFileName = $fileName;
            $upload->save();

            $storage = new OrganizationImage();
            /** @var $storage OrganizationImage */
            $storage->organization_id = $id;
            $storage->upload_id = $upload->id;
            $storage->save();

            return Json::encode([
                'files' => [
                    [
                        'name' => $fileName,
                        'size' => $imageFile->size,
                        'url' => '/upload/organization/' . $id . '/' . $fileName,
                        'thumbnailUrl' => '/upload/organization/' . $id . '/' . $fileName,
                        'deleteUrl' => 'user/img-delete?id=' . $upload->id,
                        'deleteType' => 'POST',
                    ],
                ],
            ]);
        }

        return '';
    }
}
