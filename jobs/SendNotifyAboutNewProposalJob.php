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
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;
use Yii;
use yii\base\BaseObject;
use yii\helpers\Url;
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
        $recipients = Organization::find()
            ->where(['state' => Constants::ORGANIZATION_STATE_PAID])
            ->andFilterWhere(['unsubscribe' => true])
            ->andFilterWhere(['NOT ILIKE', 'email', 'banket-b.ru'])
            ->all();
        $emails = [];
        foreach ($recipients as $user) {


            $emails[] = [
                'email' => $user->email,
                'variables' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'proposal_link' => 'https://banket-b.ru/conversation/index/' . $this->proposal->id,
                    'un_url' => Url::to(['site/unsubscribe', 'uid' => $user->id, 'hash' => $user->getHash()], true)
                ]
            ];
        }

        //Добавляем Ресторанный рейтинг
        $emails[] = [
            'email' => 'zkzrr@yandex.ru',
            'variables' => [
                'name' => 'Ресторанный рейтинг',
                'email' => 'zkzrr@yandex.ru',
                'proposal_link' => 'https://banket-b.ru/conversation/index/' . $this->proposal->id,
                'un_url' => Url::to(['site/unsubscribe', 'uid' => 1, 'hash' => 111], true)
            ]
        ];

        $SPApiClient = new ApiClient(
            'e0cedb31c08e3bbaff55bd25a8e603d8',
            '0ddd68fdee59c75829462da7f2a26c26',
            new FileStorage(
                Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR
            )
        );

        $book = $SPApiClient->createAddressBook('Уведомление о заявке № ' . $this->proposal->id);
        $SPApiClient->addEmails($book->id, $emails);

        $SPApiClient->createCampaign(
            'Banket-b',
            'noreply@banket-b.ru',
            'Новая заявка',
            self::SENDPULSE_TEMPLATE_ID,
            $book->id,
            'Уведомление о заявке № ' . $this->proposal->id,
            '',
            '',
            true
        );
    }
}