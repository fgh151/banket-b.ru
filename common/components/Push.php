<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 13.02.2019
 * Time: 15:32
 */

namespace app\common\components;

use app\common\models\MobileUser;
use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message as FCMMessage;
use paragraph1\phpFCM\Notification;
use paragraph1\phpFCM\Recipient\Device;
use Yii;
use yii\base\Component;

class Push extends Component
{

    public function send(MobileUser $user, $title, $message)
    {
        $userTokens = $user->pushTokens;

        foreach ($userTokens as $token) {


//            var_dump($token->token);

            $this->sendToUser($title, $message, $token->token);

//            $client = new Client();
//            $client->setApiKey(Yii::$app->params['firebaseServerKey']);
//            $client->injectHttpClient(new \GuzzleHttp\Client());
//
//            $note = new Notification($title, $message);
//            $note->setIcon('ic_launcher')
//                ->setColor('#ffffff')
//                ->setBadge(1);
//
//            $message = new FCMMessage();
//            $message->addRecipient(new Device($token));
//            $message->setNotification($note)
//                ->setData(array('someId' => time()));
//
//            $response = $client->send($message);
//            return $response;
        }
    }


    private function sendToUser($title, $message, $token)
    {


        Yii::info('send push to ' . $token);
        $client = new Client();
        $client->setApiKey(Yii::$app->params['firebaseServerKey']);
        $client->injectHttpClient(new \GuzzleHttp\Client());

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