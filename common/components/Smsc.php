<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-13
 * Time: 12:07
 */


namespace app\common\components;


use integready\smsc\SMSCenter;
use Yii;
use yii\base\Component;

class Smsc extends Component implements SmsInterface
{
    /**
     * @var SMSCenter
     */
    private $gateway;

    public function init()
    {
        $this->gateway = Yii::$app->SMSCenter;
        parent::init();
    }

    /**
     * @param $text string
     * @param $phone string
     * @return mixed
     */
    public function sendSms($text, $phone)
    {
        $this->gateway->send($phone, $text);
    }
}