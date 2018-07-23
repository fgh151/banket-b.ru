<?php
namespace app\cabinet\models;

use app\common\components\Constants;
use app\common\components\validators\ConfirmPassword;
use app\common\models\Organization;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;

    public $address;
    public $contact;
    public $phone;

    public $confirm_password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            [['name','address', 'contact', 'phone', 'confirm_password'], 'required'],
            ['name', 'unique', 'targetClass' => 'app\common\models\Organization', 'message' => 'This name has already been taken.'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\common\models\Organization', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],


            ['confirm_password', ConfirmPassword::class, 'second_argument' => 'password'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return Organization|null the saved model or null if saving fails
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Organization();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->address = $this->address;
        $user->phone = $this->phone;
        $user->contact = $this->contact;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->created_at = time();
        $user->updated_at = time();
        $user->status     = Constants::USER_STATUS_ACTIVE;


        return  $user->save() ? $user : null;
    }
}
