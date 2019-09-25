<?php

use app\common\components\Constants;
use app\common\models\Activity;
use app\common\models\geo\GeoCity;
use app\common\models\Organization;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\common\models\Organization
 * @var $params \app\common\models\RestaurantParams
 * @var $form yii\widgets\ActiveForm
 * @var $districts array
 * @var $metro array
 * @var $metros array
 * @var $halls array
 */
?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(['id' => 'update']); ?>


    <?= $form->field($model, 'rating')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'organization_phone'); ?>

    <?= $form->field($model,
        'city_id')->dropDownList(ArrayHelper::map(GeoCity::find()->select([
        'id',
        'title'
    ])->asArray()->all(), 'id', 'title'),
        ['id' => 'city_id', 'readonly' => true, 'disabled' => 'disabled'])->label('Город'); ?>

    <?= $form->field($model, 'district_id')->dropDownList($districts); ?>


    <?= $form->field($model, 'status')->dropDownList([
        Constants::USER_STATUS_ACTIVE => 'Активный',
        Constants::USER_STATUS_DELETED => 'Удаленный'
    ]) ?>

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

    <!--    --><?php //var_dump($model->activity_field);?>

    <?= $form->field($model,
        'activity_field')->dropDownList(ArrayHelper::map(Activity::find()->select([
        'id',
        'title'
    ])->asArray()->all(), 'id', 'title'), ['multiply', 'prompt' => ''])->label('Вид деятельности'); ?>

    <?= $form->field($params, 'ownAlko')->checkbox(); ?>
    <?= $form->field($params, 'scene')->checkbox(); ?>
    <?= $form->field($params, 'dance')->checkbox(); ?>
    <?= $form->field($params, 'parking')->checkbox(); ?>
    <?= $form->field($params, 'amount')->input('number'); ?>

    <?php if ($model->images) : ?>
        <div class="row">
            <?php foreach ($model->images as $image) : ?>
                <div class="panel panel-default col-xs-12 col-md-2">
                    <div class="panel-body">
                        <?= Html::img('https://banket-b.ru/upload/organization/' . $model->id . '/' . $image->fsFileName, ['class' => 'img-responsive']); ?>
                        <?= Html::a('Удалить', ['organization/img-delete', 'id' => $image->id]); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'image_field')->fileInput()->label('Добавить новую картинку'); ?>

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


    <?= $form->field($model, 'state')->dropDownList(Organization::stateLabels()) ?>
    <?= $form->field($model, 'state_direct')->dropDownList(Organization::stateLabels()) ?>

    <?= $form->field($model, 'state_promo')->dropDownList(Organization::stateLabels()) ?>

    <?= $form->field($model, 'state_statistic')->dropDownList(Organization::stateLabels()) ?>


    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
