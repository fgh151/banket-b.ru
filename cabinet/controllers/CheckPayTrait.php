<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 08.08.2018
 * Time: 12:01
 */

namespace app\cabinet\controllers;


use app\common\components\Constants;
use app\common\components\NotPayException;
use app\common\models\Organization;
use Yii;

trait CheckPayTrait
{

    /**
     *
     * @throws \Throwable
     */
    public function throwIfNotPay()
    {
        /** @var Organization $user */
        $user = Yii::$app->getUser()->getIdentity();
        if ($user->state === Constants::ORGANIZATION_STATE_FREE) {
            throw new NotPayException();
        }
    }

}