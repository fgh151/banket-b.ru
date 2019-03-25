<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 08.10.2018
 * Time: 16:41
 */

namespace app\api\models;


use app\common\models\Message;
use app\common\models\Proposal;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class Organization extends \app\common\models\Organization
{
    /**
     * Для вычисления выгоды
     * @var Proposal
     */
    public $proposal;

    private $_minPrice;

    private $_conversation;

    public function fields()
    {
        $parent = parent::fields();

        return ArrayHelper::merge($parent, [
            'minPrice' => function ($model) {
                return Organization::getMinPrice($this);
            },
            'profit' => function ($model) {
                if ($this->proposal) {
                    return Organization::calcProfit($this->proposal, Organization::getMinPrice($this));
                }
                return null;
            },
            'amount' => function () {
                if ($this->proposal) {
                    return $this->proposal->amount;
                }
                return null;
            },
            'guests' => function () {
                if ($this->proposal) {
                    return $this->proposal->guests_count;
                }
                return null;
            },
            'rating',
            'lastMessage' => function ($model) {
                if ($this->proposal) {
                    return $this->getLastMessageTime();
                }
                return null;
            }
        ]);

    }

    public static function calcProfit(Proposal $proposal, $minPrice)
    {
        $start = $proposal->amount * $proposal->guests_count;  //Стоимость заявки

        $r = 100 - ($minPrice / $start * 100);

        return round($r) ?? 0;
    }

    /**
     * @param Organization $organization
     * @return int
     */
    public static function getMinPrice(Organization $organization)
    {
        $_minPrice = null;
        if ($organization->proposal) {
            $_minPrice = PHP_INT_MAX;
            $messages = $organization->getConversation();
            foreach ($messages as $message) {
                if ($_minPrice > $message->cost && $message->cost !== 0 && $message->cost !== null) {
                    $_minPrice = $message->cost;
                }
            }
        }
        return $_minPrice;
    }



    /**
     * @return int
     * @throws NotFoundHttpException
     */
//    public function getMinPrice()
//    {
//        if ($this->_minPrice === null && $this->proposal) {
//            $this->_minPrice = PHP_INT_MAX;
//            $messages = $this->getConversation();
//
////            var_dump($messages); die;
//
//
//            foreach ($messages as $message) {
//
//
//                if ($this->_minPrice > $message->cost && $message->cost !== 0 && $message->cost !== null) {
//                    $this->_minPrice = $message->cost;
//                }
//            }
//        }
////        die;
//        return $this->_minPrice;
//    }

    private function getLastMessageTime()
    {
        return min(array_keys($this->getConversation()));
    }

    /**
     * @return Message[]|null
     */
    private function getConversation()
    {
        if ($this->_conversation === null) {
            $this->_conversation = Message::getConversation($this->proposal->owner_id, $this->proposal->id, $this->id);
        }
        return $this->_conversation;
    }


}