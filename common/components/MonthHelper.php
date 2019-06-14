<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-04-30
 * Time: 15:52
 */

namespace app\common\components;


class MonthHelper
{
    static function formatDate(\DateTime $date, $format = 'd F', $case = 1)
    {
        return str_replace(self::getEnMonths(), self::getRuMonths($case), $date->format($format));
    }

    static function formatDateWithYear(\DateTime $date, $format = 'd F Y', $case = 1)
    {
        if ($date->format('Y') == date('Y')) {
            $format = str_replace(' Y', '', $format);
        }
        return str_replace(self::getEnMonths(), self::getRuMonths($case), $date->format($format));
    }

    static function getEnMonths()
    {
        return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
    }

    static function getRuMonths($case = 1)
    {
        $ru = [
            1 => [
                'Января',
                'Февраля',
                'Марта',
                'Апреля',
                'Мая',
                'Июня',
                'Июля',
                'Августа',
                'Сентября',
                'Октября',
                'Ноября',
                'Декабря'
            ],
            2 => [
                'Январь',
                'Февраль',
                'Март',
                'Апрель',
                'Май',
                'Июнь',
                'Июль',
                'Август',
                'Сентябрь',
                'Октябрь',
                'Ноябрь',
                'Декабрь'
            ]
        ];

        return $ru[$case];
    }
}