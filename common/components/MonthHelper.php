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
    static function formatDate(\DateTime $date)
    {
        return str_replace(self::getEnMonths(), self::getRuMonths(), $date->format('d F'));
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

    static function getRuMonths()
    {
        return [
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
        ];
    }
}