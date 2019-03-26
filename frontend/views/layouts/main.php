<?php
use frontend\widgets\searchwidget\SearchWidget;
use frontend\widgets\contactformwidget\ContactFormWidget;

/* @var $this \yii\web\View */

/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\User;

AppAsset::register($this);
$cities = \yii\helpers\ArrayHelper::map(\common\models\City::find()->orderBy('name')->all(), 'id', 'name');
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
            <a href="<?= \yii\helpers\Url::home() ?>" class="navbar-brand logo"><span class="logo-big">OSTATOK</span><br><span>Купить/продать остаток легко!</span></a>
        </div>


        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li class="main-menu"><?= Html::a("Главная", ['/site/index']) ?></li>
                <li class="main-menu"><?= Html::a("Каталог", ['/site/catalog']) ?></li>
                <li class="main-menu"><?= Html::a("Как это работает?", ['/site/index', '#' => 'seller']) ?></li>
                <li class="main-menu hidden-md"><?= Html::a("Для кого?", ['/site/index', '#' => 'for-whom']) ?></li>
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
<!--                                <li><a href="#" class="disabled">Ваш баланс: --><?//= number_format(User::findOne(['id' => Yii::$app->user->id])->money, 2) ?><!-- грн</a></li>-->
<!--                                <li class="divider"></li>-->
                                <li><?= Html::a("Панель управления", ['/site/update-user']) ?></li>
                                <li><?= Html::a("Выйти", ['/site/logout']) ?></li>
                            </ul>
                        </div>
                    </li>
                <?php } ?>


            </ul>
            <ul class="nav navbar-nav navbar-right visible-sm visible-xs">
                <li class="dropdown navbar-btn">
                    <div class="btn-group">
                    <?php if(isset(Yii::$app->request->cookies['city'])){ ?>
                        <!--                    --><?//= Html::dropDownList(null, null, $cities) ?>

                        <button class="btn menu dropdown-toggle my2-btn" data-toggle="dropdown"><?= Yii::$app->request->cookies['city']->value ?> <span
                                    class="caret"></span></button>
                    <?php  } else { ?>
                        <button class="btn menu dropdown-toggle my2-btn" data-toggle="dropdown">Город <span
                                    class="caret"></span></button>
                    <?php } ?>
                    <ul class="dropdown-menu">
                        <?php
                        echo '<li>'.Html::a("Любой", ['/site/set-city-cookie', 'city_id' => -1]).'</li>';
                        foreach ($cities as $key => $el){
                            echo '<li>'.Html::a("$el", ['/site/set-city-cookie', 'city_id' => $key]).'</li>';
                        }
                        ?>
                    </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Конец Первого Меню -->

<div class="navbar" role="navigation">
    <!-- Второе Меню -->
    <div class="container advar">
        <div class="nav navbar-nav navbar-left">
                <?= Html::a(Html::button('Подать обьявление', ['class' => 'btn navbar-btn menu my2-btn']), ['/site/create-ads-btn']); ?>
        </div>

        <ul class="nav navbar-nav navbar-right hidden-sm hidden-xs">
            <li class="dropdown navbar-btn">
                <?php if(isset(Yii::$app->request->cookies['city'])){ ?>
<!--                    --><?//= Html::dropDownList(null, null, $cities) ?>

                    <button class="btn menu dropdown-toggle my2-btn" data-toggle="dropdown"><?= Yii::$app->request->cookies['city']->value ?> <span
                                class="caret"></span></button>
                <?php  } else { ?>
                <button class="btn menu dropdown-toggle my2-btn" data-toggle="dropdown">Город <span
                            class="caret"></span></button>
                <?php } ?>
                <ul class="dropdown-menu">
                    <?php
                        echo '<li>'.Html::a("Любой", ['/site/set-city-cookie', 'city_id' => -1]).'</li>';
                        foreach ($cities as $key => $el){
                            echo '<li>'.Html::a("$el", ['/site/set-city-cookie', 'city_id' => $key]).'</li>';
                        }
                    ?>
                </ul>
            </li>
        </ul>
        <div class="navbar-right">
            <?= SearchWidget::widget(['model' =>  null]) ?>

        </div>
    </div>
</div>
<?= $content; ?>


<div class="footer">
    <!-- Футер -->
    <div class="container">
        <div class="row">
            <div class="contact-footer col-lg-4 col-md-4 col-sm-5 col-xs-12">
                <a href="#" class="logo">
                    <span class="logo-big">OSTATOK</span><br>
                    <span>Купить/продать остаток легко!</span>
                </a>
                <div class="contacts">
                    <h3>Контакты поддержки</h3>
                    <div class="item">
                        <img src="img/gmail.png" alt="">
                        <p>support@ostatok.online</p>
                    </div>
<!--                    <div class="item">-->
<!--                        <img src="img/time.png" alt="">-->
<!--                        <p> Пн — Пт: c 8:00 до 20:00<br> Сб — Вс: c 9:00 до 18:00-->
<!--                        </p>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">

                <?= ContactFormWidget::widget(['model' =>  null]) ?>
            </div>
            <div class="col-lg-push-4 col-lg-2 col-md-push-2 col-md-3 col-sm-push-1 col-sm-3 col-xs-push-1 col-xs-5">
<!--                <ul>-->
<!--                    <li class="bold">Меню</li>-->
<!--                    <li >--><?//= Html::a("Главная", ['/site/index']) ?><!--</li>-->
<!--                    <li >--><?//= Html::a("Каталог", ['/site/catalog']) ?><!--</li>-->
<!--                    <li >--><?//= Html::a("Как это работает?", ['/site/index', '#' => 'seller']) ?><!--</li>-->
<!--                    <li >--><?//= Html::a("Для кого?", ['/site/index', '#' => 'for-whom']) ?><!--</li>-->
<!--                </ul>-->
            </div>
            <div class="col-lg-push-4 col-lg-2 col-md-push-2 col-md-3 col-sm-push-1 col-sm-3 col-xs-push-1 col-xs-5">
<!--                <ul>-->
<!--                    <li class="bold">Каталог</li>-->
<!--                    --><?php
//                    $allCategories = ArrayHelper::map(\common\models\Category::find()->all(), 'id', 'name');
//                    foreach ($allCategories as $key => $el){
//                        echo "<li>". Html::a($el, ['/site/view-products', 'categoryId' => $key]) ."</li>";
//                    }
//
//                    ?>
<!---->
<!--                </ul>-->
            </div>
        </div>
    </div>
</div>
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
</div>
<!-- Конец Футера -->
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
