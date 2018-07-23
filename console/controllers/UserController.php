<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 23.07.18
 * Time: 10:11
 */

namespace app\console\controllers;


use app\common\models\User;
use yii\console\Controller;

class UserController extends Controller
{

    public function actionTestAdmin()
    {
        $admin = new User();
        $admin->email = 'test@example.com';
        $admin->setPassword('test');
        $admin->generateAuthKey();

        $admin->created_at = time();

        $admin->updated_at = time();

        $admin->save();




        print_r($admin->errors);
    }

}