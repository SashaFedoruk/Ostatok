<?php

/* @var $this yii\web\View */
/* @var $model common\models\Category [] */

$this->title = 'Каталог товаров - купить, продать, цены на сайте Ostatok | Остаток';
?>

<div class="container block catalog-main-block">
    <div class="row">
        <?php
//        foreach ($model as $el){
//            echo $this->render('_partial-catalog-item', [
//                'model' => $el
//            ]);
//        }

        foreach ($model as $el) {
            echo $this->render('_partial-index-catalog-item', [
                'model' => $el
            ]);
        }

        ?>
    </div>
</div>

