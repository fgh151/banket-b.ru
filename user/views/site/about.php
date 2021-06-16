<?php

/**
 * @var $this yii\web\View
 * @var $model \app\user\models\LandingForm
 */

use yii\widgets\ActiveForm;

$this->title = 'Банкет fun';
$this->params['breadcrumbs'][] = $this->title;

?>

    <section class="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h4>Рестораны дадут самые выгодные условия и лучшие цены.</h4>
                    <h2>BANKET FUN</h2>
                    <p>Заполняй заявку, указав количество гостей, сумму на человека, вид мероприятия и выбрав кухню. А
                        рестораны будут конкурировать между собой, делая тебе выгодные предложения.</p>
                    <div class="primary-button">
                        <a href="#" class="scroll-link" data-id="book-table">Создать банкет</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cook-delecious">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="first-image">
                        <img src="/landing/img/cook_01.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cook-content">
                        <h4>Организовать мероприятие</h4>
                        <div class="contact-content">
                            <span>Позвонить нам:</span>
                            <h6>+7 929 907 97 24</h6>
                            <h6>+7 999 714-02-57</h6>
                        </div>
                        <span>или</span>
                        <div class="primary-white-button">
                            <a href="#" class="scroll-link" data-id="book-table">Создать банкет</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="second-image">
                        <img src="/landing/img/cook_02.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="service-item">
                        <img src="/landing/img/cook_breakfast.png" alt="Банкет">
                        <h4>Банкет</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="service-item">
                        <img src="/landing/img/cook_lunch.png" alt="Корпоратив">
                        <h4>Корпоратив</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="service-item">
                        <img src="/landing/img/cook_dinner.png" alt="Юбилей">
                        <h4>Юбилей</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="service-item">
                        <img src="/landing/img/cook_dessert.png" alt="Свадьба">
                        <h4>Свадьба</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="book-table">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Создать банкет</h2>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-2 col-sm-12">
                    <div class="left-image">
                        <img src="/landing/img/book_left_image.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="right-info">
                        <?php $form = ActiveForm::begin(['id' => 'form-submit', 'action' => ['/site/create']]); ?>
                        <div class="row">

                            <div class="col-md-6">
                                <fieldset>
                                    <?= $form->field($model, 'date')->input('date')->label(false); ?>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <?= $form->field($model, 'date')->input('time')->label(false); ?>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="btn">Создать</button>
                                </fieldset>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Блог</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="blog-post">
                        <img src="/landing/img/blog_post_01.jpg" alt="">
                        <div class="date">26 Oct 2020</div>
                        <div class="right-content">
                            <h4>Stumptown Tofu Schlitz</h4>
                            <span>Branding / Admin</span>
                            <p>Skateboard iceland twee tofu shaman crucifix vice before they sold out corn hole occupy
                                drinking vinegar chambra meggings kale chips hexagon...</p>
                            <div class="text-button">
                                <a href="#">Continue Reading</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="blog-post">
                        <img src="/landing/img/blog_post_02.jpg" alt="">
                        <div class="date">21 Oct 2020</div>
                        <div class="right-content">
                            <h4>Succulents Hashtag Folk</h4>
                            <span>Branding / Admin</span>
                            <p>Skateboard iceland twee tofu shaman crucifix vice before they sold out corn hole occupy
                                drinking vinegar chambra meggings kale chips hexagon...</p>
                            <div class="text-button">
                                <a href="#">Continue Reading</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="blog-post">
                        <img src="/landing/img/blog_post_03.jpg" alt="">
                        <div class="date">11 Oct 2020</div>
                        <div class="right-content">
                            <h4>Knaus Sriracha Pinterest</h4>
                            <span>Dessert / Chef</span>
                            <p>Skateboard iceland twee tofu shaman crucifix vice before they sold out corn hole occupy
                                drinking vinegar chambra meggings kale chips hexagon...</p>
                            <div class="text-button">
                                <a href="#">Continue Reading</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="blog-post">
                        <img src="/landing/img/blog_post_04.jpg" alt="">
                        <div class="date">03 Oct 2020</div>
                        <div class="right-content">
                            <h4>Crucifix Selvage Coat</h4>
                            <span>Plate / Chef</span>
                            <p>Skateboard iceland twee tofu shaman crucifix vice before they sold out corn hole occupy
                                drinking vinegar chambra meggings kale chips hexagon...</p>
                            <div class="text-button">
                                <a href="#">Continue Reading</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--<section class="sign-up">-->
    <!--    <div class="container">-->
    <!--        <div class="row">-->
    <!--            <div class="col-md-12">-->
    <!--                <div class="heading">-->
    <!--                    <h2>Signup for our newsletters</h2>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        <form id="contact" action="" method="get">-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-4 col-md-offset-3">-->
    <!--                    <fieldset>-->
    <!--                        <input name="email" type="text" class="form-control" id="email" placeholder="Enter your email here..." required="">-->
    <!--                    </fieldset>-->
    <!--                </div>-->
    <!--                <div class="col-md-2">-->
    <!--                    <fieldset>-->
    <!--                        <button type="submit" id="form-submit" class="btn">Send Message</button>-->
    <!--                    </fieldset>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </form>-->
    <!--    </div>-->
    <!--</section>-->

<?php
$this->registerJs(<<<JS
// navigation click actions 
        $('.scroll-link').on('click', function(event){
            event.preventDefault();
            var sectionID = $(this).attr("data-id");
            scrollToID('#' + sectionID, 750);
        });
        // scroll to top action
        $('.scroll-top').on('click', function(event) {
            event.preventDefault();
            $('html, body').animate({scrollTop:0}, 'slow');         
        });
        // mobile nav toggle
        $('#nav-toggle').on('click', function (event) {
            event.preventDefault();
            $('#main-nav').toggleClass("open");
        });

function scrollToID(id, speed){
        var offSet = 0;
        var targetOffset = $(id).offset().top - offSet;
        var mainNav = $('#main-nav');
        $('html,body').animate({scrollTop:targetOffset}, speed);
        if (mainNav.hasClass("open")) {
            mainNav.css("height", "1px").removeClass("in").addClass("collapse");
            mainNav.removeClass("open");
        }
    }
    if (typeof console === "undefined") {
        console = {
            log: function() { }
        };
    }
JS
);
