<?php

use common\models\Producent;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $stats */

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-info col-lg-8 col-md-8 col-sm-8">

    <h4 class="bold"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_partial-stats', [
        'stats' => $stats[0],
        'timeAgo' => 'За последние 24 часа.'
    ]); ?>
    <?= $this->render('_partial-stats', [
        'stats' => $stats[1],
        'timeAgo' => 'За последние 7 дней.'
    ]); ?>
    <?= $this->render('_partial-stats', [
        'stats' => $stats[2],
        'timeAgo' => 'За последний месяц.'
    ]); ?>
    <?= $this->render('_partial-stats', [
        'stats' => $stats[3],
        'timeAgo' => 'За последние 6 месяцов.'
    ]); ?>
    <?= $this->render('_partial-stats', [
        'stats' => $stats[4],
        'timeAgo' => 'За последний год.'
    ]); ?>
    <?= $this->render('_partial-stats', [
        'stats' => $stats[5],
        'timeAgo' => 'За всё время.'
    ]); ?>


</div>
