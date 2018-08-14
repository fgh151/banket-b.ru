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

    <div class="row">
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по дням недели</h3>
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
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по часам</h3>
            <?= ChartJs::widget([
                'type' => 'bar',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_keys($byHours),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по часам",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byHours)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по месяцам</h3>
            <?= ChartJs::widget([
                'type' => 'bar',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_keys($byMonth),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по месяцам",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byMonth)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по стоимости</h3>
            <?= ChartJs::widget([
                'type' => 'line',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_keys($byPrice),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по стоимости",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byPrice)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по количеству людей</h3>
            <?= ChartJs::widget([
                'type' => 'line',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_keys($byPeoples),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по гостям",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byPeoples)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по отдельным залам</h3>
            <?= ChartJs::widget([
                'type' => 'pie',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_keys($byHall),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по отдельным залам",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byHall)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по танцполу</h3>
            <?= ChartJs::widget([
                'type' => 'pie',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_keys($byDance),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по танцполу",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byDance)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по алкоголю</h3>
            <?= ChartJs::widget([
                'type' => 'pie',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_keys($byAlko),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по танцполу",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byAlko)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по парковке</h3>
            <?= ChartJs::widget([
                'type' => 'pie',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_keys($byParking),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по танцполу",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byParking)
                        ],
                    ]
                ]
            ]);
            ?>
        </div> <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по кухне</h3>
            <?= ChartJs::widget([
                'type' => 'bar',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_values(\app\common\models\Proposal::cuisineLabels()),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по кухне",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byCuisine)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-md-4" style="background-color: #fff">
            <h3>Распределение заявок по типам</h3>
            <?= ChartJs::widget([
                'type' => 'bar',
                'options' => [
                    'height' => 400,
                    'width' => 500
                ],
                'data' => [
                    'labels' => array_values(\app\common\models\Proposal::typeLabels()),
                    'datasets' => [
                        [
                            'label' => "Распределение заявок по кухне",
                            'backgroundColor' => ["rgba(179,181,198,0.2)", 'red', 'blue','white', 'green', 'brown', 'yellow'],
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => array_values($byTypes)
                        ],
                    ]
                ]
            ]);
            ?>
        </div>
    </div>

</div>
