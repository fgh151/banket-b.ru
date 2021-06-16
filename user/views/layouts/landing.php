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
</head>
<body>
<?php $this->beginBody() ?>
<div class="header">
    <div class="container">
        <a href="#" class="navbar-brand scroll-top">Banket.fun</a>
        <?php /*
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
                    <li><a href="index.html">Home</a></li>
                    <li><a href="menu.html">Our Menus</a></li>
                    <li><a href="blog.html">Blog Entries</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>
            <!--/.navbar-collapse-->
        </nav>
        <!--/.navbar-->
        */ ?>
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
</body>
</html>
<?php $this->endPage() ?>
