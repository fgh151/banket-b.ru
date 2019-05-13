<?php
namespace app\cabinet\models;

use app\common\components\Constants;
use app\common\components\validators\ConfirmPassword;
use app\common\models\geo\GeoCity;
use app\common\models\Organization;
use app\common\models\OrganizationLinkActivity;
use yii\base\Model;
use yii\validators\ExistValidator;

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

    public $activities = [];

    public $url;

    public $city_id;

    public $district_id;

    public $image_field;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            [['name','address', 'contact', 'phone', 'confirm_password', 'activities'], 'required'],
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

            [['url'], 'safe'],
            [
                'city_id',
                ExistValidator::class,
                'targetClass'     => GeoCity::class,
                'targetAttribute' => 'id'
            ],
            ['district_id', 'integer'],
            ['image_field', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'             => 'Название организации',
            'address'          => 'Адрес',
            'contact'          => 'Контактное лицо',
            'phone'            => 'Контактный телефон',
            'confirm_password' => 'Пароль еще раз',
            'password'         => 'Пароль',
            'activities'       => 'Деятельность компании',
            'url' => 'Веб - сайт',
            'city_id'          => 'Город',
            'district_id' => 'Район',
            'email' => 'Электронная почта'
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
        $user->created_at  = time();
        $user->updated_at  = time();
        $user->status      = Constants::USER_STATUS_ACTIVE;
        $user->state       = Constants::ORGANIZATION_STATE_FREE;
        $user->url         = $this->url;
        $user->city_id     = $this->city_id;
        $user->district_id = $this->district_id;
//        $user->image_field = $this->image_field;

        $saved = $user->save();

        if ($saved && !empty($this->activities)) {
            foreach ($this->activities as $activity) {
                $link = new OrganizationLinkActivity();
                $link->organization_id = $user->id;
                $link->activity_id = $activity;
                $link->save();
            }
        }

        return  $saved ? $user : null;
    }
}
