<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 16.11.2018
 * Time: 15:48
 */

namespace app\console\controllers;


use app\common\components\Constants;
use app\common\models\Message;
use app\common\models\Organization;
use app\common\models\Proposal;
use Yii;
use yii\console\Controller;
use yii\queue\db\Queue;

class TestController extends Controller
{

    public function actionTest()
    {
        echo "test\n";
    }

    public function actionMail()
    {
        Yii::$app->mailqueue->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo('fedor@support-pc.org')
            ->setSubject('banket-b')
            ->setTextBody('banket-b')
            ->queue();
//->send();
    }

    public function actionQeue()
    {
        /** @var Queue $queue */
//        $queue = Yii::$app->queue;
        $proposal = Proposal::findOne(158);
//        $queue->delay(Yii::$app->params['autoAnswerDelay'])->push(new RRMessageJob(['proposal' => $proposal]));


        $message = new Message();
        $message->organization_id = Constants::RR_ORGANIZATION_ID;
        $message->proposal_id = $proposal->id;
        $message->user_id = $proposal->owner_id;
        $message->author_class = Organization::class;
        $message->message = $proposal->owner->name . ', спасибо за оставленную заявку. 
        В ближайшее время мы подберем для Вас предложение. Ваш персональный менеджер по телефону +7 495 788 0600';

        $message->save();
    }

}