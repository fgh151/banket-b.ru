<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-23
 * Time: 12:20
 * @var \app\api\models\Proposal[] $proposals
 * @var DateTime $startDate
 */

use app\common\components\MonthHelper;
use app\common\models\Proposal;

?>

<h1>Банкетные заявки</h1>
<h2>Период: <?= mb_strtolower(MonthHelper::formatDate($startDate, 'F Y', 2)) ?></h2>
<table>
    <tr>
        <th>Дата заявки</th>
        <th>Дата мероприятия</th>
        <th>Время</th>
        <th>Тип мероприятия</th>
        <th>
            Персон всего
        </th>
        <th>Стоимость на одного</th>
        <th>Сумма заявки</th>
    </tr>
    <?php foreach ($proposals as $proposal): ?>
        <tr>
            <td>
                <?= (new \DateTime())->setTimestamp($proposal->created_at)->format('d m Y') ?>
            </td>
            <td><?= $proposal->date ?></td>
            <td><?= $proposal->time ?></td>
            <td><?= Proposal::typeLabels()[$proposal->type] ?></td>
            <td><?= $proposal->guests_count ?></td>
            <td><?= $proposal->amount ?></td>
            <td><?= $proposal->guests_count * $proposal->amount ?></td>
        </tr>
    <?php endforeach; ?>
</table>