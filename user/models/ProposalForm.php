<?php


namespace app\user\models;


use app\common\components\Constants;
use app\common\models\MobileUser;
use app\common\models\Proposal;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ProposalForm extends Proposal implements \Serializable
{

    private const SESSION_KEY = 'proposal-form-session';
    public $email;
    public $phone;
    public $name;

    public static function hasDataInStore(): bool
    {
        $session = \Yii::$app->getSession();
        return (boolean)$session->get(self::SESSION_KEY, false);
    }

    public static function clearStore()
    {
        $session = \Yii::$app->getSession();
        $session->remove(self::SESSION_KEY);
    }

    public static function restoreOrCreate(): ProposalForm
    {
        $session = \Yii::$app->getSession();

        $model = unserialize(base64_decode($session->get(self::SESSION_KEY)), ['allowed_classes' => [self::class]]);

        if ($model === false) {
            $model = new self();
        }

        return $model;
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                ['email', 'phone', 'name'],
                'required',
                'when' => function () {
                    return \Yii::$app->getUser()->getIsGuest();
                }
            ]
        ]);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->email !== null && $this->phone !== null && $this->email !== null) {
            $user = new MobileUser();
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->name = $this->name;
            $user->generateAuthKey();
            $user->setPassword(Yii::$app->getSecurity()->generateRandomString());
            $user->created_at = $user->updated_at = time();
            $user->status = Constants::USER_STATUS_ACTIVE;
            $user->save();
            Yii::$app->getUser()->login($user, 3600 * 6 * 6);
        }

        $this->owner_id = Yii::$app->getUser()->getId();


        return parent::save($runValidation, $attributeNames);
    }

    public function store()
    {
        $session = \Yii::$app->getSession();
        $session->set(self::SESSION_KEY, base64_encode(serialize($this)));
        return true;
    }

    public function serialize()
    {
        return Json::encode($this);
    }

    public function unserialize($data)
    {
        $input = Json::decode($data);
        $this->setAttributes($input);
    }
}
