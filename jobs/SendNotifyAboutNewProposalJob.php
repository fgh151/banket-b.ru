<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-22
 * Time: 13:45
 */

namespace app\jobs;


use app\common\components\Constants;
use app\common\models\Organization;
use app\common\models\Proposal;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;
use yii\swiftmailer\Mailer;

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
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo('zkzrr@yandex.ru')
            ->setSubject('Новая заявка')
            ->setHtmlBody('В разделе заявок появилась новая заявка <a href="https://admin.banket-b.ru/proposal/update/' . $this->proposal->id . '">посмотреть</a>')
            ->send();

        $recipients = Organization::find()
            ->where(['state' => Constants::ORGANIZATION_STATE_PAID])
            ->andFilterWhere(['unsubscribe' => true])
            ->andFilterWhere(['NOT ILIKE', 'email', 'banket-b.ru'])
            ->all();
        foreach ($recipients as $recipient) {


            /** @var Mailer $mailer */
            $mailer = Yii::$app->mailer;

            $mailer->getView()->params['recipient'] = $recipient;

            /** @var \Swift_Message $message */
            $mailer->compose('proposal-html', [
                'proposal' => $this,
                'recipient' => $recipient
            ])->setFrom('noreply@banket-b.ru')
                ->setTo($recipient->email)
                ->setSubject('Новая заявка')
                ->send();
        }
    }
}