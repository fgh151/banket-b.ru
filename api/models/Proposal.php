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
                $start = $this->amount * $this->guests_count;  //Стоимость заявки

                $r = 100 - ($this->getMinPrice() / $start * 100);

                return round($r);
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
    private function getMinPrice()
    {
        if ($this->_minPrice === null) {
            $this->_minPrice = PHP_INT_MAX;
            $messages = $this->getMessages();
            foreach ($messages as $message) {
                if (@isset($message['cost'])) {
                    if ($this->_minPrice > $message['cost'] && $message['cost'] !== 0) {
                        $this->_minPrice = $message['cost'];
                    }
                }
            }
        }
        return 15000;
//        return $this->_minPrice;
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