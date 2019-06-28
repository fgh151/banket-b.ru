<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 10.02.2019
 * Time: 9:26
 */

namespace app\api\models;


use app\common\models\Message;
use app\common\models\Proposal as CommonProposal;
use yii\helpers\ArrayHelper;

class Proposal extends CommonProposal
{

    private $_messages;

    public function fields()
    {
        $parent = parent::fields();

        return ArrayHelper::merge($parent, [
            'minPrice' => function () {
                return $this->getMinCost();
            },
            'profit' => function () {
                return CommonProposal::getProfit($this);
            },
            //Количество ставок
            'answers' => function () {
                return count($this->getMessages());
            },
            //Общее кол-во сообщений
            'messages' => function () {
                $result = 0;
                $messages = $this->getMessages();
                foreach ($messages as $org => $messagesArray) {
                    $result += count($messagesArray);
                }
                return $result;
            },
            'key' => function ($model) {
                return (string)$model->id;
            }
        ]);

    }

    /**
     * @return array
     */
    private function getMessages()
    {
        if ($this->_messages === null) {
            $this->_messages = Message::findAll($this->owner_id, $this->id);
        }
        return $this->_messages;
    }

    /**
     * @param array $data
     * @param null $formName
     * @return bool
     * @throws \Exception
     */
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