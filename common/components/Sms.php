<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 11.01.2019
 * Time: 14:23
 */

namespace app\common\components;


use yii\base\Component;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

class Sms extends Component
{


    public function sendSms($text, $phone)
    {
        return $this->sendIntenal(
            $text,
            $phone,
            '0012c0439ade32a5c19974d4053b22f8',
            'ac2ea781ced8dd8a479849addcd758a6'
        );
    }


    /**
     * @param $text
     * @param $phone
     * @param $key
     * @param $secret
     *
     * @return boolean
     * @throws Exception
     */
    private function sendIntenal($text, $phone, $key, $secret)
    {
        $smsParams = [
            'datetime' => '',
            'key' => $key,
            'sender' => 'restorate',
            'sms_lifetime' => 1,
            'type' => 2,

        ];

        $resultParams = ArrayHelper::merge($smsParams, [
            'phone' => $phone,
            'text' => $text
        ]);

        $hash = $this->getSum($resultParams, $secret);
        $resultParams['sum'] = $hash;

        $Curl = curl_init();
        $CurlOptions = [
            CURLOPT_URL => 'http://api.myatompark.com/sms/3.0/sendSMS',
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_POST => true,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_POSTFIELDS => $resultParams,
        ];
        curl_setopt_array($Curl, $CurlOptions);
        if (false === ($Result = curl_exec($Curl))) {
            throw new Exception('Http request failed');
        }

        curl_close($Curl);

        return $Result;
    }

    private function getSum($options, $secret)
    {
        $sumParams = [
            'action' => 'sendSMS',
            'version' => '3.0'
        ];
        $resultParams = ArrayHelper::merge($options, $sumParams);
        ksort($resultParams);
        $resultString = '';

        foreach ($resultParams as $param) {
            $resultString .= $param;
        }
        $resultString .= $secret;
        return md5($resultString);
    }
}