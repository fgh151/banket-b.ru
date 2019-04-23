<?php

use app\common\models\Proposal;
use yii\widgets\ListView;

/**
 * @var $this \yii\web\View
 * @var Proposal $currentProposal
 * @var Proposal $nextProposal
 * @var int $key
 * @vra int $index
 * @var ListView $list
 */
?>

<?php if ($currentProposal->isActual() !== ($nextProposal && $nextProposal->isActual())) : ?>
    <div class="col-xs-12">
        Закрытые заявки
    </div>
<?php endif; ?>
