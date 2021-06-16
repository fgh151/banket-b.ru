<?php


namespace app\user\models;


use app\api\models\Proposal;
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

        $model = unserialize(base64_decode($session->get(self::SESSION_KEY)), ['allowed_classes' => self::class]);

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

        foreach ($input as $key => $value) {
            if ($this->canSetProperty($key)) {
                $this->setAttribute($key, $value);
            }
        }
    }
}
