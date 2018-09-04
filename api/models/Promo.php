<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 03.09.2018
 * Time: 7:24
 */

namespace app\api\models;


use app\common\models\PromoStatistic;

class Promo extends \app\common\models\Promo
{

    public function afterFind()
    {
        $stat = new PromoStatistic();
        $stat->promo_id = $this->id;
        $stat->created_at = time();
        $stat->save();

        parent::afterFind();
    }


    public function getImage()
    {
        return '/'.$this->image;
    }
}