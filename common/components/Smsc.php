<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-13
 * Time: 12:07
 */


namespace app\common\components;

include_once "smsc_api.php";

use yii\base\Component;

class Smsc extends Component implements SmsInterface
{

    /**
     * @param $text string
     * @param $phone string
     * @return mixed
     */
    public function sendSms($text, $phone)
    {
        return send_sms($phone, $text);

    }
}