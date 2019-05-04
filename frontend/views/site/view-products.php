<?php

use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model common\models\Product [] */
/* @var pages */


$this->title = 'Товары '.$model[0]->category->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['site/catalog']];
if(Yii::$app->getRequest()->getQueryParam('producentId')){
    $this->params['breadcrumbs'][] = ['label' => $model[0]->category->name, 'url' => ['site/view-products', 'categoryId' =>  $model[0]->category->id]];
    $this->params['breadcrumbs'][] = $model[0]->producent->name;
} else {
    $this->params['breadcrumbs'][] = $model[0]->category->name;
}

?>


<br>
<!--<div class="filter-bar" role="navigation">-->
<!--    <!-- Фильтрация -->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8">-->
<!--                <div class="row">-->
<!---->
<!--                    <div class="col-lg-4 col-md-4">-->
<!--                        <select class="form-control">-->
<!--                            <option value="0">По названию</option>-->
<!--                            <option value="1">По мин. цене</option>-->
<!--                            <option value="2">По макс. цене</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="col-lg-4 col-md-4">-->
<!--                        <select class="form-control">-->
<!--                            <option value="1">По убыванию</option>-->
<!--                            <option value="2">По возрастанию</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-lg-4 col-md-4">-->
<!--                        <input type="button" class="btn my-btn" value="Фильтровать">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--    </div>-->
<!--    <!-- Конец Фильтрации -->
<!--</div>-->

<div class="container catalog-container">
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
        if (count($model) > 0) {
            foreach ($model as $el) {
                echo $this->render('_partial-view-products-item', [
                    'model' => $el
                ]);
            }
        } else {
            ?>
            <br>
            <br>
            <h4>Продуктов не найдено. </h4>
            <br>
            <br>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'list-inline'],
                'linkOptions' => ['class' => 'page'],
                'prevPageLabel' => '<span><img src="img/Catalog/back.png" alt=""></a></span>',
                'prevPageCssClass' => 'without-border',
                'nextPageLabel' => '<span><img src="img/Catalog/next.png" alt=""></a</span>',
                'nextPageCssClass' => 'without-border',
                'lastPageLabel' => $pages->pageCount,
                'lastPageCssClass' => 'page',
                'firstPageCssClass' => 'page',
                'firstPageLabel' => "1",
                'activePageCssClass' => 'active',
                'maxButtonCount' => 7,    // Set maximum number of page buttons that can be displayed

            ]); ?>
        </div>
    </div>


</div>


