<?php
/**
 * Created by IntelliJ IDEA.
 * User: fgorsky
 * Date: 2019-07-24
 * Time: 14:34
 */

namespace app\console\controllers;


use yii\console\Controller;

class EmailController extends Controller
{

    public function actionExist()
    {

        $body = 'Уважаемые партнеры!<br />
<p>Торговая платформа Банкет Батл - это первый мобильный маркетплейс для получения заявок на проведение банкетных мероприятий без посредников.</p>
<p>Вы получили это письмо, потому что ваш ресторан зарегестрирован на данной платформе. Теперь вы можете принимать участие в банкетных аукционах, получая заявки и отслеживая их статистику.</p>
<p>Обращаем ваше внимание, что уведомление о новых входящих заявках на банкет приходят к вам на почту, а общение с гостем осуществляется в чате маркетплейса в вашем личном кабинете. Более подробная информация о Банкет Батл в презентации. Перед работой с личным кабинетом рекомендуем ознакомиться также с инструкцией.</p>
<p>Ссылка для входа в личный кабинет: <a href="https://banket-b.ru/">https://banket-b.ru/</a></p>';

        $restaurants = [
            ['Plennica@mail.ru', 'cau116rest8'],
            ['mihost77@mail.ru ', 'grand264evr8rest'],
            ['roman_kramari@mail.ru', 'Ger265din8rest'],
            ['elena.skachkova@bk.ru', 'Fish_2018'],
            ['Knyazhischeva@yandex.ru', 'grmos122rest8'],
            ['maria.chernukho@gmail.com', 'erw266rek8rest'],
            ['avp.386@gmail.com', 'kop289tilnya8rest'],
            ['r.ilrosso@rambler.ru', 'ros263so8rest'],
            ['alesya-gyreeva@yandex.ru', 'cha268cha8rest'],
            ['innaizotova.ru@gmailcom', 'sib259eria8rest'],
            ['bakinskiy.bulvar19@gmail.com', 'resto19km'],
            ['d_umrykhin@icloud.com', 'the269y8rest'],
            ['altkaterina@gmail.com', 'dry270wet8rest'],
            ['anyaborisenko@yandex.ru', 'avia271tor8rest'],
            ['uryuk.vernadka@yandex.ru', 'ur63rest8'],
            ['rovshanberdyev@mail.ru', 'ros58rest8'],
            ['olesya-rich888@mail.ru', 'cha273cha8rest'],
            ['muh-@mail.ru', 'andy291fr8rest'],
            ['andreeva.ponton@gmail.com', 'di275di8rest'],
            ['Infо@bаbеl.msk.ru', 'bab84rest8'],
            ['dimson3@mail.ru', 'bbc7rest8'],
            ['6876965_69@mail.ru', 'bul227rest8'],
            ['Lesher@ecle.ru', 'bronz278lev8rest'],
            ['1121424@mail.ru', 'ver279ron8rest'],
            ['variruk.tag.dir@fmrest.com', 'ruk293kkola8rest'],
            ['dr.mamagochi@fmrest.com', 'mam292gochi8rest '],
            ['Tanya.albion@mail.ru', 'аbr282e8rest'],
            ['salondl@yandex.ru', 'kur283e8rest'],
            ['botikpetra@mail.ru', 'BotP284e8rest'],
            ['castledish1@mail.ru', 'cas285e8rest'],
            ['zadelin-81@mail.ru', 'madm286e8rest'],
            ['vijay.work@mail.ru', 'arg287e8rest'],
            ['kaminski2@mail.ru', 'acha288cha8rest'],
            ['y.y.danilov1@gmail.com', 'vill290pasta8rest'],
            ['Restoranblackthai@mail.ru', 'bla10rest81'],
            ['Atmov.1@gmail.com', 'oxs230rest8']
        ];

//        $restaurants = [
//            ['fedor@support-pc.org', 'cau116rest8'],
//        ];


        foreach ($restaurants as $restaurant) {

            $body .= '
            <p>Ваш логин ' . $restaurant[0] . '</p>
            <p>Ваш пароль ' . $restaurant[1] . '</p>
            <p><a href="https://banket-b.ru/instruction.pdf">Инструкция по использованию</a> </p>
            <p><a href="https://banket-b.ru/presentation.pdf">Презентация сервиса</a> </p>
            <p>Удачных батлов</p>
<p>С наилучшими пожеланиями, команда компании-разаработчика</p>
<p>ООО «Ресторанный Рейтинг-МСК»</p>
            ';

            print_r(\Yii::$app->mailer
                ->compose()
                ->setTo($restaurant[0])
                ->setSubject('Банкет Батл')
                ->setFrom('noreply@banket-b.ru')
                ->setHtmlBody($body)
                ->send());
        }

    }

}