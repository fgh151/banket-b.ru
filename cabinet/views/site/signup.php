<?php

/**
 * @var $this yii\web\View
 *
 * @var $form yii\bootstrap\ActiveForm *
 * @var $model \app\cabinet\models\SignupForm
 * @var $modelParams \app\common\models\RestaurantParams
 * @var $halls \app\common\models\RestaurantHall[]
 * @var $metro \app\common\models\OrganizationLinkMetro[]
 */

use app\common\models\Activity;
use app\common\models\geo\GeoCity;
use app\common\models\Proposal;
use kartik\depdrop\DepDrop;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="site-signup">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Для регистрации заполните форму ниже:</p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>


                <?= $form->field($model,
                    'city_id')->dropDownList(ArrayHelper::map(GeoCity::find()->select([
                    'id',
                    'title'
                ])->asArray()->all(), 'id', 'title'),
                    ['id' => 'city_id', 'prompt' => 'Выбрать...']); ?>

                <?= $form->field($model, 'district_id')->widget(DepDrop::class, [
                    'options' => ['id' => 'district_id'],
                    'pluginOptions' => [
                        'depends' => ['city_id'],
                        'placeholder' => 'Выбрать...',
                        'url' => Url::to(['/site/district'])
                    ],
                    'pluginEvents' => [
                        "depdrop:afterChange" => "function(event, id, value) { changeMetroSelector(); }",
                    ]
                ]); ?>



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
                    'formId' => 'form-signup',
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
                                            "[{$i}]metro_id")->dropDownList([], ['class' => 'js-metro-select form-control'
                                        ]); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php DynamicFormWidget::end(); ?>

                <?= $form->field($model, 'address')->textarea() ?>

                <?= $form->field($model, 'contact') ?>
                <?= $form->field($model, 'phone')->widget(MaskedInput::class,
                    ['mask' => '+7 (999) 999-99-99']) ?>

                <?= $form->field($model,
                    'activities[]')->dropDownList(ArrayHelper::map(Activity::find()->select([
                    'id',
                    'title'
                ])->asArray()->all(), 'id', 'title'), ['multiply', 'prompt' => '']); ?>

                <div id="js-more" style="display:none">

                    <?= $form->field($model, 'image_field')->fileInput()->label('Добавить картинку'); ?>

                    <?= $form->field($modelParams, 'ownAlko')->checkbox(); ?>
                    <?= $form->field($modelParams, 'scene')->checkbox(); ?>
                    <?= $form->field($modelParams, 'dance')->checkbox(); ?>
                    <?= $form->field($modelParams, 'parking')->checkbox(); ?>
                    <?= $form->field($modelParams, 'amount')->input('number'); ?>

                    <?= $form->field($model,
                        'cuisine[]')->widget(\kartik\select2\Select2::class, [
                        'data' => Proposal::cuisineLabels(),
                        'options' => [
                            'placeholder' => 'Выберите кухни',
                            'multiple' => true
                        ],
                    ]); ?>

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
                        'formId' => 'form-signup',
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
                </div>

                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'url') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'confirm_password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться',
                        ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>


<?php
$selectId = Html::getInputId($model, 'activities');
$js = <<<JS

$('#$selectId').change(function(e) {
    const selector = $(this);
    
    console.log(selector.val());
    
    if (selector.val() == 1) {
        $('#js-more').show();
    } else {
        
        $('#js-more').hide();
    }
});

function changeMetroSelector(){
   
    const selectors = $('.js-metro-select');
    const city = $('#city_id').val();
    
    selectors.find('option').remove();
    
    $.ajax({
  method: "POST",
  dataType: "json",
  url: '/site/metro',
  data:{"depdrop_all_params[city_id]": city, "depdrop_parents[0]": city},
  success:  function(data) {
            data.output.forEach(function(el) {
              selectors.append('<option value="'+el.id+'">'+el.name+'</option>')
            })
        }
});
    
    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    changeMetroSelector();
});
}
JS;

$this->registerJs($js);
