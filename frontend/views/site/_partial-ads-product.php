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
        <div class="col-lg-5 col-md-4 col-xs-12 text-center vcenter" id="n<?= $model->id ?>">
            <div class="hidden-block">
                <div class="row">
                    <ul class="contact-seller">
                        <li>
                            <div class="bold col-lg-3 col-md-3 col-sm-4 col-xs-4 text-left">
                                Email:
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 text-right">
                                <span><?= $model->user->email; ?></span>
                            </div>
                        </li>
                        <li>
                            <div class="bold col-lg-3 col-md-3 col-sm-4 col-xs-4 text-left">
                                Город:
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 text-right">
                                <span><?= \common\models\City::findOne(['id' => $model->user->city_id])->name; ?></span>
                            </div>
                        </li>
                        <li>
                            <div class="bold col-lg-3 col-md-3 col-sm-4 col-xs-4 text-left">
                                Телефон:
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 text-right">
                                <span><?= $model->user->phone; ?></span>
                            </div>
                        </li>
                    </ul>
                    <button class="btn my2-btn top-space hidden-info" data-id="n<?= $model->id ?>">Скрыть контакты продавца</button>
                </div>
            </div>
            <button class="btn my2-btn show-info" data-id="n<?= $model->id ?>">Посмотреть контакты продавца</button>
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