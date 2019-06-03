<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 13.02.2019
 * Time: 15:32
 */

namespace app\common\components;

use app\common\models\MobileUser;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message as FCMMessage;
use paragraph1\phpFCM\Notification;
use paragraph1\phpFCM\Recipient\Device;
use Psr\Http\Message\ResponseInterface;
use Yii;
use yii\base\Component;

class Push extends Component
{

    /**
     * @param MobileUser $user
     * @param $title
     * @param $message
     * @return array
     */
    public function send(MobileUser $user, $title, $message)
    {
        $userTokens = $user->pushTokens;
        $r = [];
        foreach ($userTokens as $token) {
            $r[$token->token] = $this->sendToUser($title, $message, $token->token);
        }
        return $r;
    }

    /**
     * @param $title
     * @param $message
     * @param $token
     * @return ResponseInterface | Response
     */
    private function sendToUser($title, $message, $token)
    {
        Yii::info('send push to ' . $token);
        $client = new Client();
        $client->setApiKey(Yii::$app->params['firebaseServerKey']);
        $client->injectHttpClient(new GuzzleClient());

        $note = new Notification($title, $message);
        $note->setIcon('ic_launcher')
            ->setColor('#ffffff')
            ->setBadge(1);

        $message = new FCMMessage();
        $message->addRecipient(new Device($token));
        $message->setNotification($note)
            ->setData(array('someId' => 111));

        return $client->send($message);
    }

}