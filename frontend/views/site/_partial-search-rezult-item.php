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


<div class="row rezult-item">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <?= Html::a('<img src="'.$urlPhoto.'" alt="">' ,['/site/view-product', 'id' => $model->id]) ?>
                      
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <div class="row">
                            <div class="col-lg-12"><?= mb_substr($model->name, 0, 40).'...' ?></div>
                            <div class="col-lg-12"><?= Html::a('Посмотреть', ['/site/view-product', 'id' => $model->id], ['class' => 'btn my2-btn down-space', 'style' => 'margin-top: 5px;']) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
