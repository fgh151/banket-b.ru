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

class Organization extends \app\common\models\Organization
{
    /**
     * Для вычисления выгоды
     * @var Proposal
     */
    public $proposal;
    /** @var Message[]|null */
    private $_conversation;

    public function fields()
    {
        $parent = parent::fields();

        return ArrayHelper::merge($parent, [
            'minPrice' => function () {
                return Organization::getMinPrice($this);
            },
            'profit' => function () {
                if ($this->proposal) {
                    return Proposal::getProfit($this);
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
            'lastMessage' => function () {
                if ($this->proposal) {
                    return $this->getLastMessageTime();
                }
                return null;
            },
            'messages' => function () {
                return count($this->getConversation());
            },
            'phone' => function () {
                return $this->organization_phone;
            }
        ]);

    }

    /**
     * @param Organization $organization
     * @return int
     * @throws \yii\db\Exception
     */
    public static function getMinPrice(Organization $organization)
    {
        $min = Proposal::getMinCostForRestaurant($organization->proposal, $organization->id);

        if ($min === null) {
            return $organization->proposal->amount * $organization->proposal->guests_count;
        }
        return $min;
    }

    /**
     * @return int
     */
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