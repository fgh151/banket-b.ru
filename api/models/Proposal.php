<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 10.02.2019
 * Time: 9:26
 */

namespace app\api\models;


use app\common\models\Message;
use yii\helpers\ArrayHelper;

class Proposal extends \app\common\models\Proposal
{


    private $_minPrice;

    private $_messages;

    public function fields()
    {
        $parent = parent::fields();

        return ArrayHelper::merge($parent, [
            'minPrice' => function ($model) {
                return $this->getMinPrice();
            },
            'profit' => function ($model) {
                return Organization::calcProfit($model, $this->getMinPrice());
            },
            'answers' => function ($model) {
                return count($this->getMessages());
            },
            'key' => function ($model) {
                return (string)$model->id;
            }
        ]);

    }

    /**
     * @return int
     */
    public function getMinPrice()
    {
        if ($this->_minPrice === null) {
            $this->_minPrice = PHP_INT_MAX;
            $messages = $this->getMessages();
            $min = [];
            foreach ($messages as $organizationId => $messagesByTime) {

                foreach ($messagesByTime as $message) {
                    if ($message->cost > 0) {
                        $min[] = $message->cost;
                    }
                }
            }
            if (!empty($min)) {
                $this->_minPrice = min($min);
            } else {
                $this->_minPrice = null;
            }
        }
        return $this->_minPrice;
    }

    private function getMessages()
    {
        if ($this->_messages === null) {
            $this->_messages = Message::findAll($this->owner_id, $this->id);
        }
        return $this->_messages;
    }

    public function load($data, $formName = null)
    {


        $load = parent::load($data, $formName);
        if ($load) {
            $ru_month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
            $en_month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

            $this->date = str_replace($ru_month, $en_month, $this->date);
            $this->date = (new \DateTime($this->date))->format('Y-m-d');


        }
        return $load;
    }

}