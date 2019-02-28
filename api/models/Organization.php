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
                return $this->getMinPrice();
            },
            'profit' => function ($model) {
                $start = $this->proposal->amount * $this->proposal->guests_count;  //Стоимость заявки

                $r = 100 - ($this->getMinPrice() / $start * 100);

                return round($r) ?? 0;
            },
            'amount' => function () {
                return $this->proposal->amount;
            },
            'guests' => function () {
                return $this->proposal->guests_count;
            },
            'rating',
            'lastMessage' => function ($model) {
                return $this->getLastMessageTime();
            }
        ]);

    }

    /**
     * @return int
     * @throws NotFoundHttpException
     */
    private function getMinPrice()
    {
//        if ($this->_minPrice === null) {
//            $this->_minPrice = PHP_INT_MAX;
//            $messages = $this->getConversation();
//            foreach ($messages as $organizationId => $messagesArray) {
//                foreach ($messagesArray as $message) {
//
//                    var_dump($message);
//
//                    if ($this->_minPrice > $message->cost && $message->cost !== 0 && $message->cost !== null) {
//                        $this->_minPrice = $message->cost;
//                    }
//                }
//            }
//        }
//        die;
        return 15000; // $this->_minPrice;
    }

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