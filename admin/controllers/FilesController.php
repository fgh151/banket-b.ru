<?php
/**
 * Created by IntelliJ IDEA.
 * User: fgorsky
 * Date: 2019-07-02
 * Time: 17:54
 */

namespace app\admin\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class FilesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => getenv('USER_URL') . '/upload/blog', // Directory URL address, where files are stored.
                'path' => '@user/web/upload/blog', // Or absolute path to directory where files are stored.
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => getenv('USER_URL') . '/upload/blog', // Directory URL address, where files are stored.
                'path' => '@user/web/upload/blog', // Or absolute path to directory where files are stored.
            ],
            'file-delete' => [
                'class' => 'vova07\imperavi\actions\DeleteFileAction',
                'url' => getenv('USER_URL') . '/upload/blog', // Directory URL address, where files are stored.
                'path' => '@user/web/upload/blog', // Or absolute path to directory where files are stored.
            ],
        ];
    }
}
