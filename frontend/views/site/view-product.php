<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use common\models\Category;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $filterModel common\models\AdsFilterModel */
/* @var $ads common\models\Ads[] */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['site/catalog']];
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['site/view-products', 'categoryId' =>  $model->category->id]];
$this->params['breadcrumbs'][] = $this->title;

$urlPhoto = "img/Catalog/empty.png";
if($model->imgUrl != null && $model->imgUrl != ""){
    $urlPhoto = $model->imgUrl;
}
?>


    <div class="container">
        <br>
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
            <h3 class="col-lg-offset-1 col-lg-10 col-md-offset-0 col-md-12 col-sm-offset-1 col-sm-10 col-xs-12">
                <div class="row">
                    <div class="col-lg-9 text-center header-text"><?= $model->name; ?></div>
                    <div class="col-lg-3">
                        <button type="button" class="btn navbar-btn my2-btn" id="btn-go-to-offers">Показать предложения</button>
                    </div>
                </div>

            </h3>
        </div>
        <div class="row">
            <div class="col-lg-offset-1 col-lg-10 col-md-offset-0 col-md-12 col-sm-offset-1 col-sm-10 col-xs-12">
                <div class="row">

                    <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-center product">
                        <img src="<?= $urlPhoto ?>" alt="">
                        <p class="top-space">от <span class="price bold"><?= $model->getMinPrice()?> - <?= $model->getMaxPrice()?></span> грн.</p>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?= Html::a(Html::button('Подать обьявление', ['class' => 'btn navbar-btn my2-btn']), ['site/create-ads-by-product-id', 'id' => $model->id]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-push-1 col-lg-6 col-md-push-1 col-md-7 col-sm-8 col-xs-12 prod-info">
                        <h4 class="bold under-line">Характеристики товара:</h4>
                        <ul>
                            <li>
                                <ul class="stats">
                                    <li class="inline"><span class="bold">Категория:</span></li>
                                    <li class="right">
                                        <?= $model->category->name ?>
                                    </li>
                                </ul>
                                <ul class="stats">
                                    <li class="inline"><span class="bold">Производитель:</span></li>
                                    <li class="right">
                                        <?= $model->producent->name ?>
                                    </li>
                                </ul>
                                <ul class="stats">
                                    <li class="inline"><span class="bold">Название декора:</span></li>
                                    <li class="right">
                                        <?= $model->decoration->name ?>
                                    </li>
                                </ul>
                                <ul class="stats">
                                    <li class="inline"><span class="bold">Код декора:</span></li>
                                    <li class="right">
                                        <?= $model->decoration->code ?>
                                    </li>
                                </ul>
                                <?php
                                foreach ($model->propertyProducts as $el) { ?>
                                    <ul class="stats">
                                        <li class="inline"><span class="bold"><?= $el->prop->parent->name ?>:</span></li>
                                        <li class="right">
                                            <?= $el->prop->name ?>
                                        </li>
                                    </ul>
                                    <?php } ?>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <h3 id="offers-block">Предложения продавцов на
            <?= $model->name; ?>
        </h3>
        <?php 
            $list = [1 => 'По дате публикации', 2 => 'По макс. цене', 3 => 'По мин. цене'];

            ?>
        <div class="row">
            <?php $form = ActiveForm::begin(['enableClientValidation'=>false]); ?>

            <div class="col-lg-12 col-md-12">
                <div class="row">

                    <div class="col-lg-3  col-sm-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><label for="">Ширина, от</label></div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?= $form->field($filterModel, 'minSize')->textInput(['pattern' => '[0-9]+(\.[0-9]{0,2})?%?', 'placeholder' => 'От'])->label(false); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3  col-sm-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><label for="">Длина, от</label></div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?= $form->field($filterModel, 'maxSize')->textInput(['pattern' => '[0-9]+(\.[0-9]{0,2})?%?', 'placeholder' => 'От'])->label(false); ?></div>
                        </div>
                    </div>
                    <div class="col-lg-3  col-sm-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><label for="">Сортировка</label></div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?= $form->field($filterModel, 'sortBy')->dropDownList($list)->label(false); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3  col-sm-3">

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><label for=""> </label></div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?= Html::submitButton('Фильтровать', ['class' => 'btn my2-btn my2-btn-full-size-w-m', 'style' => 'margin-top: 4px;']) ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>

            <?php ActiveForm::end(); ?>
            <?php ?>
                   <br>
                    <?php
            
           
            if (count($ads) > 0) {
                foreach ($ads as $el) {
                    echo $this->render('_partial-ads-product', [
                        'model' => $el
                    ]);
                }

            ?>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <div class="row">
                                <div class="offer">
                                    <!--                    <a class="btn my2-btn btn-marg" href="#">Показать все предложения</a>-->
                                </div>
                            </div>
                        </div>
                        <?php
        } else {
            ?>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <div class="row">
                                    <div class="offer">
                                        Объявления на этот продукт отсутствуют. <br> Будьте первыми кто опубликует свое предложение!
                                        <br>
                                        <?= Html::a(Html::button('Подать обьявление', ['class' => 'btn navbar-btn menu my2-btn']), ['site/create-ads-by-product-id', 'id' => $model->id]); ?>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <?php } ?>

    </div>
    <?php
    $urlNotifications = URL::toRoute(['site/add-notification']);
$script = <<< JS
    $( document ).ready(function() {
        $(".show-info").click(function(e){
            var id = "#" + $(event.target).attr("data-id");
             $(id + " .show-info").css("display", "none");
            $(id + " .hidden-block").css("display", "block");
        });
        $(".hidden-info").click(function(e){
            var id = "#" + $(event.target).attr("data-id");
             $(id + " .show-info").css("display", "inline-block");
            $(id + " .hidden-block").css("display", "none");
        });
        $('#btn-go-to-offers').click(function (){
            $('html, body').animate({
              scrollTop: $("#offers-block").offset().top
            }, 1000);
        });
        
        $('.show-info').click(function (e){
            var adsId = $(e.target).attr("data-ads-id"); 
            $.ajax({
                url:  "$urlNotifications",
                type: 'post',
                data: {
                    adsId : adsId
                },
                success: function (data) {
                    if( data.search ){
                       
                    } else {
                       
                    }
                }
            });
        });
       
});
    
    
    
    
JS;
$this->registerJs(
    $script,
    yii\web\View::POS_END,
    'properties-child-show'
);
?>
