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
<?= $content ?>

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
