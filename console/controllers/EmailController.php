<?php
/**
 * Created by IntelliJ IDEA.
 * User: fgorsky
 * Date: 2019-07-24
 * Time: 14:34
 */

namespace app\console\controllers;


use yii\console\Controller;
use yii\swiftmailer\Mailer;

class EmailController extends Controller
{

    public function actionExist()
    {

        $restaurants = [
//            ['Plennica@mail.ru', 'cau116rest8'],
//            ['mihost77@mail.ru', 'grand264evr8rest'], ?????
//            ['roman_kramari@mail.ru', 'Ger265din8rest'],
//            ['elena.skachkova@bk.ru', 'Fish_2018'],
//            ['Knyazhischeva@yandex.ru', 'grmos122rest8'],
//            ['maria.chernukho@gmail.com', 'erw266rek8rest'],
//            ['avp.386@gmail.com', 'kop289tilnya8rest'],
//            ['r.ilrosso@rambler.ru', 'ros263so8rest'],
//            ['alesya-gyreeva@yandex.ru', 'cha268cha8rest'],
//            ['innaizotova.ru@gmailcom', 'sib259eria8rest'],
//            ['bakinskiy.bulvar19@gmail.com', 'resto19km'],
//            ['d_umrykhin@icloud.com', 'the269y8rest'],
//            ['altkaterina@gmail.com', 'dry270wet8rest'],
//            ['anyaborisenko@yandex.ru', 'avia271tor8rest'],
//            ['uryuk.vernadka@yandex.ru', 'ur63rest8'],
//            ['rovshanberdyev@mail.ru', 'ros58rest8'],
//            ['olesya-rich888@mail.ru', 'cha273cha8rest'],
//            ['muh-@mail.ru', 'andy291fr8rest'],
//            ['andreeva.ponton@gmail.com', 'di275di8rest'],
//            ['Infо@bаbеl.msk.ru', 'bab84rest8'],
//            ['dimson3@mail.ru', 'bbc7rest8'],
//            ['6876965_69@mail.ru', 'bul227rest8'],
//            ['Lesher@ecle.ru', 'bronz278lev8rest'],
//            ['1121424@mail.ru', 'ver279ron8rest'],
//            ['variruk.tag.dir@fmrest.com', 'ruk293kkola8rest'],
//            ['dr.mamagochi@fmrest.com', 'mam292gochi8rest '],
//            ['Tanya.albion@mail.ru', 'аbr282e8rest'],
//            ['salondl@yandex.ru', 'kur283e8rest'],
//            ['botikpetra@mail.ru', 'BotP284e8rest'],
//            ['castledish1@mail.ru', 'cas285e8rest'],
//            ['zadelin-81@mail.ru', 'madm286e8rest'],
//            ['vijay.work@mail.ru', 'arg287e8rest'],
//            ['kaminski2@mail.ru', 'acha288cha8rest'],
//            ['y.y.danilov1@gmail.com', 'vill290pasta8rest'],
//            ['Restoranblackthai@mail.ru', 'bla10rest81'],
//            ['Atmov.1@gmail.com', 'oxs230rest8'],
//            ['fedor@support-pc.org', 'cau116rest8'],
        ];

//        $restaurants = [
//            ['mihost77@mail.ru', 'grand264evr8rest']
//        ];


        foreach ($restaurants as $restaurant) {


            /** @var Mailer $mailer */
            $mailer = \Yii::$app->mailer;
            $mailer->htmlLayout = 'layouts/blank';
            echo $restaurant[0] . "\n";

            print_r($mailer
                ->compose('start', ['restaurant' => $restaurant])
                ->setTo($restaurant[0])
                ->setSubject('Банкет Батл')
                ->setFrom(getenv('MAIL_FROM'))
                ->send());

            sleep(10);
        }

    }

}