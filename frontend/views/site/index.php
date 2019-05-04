<?php

/* @var $this yii\web\View */
/* @var $model common\models\Category [] */

$this->title = 'Плитные материалы для мебели, купить, продать|Ostatok|Остаток';

use common\models\ProductSearch;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$modelWidget = new ProductSearch();
?>

<div class="main">
    <!-- Главная заставка-->
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="cblock">
                    <h1>Доска обьявлений</h1>
                    <h2>деловых остатков плитных материалов</h2>
                </div>
            </div>
        </div>


        <?php $form = ActiveForm::begin(['fieldConfig' => [
            'options' => [
                'tag' => false,
            ],
        ], 'action' => ['site/search'], 'enableClientValidation' => false, 'options' => ['class' => 'navbar-form hidden-sm hidden-xs']]); ?>
        <div class="row">
            <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
                <div class="input-group" id="productsearch2" style="width: 100%;">
                    <?= $form->field($modelWidget, 'name', ['template' => "{input}"])->input('text', ['placeholder' => 'Найти остаток...', 'class' => 'form-control productsearch-name'])->label(false); ?>
                    <div class="container rezult-search">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Результаты поиска: </h4>
                            </div>
                        </div>
                        <div class="all-rezult">

                        </div>

                        <div class="row right-text-align">
                            <div class="col-lg-12">
                                <?= Html::submitButton('Показать все...', ['class' => 'btn btn-default']) ?>
                            </div>
                        </div>
                    </div>
                    <span class="input-group-btn">
                    <?= Html::submitButton(Html::img(Url::to('@web/img/find.png'), ['alt' => 'Найти', 'style' => 'height: 17px;']), ['class' => 'btn btn-default', 'style' => 'width:100%']) ?>
                    </span>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Конец Главной заставки-->

<div class="container block catalog-main-block">
    <!-- Каталог -->
    <h2>Каталог</h2>
    <div class="row">
        <?php
        foreach ($model as $el) {
            echo $this->render('_partial-index-catalog-item', [
                'model' => $el
            ]);
        }
        ?>
    </div>
</div>
<!-- Конец Каталога -->

<div class="seller" id="seller">
    <!-- Продавцы -->
    <div class="container">
        <h2>Я продавец</h2>
        <div class="row text-center space">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-offset-1 col-lg-2 col-md-offset-1 col-md-2 col-sm-offset-1 col-sm-2 col-xs-12">
                        <img class="icon" src="img/enter.png" alt="">
                        <h4>Войдите в аккаунт</h4>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <i class="fa fa-2x fa-rotate-90 fa-chevron-right" aria-hidden="true"></i>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <img class="icon" src="img/plus.png" alt="">
                        <h4>Добавьте обьявление</h4>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <i class="fa fa-2x fa-rotate-90 fa-chevron-right" aria-hidden="true"></i>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <img class="icon" src="img/hourglass.png" alt="">
                        <h4>Ожидайте сделку</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="buyer">
    <div class="container">
        <h2>Я покупатель</h2>
        <div class="row text-center space">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-3 col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3">
                        <img class="icon" src="img/tiles.png" alt="">
                        <h4>Выберите необходимый материал</h4>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <i class="fa fa-2x fa-rotate-90 fa-chevron-right" aria-hidden="true"></i>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <img class="icon" src="img/smartphone.png" alt="">
                        <h4>Свяжитесь с продавцом и подтвердите сделку</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Конец Продавцов -->

<div class="container" id="for-whom">
    <!-- Для кого? -->
    <h2>Для кого</h2>
    <div class="row text-center space">
        <div class="col-lg-12">
            <p>
                <span class="green">Сайт Ostatok</span> дает возможность производителям мебели взаимодействовать между
                собой.
            </p>
            <p>
                Например, при раскрое плитного материала у Вас остался
                <span class="green">"Деловой остаток"</span> в котором, в свою очередь, может нуждаться другой
                производитель, в целях экономии покупки целого листа материала.
            </p>
        </div>
    </div>
</div>
<!-- Конец Для кого? -->

<div class="container bottom-space">
    <!-- Как это работает? -->
    <h2 class="down-space">Как это работает</h2>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 how-work">
            <p class="text-left">
                Владелец <span class="green">"Делового остатка"</span> размещает объявление о наличии того или иного
                материала, а покупатель подобрав необходимый вид и размер материала, может его выкупить.
            </p>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
            <p>
                Преимущества сайта <span class="green">OSTATOK:</span><br> 1. Вы используете только необходимый
                материал.<br> 2. Не занимаете производственную площадь материалом, который в процессе хранения может
                повредиться.<br> 3. Работаем 24 / 7 / 365 <br> 4. Сэкономил - значит заработал!
            </p>
        </div>
    </div>
</div>
<!-- Конец Как это работает? -->

