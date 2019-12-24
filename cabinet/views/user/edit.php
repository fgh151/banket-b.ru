<?php
/**
 * @var $this View
 * @var Organization $model
 * @var District[] $districts
 * @var Metro $metro
 * @var Metro[] $metros
 * @var RestaurantParams $params
 * @var RestaurantHall[] $halls
 */

use app\common\models\District;
use app\common\models\Metro;
use app\common\models\Organization;
use app\common\models\RestaurantHall;
use app\common\models\RestaurantParams;
use dosamigos\fileupload\FileUploadUI;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


?>
    <div class="profile-edit">
        <?php $form = ActiveForm::begin(['id' => 'update']); ?>

        <?= $form->field($model, 'unsubscribe')->checkbox(); ?>
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
                    <button type="button" class="add-metro btn btn-success btn-sm pull-right">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                </h4>
            </div>
            <div class="panel-body">
                <div class="metro-items"><!-- widgetContainer -->
                    <?php foreach ($metro as $i => $metroStation): ?>
                        <div class="metro panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">
                                    Добавить станцию метро по близости
                                </h3>
                                <div class="pull-right">
                                    <!--                                    <button type="button"-->
                                    <!--                                            class="add-metro btn btn-success btn-xs"><i-->
                                    <!--                                                class="glyphicon glyphicon-plus"></i></button>-->
                                    <button type="button" class="remove-metro btn btn-danger btn-xs">
                                        <i class="glyphicon glyphicon-minus"></i>
                                    </button>
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

                                <?= $form->field($metroStation, "[{$i}]metro_id", ['options' => ['class' => 'js-metro-select']])
                                    ->widget(Select2::class, [
                                        'data' => $metros,
                                        'options' => ['placeholder' => 'Выберите станцию ...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php DynamicFormWidget::end(); ?>
        <?= $form->field($model, 'contact'); ?>
        <?= $form->field($model, 'phone'); ?>
        <?= $form->field($model, 'organization_phone'); ?>
        <?php /*= $form->field($model, 'email');*/ ?>
        <?= $form->field($model, 'password')->label('Изменить пароль'); ?>

        <?php if ($model->isRestaurant()): ?>
            <?= $form->field($params, 'ownAlko')->checkbox(); ?>
            <?= $form->field($params, 'scene')->checkbox(); ?>
            <?= $form->field($params, 'dance')->checkbox(); ?>
            <?= $form->field($params, 'parking')->checkbox(); ?>
            <?= $form->field($params, 'amount')->input('number'); ?>


            <p>Наилучший размер фотографий для загрузки 800 x 600 пикселей</p>
            <?= FileUploadUI::widget([
                'model' => $model,
                'attribute' => 'image_field',
                'url' => ['media/upload', 'id' => $model->id],
                'gallery' => false,
                'fieldOptions' => [
                    'accept' => 'image/*'
                ],
                'clientOptions' => [
                    'maxFileSize' => 2000000
                ],
                // ...
                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
                    'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
                ],
            ]); ?>

            <?php if ($model->images): ?>
                <div class="row">
                    <?php foreach ($model->images as $image): ?>
                        <div class="panel panel-default col-xs-12 col-md-2">
                            <div class="panel-body">
                                <?= Html::img('/upload/organization/' . $model->id . '/' . $image->fsFileName, ['class' => 'img-responsive']); ?>
                                <?= Html::a('Удалить', ['user/img-delete', 'id' => $image->id]); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

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
                                <button type="button" class="add-item btn btn-success btn-xs">
                                    <i class="glyphicon glyphicon-plus"></i>
                                </button>
                                <button type="button" class="remove-item btn btn-danger btn-xs">
                                    <i class="glyphicon glyphicon-minus"></i>
                                </button>
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
        <?php endif; ?>

        <?= $form->field($model, 'description')->textarea(); ?>

        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>

        <?php ActiveForm::end() ?>
    </div>

<?php
$js = <<<JS
window.initSelect2Loading = function(id, optVar){
    initS2Loading(id, optVar);
    $('.js-metro-select select').last().val('');
};

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    e.preventDefault();
    $('.js-metro-select select').last().val('');
});
JS;

$this->registerJs($js);
