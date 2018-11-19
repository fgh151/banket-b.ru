<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 16.11.2018
 * Time: 15:48
 */

namespace app\console\controllers;


use Yii;
use yii\console\Controller;

class TestController extends Controller
{

    public function actionTest()
    {
        echo "test\n";
    }

    public function actionMail()
    {
        Yii::$app->mailqueue->compose()
            ->setFrom('fedor@support-pc.org')
            ->setTo('fedor@support-pc.org')
            ->setSubject('test')
            ->setTextBody('test')
            ->queue();

    }

}