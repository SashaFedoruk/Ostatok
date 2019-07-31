<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ImportResult */

$this->title = 'Отчёт импорта данных';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">
                    <h4 class="bold"><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">
                            Количество успешно добавленых обьявлений: <b><?= $model->countAdded ?></b>
                        </div>
                        <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">
                            Количество не добавленых обьявлений: <b><?= $model->countFailed ?></b>
                        </div>
                        <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">
                            Количество не найденых продуктов: <b><?= $model->countProductSkipped ?></b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>