<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ads [] */
/* @var $sum  */
/* @var $count  */


$this->title = 'Все обьявления';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">
                    <h4 class="bold"><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="col-lg-8 col-md-8 col-md-8 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">
                            Количество обьявлений: <b><?= $count ?></b>
                        </div>
                        <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">
                            Суммарная цена обьявлений: <b><?= $sum ?> UAH</b>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-right hidden-xs">
                    <?= Html::a("Создать новое обьявлени", ['/site/create-ads'], ['class' => 'btn my2-btn']) ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 visible-xs">
                    <?= Html::a("Создать новое обьявлени", ['/site/create-ads'], ['class' => 'btn my2-btn my2-btn-full-size']) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <?php
                if (count($model) > 0) {
                    foreach ($model as $el) {
                        echo $this->render('_partial-active-ads', [
                            'model' => $el
                        ]);
                    }
                } else { ?>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4>Обьявлений не найдено.</h4>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
