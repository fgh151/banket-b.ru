<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 10.12.2018
 * Time: 16:35
 */

namespace app\jobs;

use app\common\components\Constants;
use app\common\models\Message;
use app\common\models\Organization;
use app\common\models\Proposal;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

class RRMessageJob extends BaseObject implements JobInterface
{

    /** @var Proposal */
    public $proposal;

    /**
     * @param Queue $queue which pushed and is handling the job
     */
    public function execute($queue)
    {
        $message = new Message();
        $message->organization_id = Constants::RR_ORGANIZATION_ID;
        $message->proposal_id = $this->proposal->id;
        $message->user_id = $this->proposal->owner_id;
        $message->author_class = Organization::class;
        $message->message = $this->proposal->owner->name . ', спасибо за оставленную заявку. 
        В ближайшее время мы подберем для Вас предложение. Ваш персональный менеджер по телефону ' . getenv('SUPPORT_PHONE');

        $message->save();
    }
}