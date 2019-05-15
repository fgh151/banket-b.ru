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
use GuzzleHttp\Psr7\Uri;
use Kreait\Firebase\Database;
use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message as FCMMessage;
use paragraph1\phpFCM\Notification;
use paragraph1\phpFCM\Recipient\Device;
use Yii;
use yii\console\Controller;
use yii\queue\db\Queue;
use yii\swiftmailer\Mailer;

class TestController extends Controller
{

    public function actionTest()
    {
        echo "test\n";
    }

    public function actionMail()
    {

//        print_r(Yii::$app->mailqueue);
//        die;

        /** @var Mailer $m */
        $m = Yii::$app->testmailer;

        $m->getView()->params['recipient'] = Organization::findOne(1);

        $m->compose('proposal-html', [
            'proposal' => Proposal::findOne(74),
            'recipient' => Organization::findOne(1)
        ])
            ->setFrom('fedor@support-pc.org')
            ->setTo('fedor@support-pc.org')
            ->setSubject('banket-b test message')
            ->send();
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
        $t = 'cqyZsf5GjZQ:APA91bFgtJSyiMmFHaL7lucyhpFIXsYXWvRC_vQgtU9ZTU44RpQDfrTRP1gizsWH6DTkqnW2Mmbs_Zn4TzgfxLAGzWAXwjvAg-upOZBPSpc_RVr5l1tW1aCnvL3h_Dg-mskcm0EuqoCu';
        //IOS
//        $t = 'f5uiSdYpngA:APA91bGYbuX_SNaFnc2wTHfpS5oXgMU26Kp3-uOvVKThZauynK7icRR9zRqPseGNdvVpeL2AgNAKRog_ewJDciK6lUfzIm3pIO-L8asdCNG9WlteMXxEdJbZdhHvW_sAkxOFdw6t2NqT';
        //IOS APNS
//        $t = 'F3642A5F86D3CBD3D0A80DE1EA3FE459CCE284355AD679C0C1881C20BE841D19';
        return $t;
    }

    public function actionFirebase()
    {
        /** @var Database $database */
        $database = Yii::$app->firebase->getDatabase();

        $ref = $database
            ->getReference('/proposal_2/u_64/p_218/o_1')
            ->orderByChild('author_class')
            ->equalTo('app\common\models\Organization');

        $uri = $ref->getUri();
        $filter = new Uri('https://banket-b.firebaseio.com/' . $uri->getPath() . '?' . $uri->getQuery());

//        var_dump($filter);

//        $ref1 = $database->getReferenceFromUrl($filter);

//            ->getUri();
//            ->orderByChild('cost')
//            ->limitToLast(2);
        ;

//        $ref = $database->getReferenceFromUrl($firstFilterUri);
//        $ref->orderByChild('cost')
//            ->limitToLast(1)
//        ->getSnapshot();

        var_dump($ref->getValue());
    }

}