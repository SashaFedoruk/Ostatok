<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$urlPhoto = "img/Catalog/empty.png";
if($model->imgUrl != null && $model->imgUrl != ""){
    $urlPhoto = $model->imgUrl;
}
?>


<div class="col-lg-3 col-sm-6 col-xs-12 text-center prod-img">
    <?= Html::a('<span class="thelper"></span><img src="'.$urlPhoto.'" alt="">' ,['/site/view-product', 'id' => $model->id]) ?>
    <h3><?= Html::a($model->name, ['/site/view-product', 'id' => $model->id]) ?></h3>
    <p>от <span class="price bold"><?= $model->getMinPrice()?> - <?= $model->getMaxPrice()?></span> грн.</p>
   <?= Html::a('Посмотреть', ['/site/view-product', 'id' => $model->id], ['class' => 'btn my2-btn down-space']) ?>
</div>
