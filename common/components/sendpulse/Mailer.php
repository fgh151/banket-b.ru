<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-21
 * Time: 11:08
 */

namespace app\common\components\sendpulse;


use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;
use yii\mail\BaseMailer;
use yii\mail\MessageInterface;

class Mailer extends BaseMailer
{

    public $api_user;
    public $api_secret;

    public $messageClass = Message::class;

    /**
     * Sends the specified message.
     * This method should be implemented by child classes with the actual email sending logic.
     * @param MessageInterface $message the message to be sent
     * @return bool whether the message is sent successfully
     */
    protected function sendMessage($message)
    {
        $SPApiClient = new ApiClient(
            $this->api_user,
            $this->api_secret,
            new FileStorage(
                \Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR
            )
        );

        $email = array(
            'html' => '<p>Hello!</p>',
            'text' => 'Hello!',
            'subject' => 'Mail subject',
            'from' => array(
                'name' => 'From Fedor',
                'email' => 'noreply@banket-b.ru',
            ),
            'to' => array(
                array(
                    'name' => 'Fedor reciewer',
                    'email' => 'fedor@support-pc.org',
                ),
            ),
        );

        $result = $SPApiClient->smtpSendMail($email);

        var_dump($result);
        die;

        // TODO: Implement sendMessage() method.
    }
}