<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-23
 * Time: 12:20
 * @var \app\api\models\Organization[] $organizations
 * @var DateTime $startDate
 * @var DateTime $endDate
 */

use app\common\components\MonthHelper;

$total = 0;
?>

    <h1>Банкетные заявки</h1>
    <h2>Период: <?= mb_strtolower(MonthHelper::formatDate($startDate, 'F Y', 2)) ?></h2>
    <table>
        <tr>
            <th>Организация</th>
            <th>Количество заявок</th>
        </tr>
        <?php foreach ($organizations as $organization): ?>
            <tr>
                <td>
                    <?= $organization->name ?>
                </td>
                <td>
                    <?php
                    $searchModel = $organization->proposal_search;
                    $query = $searchModel->search([]);
                    $proposals = $query->query
                        ->andFilterWhere(['between', 'created_at', $startDate->getTimestamp(), $endDate->getTimestamp()])
                        ->orderBy('created_at')
                        ->count();

                    $total += $proposals;
                    echo $proposals;
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    ИТОГО: <?= $total ?>