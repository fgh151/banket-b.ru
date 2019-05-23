<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-23
 * Time: 11:32
 *
 * @var $dates array
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>


<?php foreach ($dates as $date) : ?>
    <?= Html::a($date, Url::to(['report/index', 'date' => $date]), ['class' => 'btn btn-default']); ?>
<?php endforeach; ?>
