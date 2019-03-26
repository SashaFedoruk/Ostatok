<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $timeAgo */
/* @var $stats  */
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><b><?= $timeAgo ?></b></h4></div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p>Опубликовано обьявлений: <?= $stats['ads'] ?></p></div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p>Зарегестрировано пользователей: <?= $stats['users'] ?></p></div>
</div>
