<?php

/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;

/* @var $model common\models\Category [] */

$this->title = 'Каталог товаров - купить, продать, цены на сайте Ostatok | Остаток';
$this->params['breadcrumbs'][] = "Каталог";
?>

<div class="container block catalog-main-block">
    <?php

    echo Breadcrumbs::widget([
        'homeLink' => [
            'label' => Yii::t('yii', 'Главная'),
            'url' => Yii::$app->homeUrl,
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ])
    ?>
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

