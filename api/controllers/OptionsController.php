<?php


namespace app\api\controllers;


use yii\rest\Controller;
use yii\rest\OptionsAction;

class OptionsController extends Controller
{

    public function actions()
    {
        return [
            'index' => OptionsAction::class
        ];
    }
}
