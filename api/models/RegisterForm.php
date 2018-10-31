<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 14.05.17
 * Time: 8:58
 */

namespace app\api\models;


use app\common\components\Constants;
use app\common\models\MobileUser;
use yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $email;
    public $password;
    public $name;
    public $phone;

    /**
     * @var $user MobileUser
     */
    private $user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => MobileUser::class, 'targetAttribute' => 'email'],
            [['name', 'phone'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('app', 'Email'),
            'password' => \Yii::t('app', 'Password')
        ];
    }

    /**
     * @return bool
     * @throws yii\base\Exception
     */
    public function register()
    {
        $user = new MobileUser();
        $user->email = $this->email;
        $user->name = $this->name;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->created_at = $user->updated_at = time();
        $user->status = Constants::USER_STATUS_ACTIVE;


        return $user->save() ? $user->getAuthKey() : $user->errors;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600*24*30);
        }
        return false;
    }


    /**
     * Finds user by [[username]]
     *
     * @return MobileUser|null
     */
    public function getUser()
    {
        if ($this->user === null) {
            $this->user = MobileUser::findByUsername($this->email);
        }
        return $this->user;
    }

    /**
     * @return null|string
     */
    public function getAuthKey()
    {
        if ($this->user === false) {
            return $this->user->auth_key;
        }
        return null;
    }

}