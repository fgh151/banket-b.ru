<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-23
 * Time: 11:30
 */

namespace app\cabinet\widgets;


use app\api\models\Organization;
use DateInterval;
use DatePeriod;
use DateTime;
use yii\base\Widget;

class Report extends Widget
{

    /** @var Organization */
    public $organization;

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
        $regDate->setTimestamp($this->organization->created_at);
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