<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 11.01.2019
 * Time: 14:15
 */

namespace app\api\versions\v2\models;


use app\common\components\Constants;
use app\common\components\Model;
use app\common\models\MobileUser;
use Yii;

/**
 *
 * @property \app\common\models\MobileUser|null $user
 */
class Auth extends Model
{

    const SCENARIO_SMS = 'sms';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    /** @var string */
    public $phone;
    /** @var string */
    public $name;
    /** @var string */
    public $code;
    /** @var MobileUser */
    private $_user;

    public function scenarios()
    {
        return [
            self::SCENARIO_SMS => ['phone'],
            self::SCENARIO_LOGIN => ['phone', 'code'],
            self::SCENARIO_REGISTER => ['phone', 'code', 'name'],
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['phone', 'name', 'code'], 'required'],
            [['phone', 'name', 'code'], 'string'],
            ['name', 'trim']
        ];
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function login()
    {
        if ($this->validate() && $this->validateCode()) {
            return Yii::$app->user->login($this->getUser(), 3600 * 24 * 30);
        }

        return false;
    }

    /**
     * @return bool
     */
    public function validateCode()
    {
        return $this->code == $this->getCode();
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getCode()
    {
        $user = $this->getUser();
        if ($user instanceof MobileUser) {
            if ($user->password_reset_token === null) {
                $user->generatePasswordResetToken();
                $user->save();
            }
            return $user->password_reset_token;

        }

        return null;
    }

    /**
     * Finds user by [[username]]
     *
     * @return MobileUser|null
     * @throws \yii\base\Exception
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = MobileUser::findByPhone($this->phone);
        }

        if ($this->_user === null && $this->scenario === self::SCENARIO_SMS) {
            $this->_user = $this->createUser() ?: null;
        }

        return $this->_user;
    }

    /**
     * @return MobileUser|array
     * @throws \yii\base\Exception
     */
    private function createUser()
    {
        $user = new MobileUser();
        //TODO: remove it!
        $user->email = time() . '@restorate.ru';

        $user->name = $this->name;
        $user->phone = $this->phone;
        $user->setPassword(Yii::$app->security->generateRandomString());
        $user->generateAuthKey();
        $user->created_at = $user->updated_at = time();
        $user->status = Constants::USER_STATUS_ACTIVE;
        $user->generatePasswordResetToken();

        return $user->save() ? $user : $user->errors;
    }

}