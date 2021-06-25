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

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function handlerYandex(BaseOAuth $client): MobileUser
    {
        return self::handele($client, 'yandex', 'default_email', 'client_id', 'real_name');
    }

    private static function handlerGoogle(BaseOAuth $client): MobileUser
    {
        return self::handele($client, 'google');
    }

    private static function handlerFacebook(BaseOAuth $client): MobileUser
    {
        return self::handele($client, 'facebook');
    }

    private static function handlerVKontakte(BaseOAuth $client): MobileUser
    {
        return self::handele($client, 'vkontakte', '', 'user_id', 'first_name');
    }

    private static function handele(
        BaseOAuth $client,
        $socialName,
        $emailAttr = 'email',
        $idAttr = 'id',
        $nameAttr = 'name'
    ): MobileUser {
        $attributes = $client->getUserAttributes();

        /** @var OauthSocial $exist */
        $exist = OauthSocial::find()->where(['source' => $socialName, 'source_id' => $attributes[$idAttr]])->one();
        if ($exist !== null) {
            return $exist->user;
        }
        $user = new MobileUser();
        $user->phone = time();
        $user->generateAuthKey();
        $user->setPassword(Yii::$app->getSecurity()->generateRandomString());
        $user->email = $attributes[$emailAttr] ?? time() . '@' . $socialName . '.com';
        $user->created_at = $user->updated_at = time();
        $user->status = Constants::USER_STATUS_ACTIVE;
        $user->name = $attributes[$nameAttr];
        $user->save();

        $social = new OauthSocial();
        $social->user_id = $user->id;
        $social->source = $socialName;
        $social->source_id = $attributes[$idAttr];
        $social->save();

        return $user;
    }
}
