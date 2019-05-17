<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-15
 * Time: 17:42
 */

namespace app\common\components\verifyemail;


use yii\base\Exception;

/**
 * verifyEmail exception handler
 */
class verifyEmailException extends Exception
{

    /**
     * Prettify error message output
     * @return string
     */
    public function errorMessage()
    {
        $errorMsg = $this->getMessage();
        return $errorMsg;
    }

}