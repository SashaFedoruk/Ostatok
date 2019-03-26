<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use common\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="navbar" role="navigation">
    <!-- Первое Меню -->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="http://ostatok.online/" class="navbar-brand logo">OSTATOK<br><span>Cэкономил - значит заработал!</span></a>
        </div>


        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="main-menu"><a href="http://ostatok.online/">Перейти на сайт</a></li>
                <li class="main-menu"><?= Html::a('Панель управления', ['/site/update-user']) ?></li>
            </ul>
            <ul class="nav navbar-nav navbar-right language">


                <?php if (Yii::$app->user->isGuest) {
                    echo Html::a(Html::button('Войти', ['class' => 'btn navbar-btn menu log my2-btn']), ['/site/login']);
                } else {
                    $user = User::findById(Yii::$app->user->identity->getId());
                    $userName = $user->firstname . ' ' . $user->lastname;
                    ?>
                    <li>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn navbar-btn menu log my2-btn dropdown-toggle"><?= $userName; ?><span class="caret"></span></button>
                            <ul class="dropdown-menu">

                                <li><?= Html::a("Панель управления", ['/site/update-user']) ?></li>
                                <li><?= Html::a("Выйти", ['/site/logout']) ?></li>
                            </ul>
                        </div>
                    </li>
                <?php } ?>


            </ul>
        </div>
    </div>
</div>
<!-- Конец Первого Меню -->
<?php
if (!Yii::$app->user->isGuest) { ?>
    <div class="main-title">
        <div class="container">
            <div class="row">
                <div class="text-left col-lg-8 col-md-8 col-sm-8 col-xs-6">
                    <p>Панель Администратора</p>
                </div>

            </div>
        </div>
    </div>
    <div class="container admin-pages">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="row">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
        <div class="row block">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <ul class="admin-menu">
                    <li> <?= Html::a('Мои данные', ['/site/update-user']) ?></li>
                    <li> <?= Html::a('Список клиентов', ['/site/users-list']) ?></li>
                    <li> <?= Html::a('Статистика', ['/site/stats']) ?></li>
                    <li>
                    <li>Панель управления продуктами
                        <ul class="second-admin-menu">
                            <li><?= Html::a('Категории', ['/site/create-category']) ?></li>
                            <li><?= Html::a('Декорации', ['/site/create-decoration']) ?></li>
                            <li><?= Html::a('Производители', ['/site/create-producent']) ?></li>
                            <li><?= Html::a('Свойства товаров', ['/site/properties']) ?></li>
                            <li><?= Html::a('Категории и свойства', ['/site/property-categories']) ?> </li>
                            <li><?= Html::a('Добавление товара', ['/site/add-product']) ?></li>
                            <li><?= Html::a('Список товаров', ['/site/products']) ?></li>

                        </ul>
                    </li>

                    </li>

                    <li>

                        Панель управления обьявлениями

                        <ul class="second-admin-menu">
                            <li><?= Html::a('Все активные обьявления', ['/site/all-active-ads']) ?></li>
                            <li><?= Html::a('Создать обьявления', ['/site/create-ads']) ?></li>
                            <li><?= Html::a('Архив', ['/site/all-archive-ads']) ?></li>
                        </ul>
                    </li>
                </ul>
            </div>


            <?= $content ?>
        </div>
    </div>
<?php } else {
    echo $content;
} ?>
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="copy">
                    <span>Ostatok © 2012-2019. All rights reserved.</span><br> Сайт разработан компанией
                    <a href="http://www.kfstudia.com" class="bold">KF Studia</a>
                </p>
            </div>
        </div>
    </div>
</div><!-- Конец Футера -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
