<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 23.07.18
 * Time: 10:11
 */

namespace app\console\controllers;


use app\api\models\Organization;
use app\common\components\Constants;
use yii\console\Controller;

class UserController extends Controller
{

    public function actionTestAdmin()
    {
        $admin = new Organization();
        $admin->email = 'test@example.com';
        $admin->setPassword('test');
        $admin->generateAuthKey();

        $admin->state = Constants::ORGANIZATION_STATE_PAID;
        $admin->status = Constants::USER_STATUS_ACTIVE;
        $admin->name = 'test';
        $admin->address = 'addr';
        $admin->contact = 'dd';
        $admin->phone = '11';

        $admin->created_at = time();

        $admin->updated_at = time();

        $admin->save();

        print_r($admin->errors);
    }

}