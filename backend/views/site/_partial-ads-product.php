<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ads */


$dataEnd = strtotime('+30 days', $model->created_at);
$dataEnd = gmdate("Y-m-d", $dataEnd);
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row offer">
        <div class="col-lg-2 col-md-2 col-xs-12 text-center sell-block vcenter">
            <div>
                <img src="img/man.png" alt="">
                <p><?= $model->user->getFullName() ?></p>
            </div>
        </div>
        <div class="col-lg-5 col-md-4 col-xs-12 text-center vcenter">
            <a class="btn my2-btn" href="#">Посмотреть контакты продавца</a>
        </div>
        <div class="col-lg-5 col-md-6 col-xs-12 text-right seller-price-block vcenter">
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                    <div class="price-block">
                        <p class="price bold"><?= $model->price ?> грн</p>
                        <p class="tag">Цена</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-xs-2">
                    <div class="vline"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5">
                    <div class="size-block">
                        <div class="size bold">
                            <div class="row">
                                                <span class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                     <span><?= $model->length ?></span>
                                                </span>
                                <span class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <span>x</span>
                                                </span>
                                <span class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                    <span><?= $model->width ?></span>
                                                </span>
                            </div>
                        </div>
                        <p class="tag">Размер, мм</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>