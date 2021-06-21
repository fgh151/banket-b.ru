<?php
/**
 * @var $this View
 * @var $content string
 */

use app\user\assets\LandingAsset;
use yii\helpers\Html;
use yii\web\View;

LandingAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#eaf0ff">
    <meta name="theme-color" content="#eaf0ff">
</head>
<body>
<?php $this->beginBody() ?>
<div class="header">
    <div class="container">
        <a href="/" class="navbar-brand scroll-top">Banket.fun</a>
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
                <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse"
                        data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!--/.navbar-header-->
            <div id="main-nav" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php if (Yii::$app->getUser()->getIsGuest()): ?>
                        <li>
                            <?= Html::a('Кабинет', ['/site/login']); ?>
                        </li>
                    <?php else: ?>
                        <li>
                            <?= Html::a('Кабинет', ['/battle/index']); ?>
                        </li>
                    <?php endif; ?>
                    <?php /* <li>
                        <?= Html::a('Блог', ['/blog/index']); ?>
                    </li> */ ?>
                </ul>
            </div>
            <!--/.navbar-collapse-->
        </nav>
        <!--/.navbar-->
    </div>
    <!--/.container-->
</div>
<!--/.header-->
<?= $content ?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <p>Copyright &copy; <?= date('Y') ?> banket.fun</p>
            </div>
            <div class="col-md-4">
                <?php /*<ul class="social-icons">
                    <li><a rel="nofollow" href="https://fb.com/templatemo"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-rss"></i></a></li>
                    <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                </ul> */ ?>
            </div>
            <div class="col-md-4">
                <?php /* <p>Design: TemplateMo</p> */ ?>
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
<?php if (false === YII_DEBUG): ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(<?=getenv('YA_METRIKA_COUNTER_ID')?>, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/<?= getenv('YA_METRIKA_COUNTER_ID') ?>"
                  style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
<?php endif; ?>
</body>
</html>
<?php $this->endPage() ?>
