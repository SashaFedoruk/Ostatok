<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Ads */


$dataEnd = strtotime('+30 days', $model->created_at);
$dataEnd = gmdate("Y-m-d", $dataEnd);
$urlPhoto = "img/Catalog/empty.png";
if($model->product->imgUrl != null && $model->product->imgUrl != ""){
    $urlPhoto = $model->product->imgUrl;
}
?>


<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 block-advert top-space text-center">
    <div class="head-block">
        <div class="date-block">
            <div class="to">До</div>
            <div class="date"><?= $dataEnd ?></div>
        </div>
        <img src="<?= $urlPhoto ?>" alt="">
    </div>
    <p><?= StringHelper::truncate($model->product->name, 45) ?></p>
    <div class="size"><?= $model->length.'x'.$model->width ?></div>
    <p class="prices"><span class="bold"><?= $model->price ?></span> грн/лист</p>
    <div class="nav-btn">
        <?= Html::a('<img src="img/Admin/see.png" alt="Посмотреть">', ['site/view-product', 'id' => $model->product->id]); ?>
        <?= Html::a('<img src="img/copy.png" alt="Создать копию">', ['site/copy-ads', 'id' => $model->id]); ?>
        <?= Html::a('<img src="img/Admin/delete.png" alt="Удалить">', ['site/delete-ads', 'id' => $model->id]); ?>

    </div>
    <hr>
</div>
