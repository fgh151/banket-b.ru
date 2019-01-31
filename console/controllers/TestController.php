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
use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message as FCMMessage;
use paragraph1\phpFCM\Notification;
use paragraph1\phpFCM\Recipient\Device;
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
        print_r(Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo('fedor@support-pc.org')
            ->setSubject('banket-b')
            ->setTextBody('banket-b')
//            ->queue();
            ->send());
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


    public function actionPush()
    {
        $client = new Client();
        $client->setApiKey(Yii::$app->params['firebaseServerKey']);
        $client->injectHttpClient(new \GuzzleHttp\Client());

        $note = new Notification(time() . 'Новое сообщение ', 'У вас новое сообщение, привет!');
        $note->setIcon('ic_launcher')
            ->setColor('#ffffff')
            ->setBadge(1);

        $message = new FCMMessage();
        $message->addRecipient(new Device($this->getToken()));
        $message->setNotification($note)
            ->setData(array('someId' => 111));

        $response = $client->send($message);
        var_dump($response);
    }

    private function getToken()
    {
        //Android
        $t = 'drhSJB5Fq1Q:APA91bGk0Nx30hR7sz0Ujbv-87u22RP6_ejwMzTmdOoqT-QBhMP8sPCekz0Zap79p_1wUDPFnoUijU1lzkNZP4SyGj0Mfz3-7OGHhuzpsUV1mqQ-4Qt2IPLxtMIP6BUvwapadKstVvWD';
        //IOS
//        $t = 'fQ8n05Ph6Nk:APA91bGO5BNiW8ooVgQ3XCyY3-QPwIWcO_CXmOwGykvABESLPVwAF27HQd2MSC9NgIyzq137Ot4X5jBhGaXJiQNfBh0ythwIWtO8DphDGYnKQqhFOrgkRU3c60HPtb03wTv-asJkEhwD';
        //IOS APNS
//        $t = 'F3642A5F86D3CBD3D0A80DE1EA3FE459CCE284355AD679C0C1881C20BE841D19';
        return $t;
    }
}