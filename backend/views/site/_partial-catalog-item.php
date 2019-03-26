<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Category */



?>

<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center">
    <h3><?= Html::a($model->name, ['/site/view-products', 'categoryId' => $model->id]) ?></h3>
    <ul class="main-catalog">
        <?php
        $allProducents = ArrayHelper::map($model->products, 'id', 'producent');
        $producents =  [];
        foreach ($allProducents as $el){
            if(!in_array($el, $producents)){
                array_push($producents, $el);
                echo "<li>". Html::a($el->name, ['/site/view-products', 'categoryId' => $model->id, 'producentId' => $el->id]) ."</li>";
            }
        }
        ?>
    </ul>
</div>
