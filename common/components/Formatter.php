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

}