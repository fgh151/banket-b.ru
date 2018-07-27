<?php
/**
 * @var $this yii\web\View
 * @var $model \app\common\models\Proposal
 */

$ru_month = ['Января', 'Февраля', 'Марта', 'Апреля', 'Майя', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];
$en_month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

/** @var \app\common\components\Formatter $formatter */
$formatter = Yii::$app->formatter;
?>

<div class="col-md-4 proposal-item">
    <header>
        <div class="col-xs-6">#<?= $model->id ?></div>
        <div class="col-xs-6"></div>
    </header>
    <article>

        <h4 class="text-center">Дата банкета</h4>
        <h3 class="text-center">
            <?= str_replace($en_month, $ru_month, $model->getWhen()->format('d F Y в H:i')) ?>
        </h3>
        <h4 class="text-center">Банкет (<?= $model->getEventType() ?>)</h4>
        <p class="text-center">
            На <?= $model->guests_count ?> персон по <?= $model->amount ?>p.
        </p>
    </article>
    <footer class="proposal-footer" onclick="$('#more<?= $model->id ?>').toggle()">
        <div class="col-xs-6">Подробнее</div>
        <div class="col-xs-6 text-right">
            <i class="glyphicon glyphicon-menu-down"></i>
        </div>
    </footer>
    <footer class="extendet" id="more<?= $model->id ?>">

        <table class="table">
            <tr>
                <td>
                    Кухня
                </td>
                <td>
                    <?= $model->getCuisineString() ?>
                </td>
            </tr>
            <tr>
                <td>
                    Отдельный зал
                </td>
                <td>
                    <?= $formatter->asTrue($model->private) ?>
                </td>
            </tr>
            <tr>
                <td>
                    Танцпол
                </td>
                <td>
                    <?= $formatter->asTrue($model->dance) ?>
                </td>
            </tr>
            <tr>
                <td>
                    Свой алкоголь
                </td>
                <td>
                    <?= $formatter->asTrue($model->own_alcohol) ?>
                </td>
            </tr>
            <tr>
                <td>
                    Парковка
                </td>
                <td>
                    <?= $formatter->asTrue($model->parking) ?>
                </td>
            </tr>

            <?= $model->comment ?>
        </table>
        <?= \yii\helpers\Html::a('Перейти', ['conversation/index', 'proposalId' => $model->id]); ?>
    </footer>
</div>