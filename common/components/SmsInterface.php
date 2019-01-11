<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 11.01.2019
 * Time: 14:28
 */

namespace app\common\components;


interface SmsInterface
{
    /**
     * @param $text string
     * @param $phone string
     * @return mixed
     */
    public function sendSms($text, $phone);
}