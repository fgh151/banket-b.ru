<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 27.07.18
 * Time: 16:10
 */

namespace app\common\components;


class Formatter extends \yii\i18n\Formatter
{

    public $trueFormat = [
        '<i class="glyphicon glyphicon-remove"></i>',
        '<i class="glyphicon glyphicon-ok"></i>',
    ];

    public function asTrue($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        return $value ? $this->trueFormat[1] : $this->trueFormat[0];
    }

    public static function make_links_clickable($text)
    {
        return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
    }

}