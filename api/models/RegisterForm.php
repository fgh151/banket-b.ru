<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 14.05.17
 * Time: 8:58
 */

namespace app\api\models;


use app\common\models\MobileUser;
use yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $email;
    public $password;

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
            ['email', 'email']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app', 'Email'),
            'password' => \Yii::t('app', 'Password')
        ];
    }

    /**
     * @return bool
     * @throws yii\base\Exception
     */
    public function register()
    {
        $this->user = new MobileUser();
        $this->user->email = $this->email;
        $this->user->setPassword($this->password);
        $this->user->auth_key = \Yii::$app->security->generateRandomString();
        $this->user->created_at = $this->user->updated_at = time();
        $this->user->phone = time();
        $this->user->save();

        var_dump($this->user->errors);

        return $this->user->save();
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
        if ($this->user === false) {
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
            return $this->user->authKey;
        }
        return null;
    }

}