<?php


namespace app\common\components;


use app\common\models\MobileUser;
use app\common\models\OauthSocial;
use Yii;
use yii\authclient\BaseOAuth;

class OauthClient
{

    public static function getUserFromRemote(BaseOAuth $client): MobileUser
    {
        $handler = 'handler' . self::get_class_name(get_class($client));

        return self::$handler($client);
    }

    private static function get_class_name($classname)
    {
        if ($pos = strrpos($classname, '\\')) {
            return substr($classname, $pos + 1);
        }
        return $pos;
    }

    private static function handlerYandex(BaseOAuth $client): MobileUser
    {
        $attributes = $client->getUserAttributes();
        /** @var OauthSocial $exist */
        $exist = OauthSocial::find()->where(['source' => 'yandex', 'source_id' => $attributes['client_id']])->one();
        if ($exist !== null) {
            return $exist->user;
        }
        $user = new MobileUser();
        $user->phone = time();
        $user->generateAuthKey();
        $user->setPassword(Yii::$app->getSecurity()->generateRandomString());
        $user->email = $attributes['default_email'];
        $user->created_at = $user->updated_at = time();
        $user->status = Constants::USER_STATUS_ACTIVE;
        $user->name = $attributes['real_name'];
        $user->save();

        $social = new OauthSocial();
        $social->user_id = $user->id;
        $social->source = 'yandex';
        $social->source_id = $attributes['client_id'];
        $social->save();

        var_dump($social->errors);
        die;

        return $user;
    }
}
