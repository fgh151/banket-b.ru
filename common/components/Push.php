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
     * @param array $data
     * @return array
     */
    public function send(MobileUser $user, $title, $message, $data = [])
    {
        $userTokens = $user->pushTokens;
        $r = [];
        foreach ($userTokens as $token) {
            $r[$token->token] = $this->sendToUser($title, $message, $token->token, $data);
        }
        return $r;
    }

    /**
     * @param $title
     * @param $message
     * @param $token
     * @param array $data
     * @return ResponseInterface | Response
     */
    private function sendToUser($title, $message, $token, $data = [])
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
        $message->addRecipient(new Device($token))
            ->setNotification($note)
            ->setData($data);

        return $client->send($message);
    }

}