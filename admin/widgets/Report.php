<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-23
 * Time: 11:30
 */

namespace app\admin\widgets;


use DateInterval;
use DatePeriod;
use DateTime;
use yii\base\Widget;

class Report extends Widget
{

    public function run()
    {
        return $this->render('report', [
            'dates' => $this->getReportDates()
        ]);
    }

    private function getReportDates()
    {
        $result = [];
        $regDate = new \DateTime();
        $regDate->setTimestamp(1546300800); //1.1.2019
        $start = $regDate->modify('first day of this month');
        $end = (new DateTime())->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {

            $result[] = $dt->format('m-Y');
        }
        return $result;
    }

}