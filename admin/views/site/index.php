<?php

/**
 * @var $this yii\web\View
 * @var $organization \app\common\models\Organization
 * @var $dataProvider \yii\data\ActiveDataProvider
 *
 * @var $byDay array
 * array(2) {
 * ["Friday   "]=>
 * int(4)
 * ["Tuesday  "]=>
 * int(1)
 * }
 *
 * @var $byHours array
 */

use dosamigos\chartjs\ChartJs;


$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?php /*
    <div class="row">
        <div class="col-xs-12">
            <?= Report::widget()?>
        </div>
    </div> */ ?>
    <div class="row">
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение входящих заявок по дням недели</h3>
            <?= ChartJs::widget([
                'type' => 'pie',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_keys($byDay),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по дням недели",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byDay)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
</div>
