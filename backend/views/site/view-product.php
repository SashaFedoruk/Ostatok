<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container">
    <div class="row">
        <h3 class="col-lg-12 text-center"><?= $model->name; ?></h3>
    </div>
    <div class="row">
        <div class="col-lg-offset-1 col-lg-10 col-md-offset-0 col-md-12 col-sm-offset-1 col-sm-10 col-xs-12">
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-center product">
                    <img src="img/Product/empty.png" alt="">
                    <p class="top-space">от <span class="price bold"><?= $model->getMinPrice()?> - <?= $model->getMaxPrice()?></span> грн/м2</p>
                </div>
                <div class="col-lg-push-1 col-lg-6 col-md-push-1 col-md-7 col-sm-8 col-xs-12 prod-info">
                    <h4 class="bold under-line">Характеристики товара:</h4>
                    <ul>
                        <li>
                            <ul class="stats">
                                <li class="inline"><span class="bold">Категория:</span></li>
                                <li class="right"><?= $model->category->name ?></li>
                            </ul>
                            <ul class="stats">
                                <li class="inline"><span class="bold">Производитель:</span></li>
                                <li class="right"><?= $model->producent->name ?></li>
                            </ul>
                            <ul class="stats">
                                <li class="inline"><span class="bold">Название декора:</span></li>
                                <li class="right"><?= $model->decoration->name ?></li>
                            </ul>
                            <ul class="stats">
                                <li class="inline"><span class="bold">Код декора:</span></li>
                                <li class="right"><?= $model->decoration->code ?></li>
                            </ul>
                            <?php
                            foreach ($model->propertyProducts as $el) { ?>
                                <ul class="stats">
                                    <li class="inline"><span class="bold"><?= $el->prop->parent->name ?>:</span></li>
                                    <li class="right"><?= $el->prop->name ?></li>
                                </ul>
                            <?php } ?>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h3>Предложения продавцов на <?= $model->name; ?></h3>

    <?php
    foreach ($model->ads as $el) {
        echo $this->render('_partial-ads-product', [
            'model' => $el
        ]);
    }

    ?>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <div class="row">
            <div class="offer">
                <a class="btn my2-btn btn-marg" href="#">Показать все предложения</a>
            </div>
        </div>
    </div>


</div>