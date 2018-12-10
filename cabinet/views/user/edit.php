<?php
/**
 * @var                                 $this \yii\web\View
 * @var \app\common\models\Organization $model
 * @var \app\common\models\District[] $districts
 * @var \app\common\models\Metro $metro
 * @var \app\common\models\Metro[] $metros
 * @var \app\common\models\RestaurantParams $params
 * @var \app\common\models\RestaurantHall[] $halls
 */

use app\common\models\Proposal;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<div class="profile-edit">
    <?php $form = ActiveForm::begin(['id' => 'update']); ?>

<?= $form->field($model, 'name'); ?>
<?= $form->field($model, 'address')->textarea(); ?>
    <?= $form->field($model, 'district_id')->dropDownList($districts); ?>
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.metro-items',
        // required: css class selector
        'widgetItem' => '.metro',
        // required: css class
        'limit' => 666,
        // the maximum times, an element can be cloned (default 999)
        'min' => 0,
        // 0 or 1 (default 1)
        'insertButton' => '.add-metro',
        // css class
        'deleteButton' => '.remove-metro',
        // css class
        'model' => $metro[0],
        'formId' => 'update',
        'formFields' => [
            'metro_id',
        ],
    ]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Ближайшие станции метро
                <button type="button" class="add-metro btn btn-success btn-sm pull-right"><i
                            class="glyphicon glyphicon-plus"></i></button>
            </h4>
        </div>
        <div class="panel-body">
            <div class="metro-items"><!-- widgetContainer -->
                <?php foreach ($metro as $i => $metroStation): ?>
                    <div class="metro panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Добавить станцию метро по
                                близости</h3>
                            <div class="pull-right">
                                <!--                                    <button type="button"-->
                                <!--                                            class="add-metro btn btn-success btn-xs"><i-->
                                <!--                                                class="glyphicon glyphicon-plus"></i></button>-->
                                <button type="button"
                                        class="remove-metro btn btn-danger btn-xs"><i
                                            class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (!$metroStation->isNewRecord) {
                                echo Html::activeHiddenInput($metroStation, "[{$i}]id");
                            }
                            ?>

                            <?= $form->field($metroStation,
                                "[{$i}]metro_id")->dropDownList($metros); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>
<?= $form->field($model, 'contact'); ?>
<?= $form->field($model, 'phone'); ?>
    <?php /*= $form->field($model, 'email');*/ ?>
    <?php /*= $form->field($model, 'password')->label('Изменить пароль'); */ ?>

    <?php if ($model->isRestaurant()) : ?>
        <?= $form->field($params, 'ownAlko')->checkbox(); ?>
        <?= $form->field($params, 'scene')->checkbox(); ?>
        <?= $form->field($params, 'dance')->checkbox(); ?>
        <?= $form->field($params, 'parking')->checkbox(); ?>
        <?= $form->field($params, 'amount')->input('number'); ?>
        <?= $form->field($model, 'image_field')->fileInput()->label('Добавить картинку'); ?>

        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper_hall',
            // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items',
            // required: css class selector
            'widgetItem' => '.item',
            // required: css class
            'limit' => 40,
            // the maximum times, an element can be cloned (default 999)
            'min' => 1,
            // 0 or 1 (default 1)
            'insertButton' => '.add-item',
            // css class
            'deleteButton' => '.remove-item',
            // css class
            'model' => $halls[0],
            'formId' => 'update',
            'formFields' => [
                'title',
                'size',
            ],
        ]); ?>
        <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($halls as $i => $hall): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Добавить зал</h3>
                        <div class="pull-right">
                            <button type="button"
                                    class="add-item btn btn-success btn-xs"><i
                                        class="glyphicon glyphicon-plus"></i></button>
                            <button type="button"
                                    class="remove-item btn btn-danger btn-xs"><i
                                        class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$hall->isNewRecord) {
                            echo Html::activeHiddenInput($hall, "[{$i}]id");
                        }
                        ?>
                        <?= $form->field($hall, "[{$i}]title")->input('text',
                            ['maxlength' => true]) ?>
                        <?= $form->field($hall, "[{$i}]size")->input('number',
                            ['maxlength' => true]) ?>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>

        <?= $form->field($model,
            'cuisine_field[]')->widget(\kartik\select2\Select2::class, [
            'data' => Proposal::cuisineLabels(),
            'options' => [
                'placeholder' => 'Выберите кухни',
                'multiple' => true
            ],
        ])->label('Кухня'); ?>
    <?php endif; ?>

<?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>


<?php ActiveForm::end() ?>
</div>