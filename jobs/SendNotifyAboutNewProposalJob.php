<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-22
 * Time: 13:45
 */

namespace app\jobs;


use app\common\models\Proposal;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

class SendNotifyAboutNewProposalJob extends BaseObject implements JobInterface
{
    protected const SENDPULSE_TEMPLATE_ID = 34755;
    /** @var Proposal */
    public $proposal;

    /**
     * @param Queue $queue which pushed and is handling the job
     * @throws \Exception
     */
    public function execute($queue)
    {
        if (!in_array($this->proposal->owner_id, [134, 178, 182, 119, 133])) {
            $this->proposal->sendNotify();
        }
    }
}