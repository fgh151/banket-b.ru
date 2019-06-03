<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 13.02.2019
 * Time: 15:14
 */

namespace app\console\controllers;

use app\common\models\Proposal;
use Yii;
use yii\console\Controller;


///home/banketb/www/yii push/send15
///home/banketb/www/yii push/send120
class PushController extends Controller
{

    public function actionSend15()
    {

        $this->timer(15, 16, 'Ваша заявка находиться на рассмотрении', 'Ожидайте ответов от ресторанов', 'send15');
    }

    private function timer($minMinutes, $maxMinutes, $title, $message, $field)
    {
        $currentTime = new \DateTime();

        $minTime = $currentTime->modify('-' . $minMinutes . ' minutes')->getTimestamp();
        $maxTime = $currentTime->modify('-' . $maxMinutes . ' minutes')->getTimestamp();

        /** @var Proposal[] $proposals */
        $proposals = Proposal::find()
            ->where(['between', 'created_at', $maxTime, $minTime])
            ->andFilterWhere([$field => true])
            ->all();


        echo ($maxTime + $minTime) / 2 . "\n";

        var_dump($proposals);

        foreach ($proposals as $proposal) {
            $proposal->{$field} = false;
            $proposal->save(false);
            if (empty($proposal->getAnswers())) {
                Yii::$app->push->send($proposal->owner, $title, $message);
            }
        }
    }

    public function actionSend120()
    {
        $this->timer(120, 121, 'Ваша заявка находиться на рассмотрении', 'Ожидайте ответов от ресторанов', 'send120');
    }

}