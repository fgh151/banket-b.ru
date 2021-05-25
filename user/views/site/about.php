<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Банкетный баттл';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/landing.css');
?>

    <div class="promo-wrapper container">
        <div class="promo-image">
            <img src="/promo.svg"/>
        </div>

        <div class="description">
            <img src="/android-chrome-192x192.png" class="promo-logo"/>
            <h1>Банкет-батл</h1>
            <p class="descripton-text">
                Здесь рестораны соревнуются друг
                с другом, чтобы сделать для вас лучший банкет. Вам остается только выбрать победителя аукциона!
            </p>
            <p>

                <a href="/prezentation.pdf">
                    <img src="/img/presentation.svg" class="presentation-icon fill-svg"/>
                    Скачать презентацию (pdf)
                </a>
            </p>
        </div>
        <div class="promo-buttons">
            <p>
                <?= Html::a('Регистрация для ресторатора', ['signup']) ?>
            </p>
            <p>
                <?= Html::a('Вход для ресторатора', ['login']) ?>
            </p>
        </div>
    </div>

<?php

$js = <<<JS
$(".fill-svg").each(function () {
    // Perf tip: Cache the image as jQuery object so that we don't use the selector muliple times.
    var img = jQuery(this);
 // Get all the attributes.
    var attributes = img.prop("attributes");
    // Get the image's URL.
    var imgURL = img.attr("src");
    // Fire an AJAX GET request to the URL.
    $.get(imgURL, function (data) {
      // The data you get includes the document type definition, which we don't need.
      // We are only interested in the <svg> tag inside that.
      var svg = $(data).find('svg');
      // Remove any invalid XML tags as per http://validator.w3.org
      svg = svg.removeAttr('xmlns:a');
      // Loop through original image's attributes and apply on SVG
      $.each(attributes, function() {
        svg.attr(this.name, this.value);
      });
      // Replace image with new SVG
      img.replaceWith(svg);
    });
  })
JS;

$this->registerJs($js);
