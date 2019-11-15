<?php

namespace app\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

class SendFeedbackNotifyJob extends BaseObject implements JobInterface
{
    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     */
    public function execute($queue)
    {
        Yii::$app->mailer->compose()
            ->setFrom('noreply@banket-b.ru')
            ->setTo('pr7880600@gmail.com')
            ->setSubject('Новой сообщение в обратной связи banket-b')
            ->setHtmlBody('<a href="https://admin.banket-b.ru/feedback/index/' . $this->id . '">посмотреть</a>')
            ->send();
    }

}