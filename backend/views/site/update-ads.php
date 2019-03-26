<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AdsForm */
/* @var common\models\Category [] $categoriesList */


$this->title = 'Редактирование обьявления';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-info col-lg-4 col-md-4 col-sm-6">
    <h4 class="bold"><?= Html::encode($this->title) ?></h4>


    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'status')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoriesList); ?>

    <div id="section1" class="hidden">
        <?= $form->field($model, 'producent_id')->dropDownList([]); ?>
    </div>
    <div id="section2" class="hidden">
        <?= $form->field($model, 'product_id')->dropDownList([]); ?>
        <?= $form->field($model, 'width'); ?>
        <?= $form->field($model, 'length'); ?>
        <?= $form->field($model, 'price'); ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn my2-btn']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
$urlProducents = URL::toRoute(['site/get-producents-by-category-id']);
$urlProducts = URL::toRoute(['site/products-by-category-id-and-producent-id']);

$script = <<< JS
    $( document ).ready(function() {
    function getProducts(){
            var categoryId = $('#adsform-category_id').val();
            var producentId = $('#adsform-producent_id').val();
            $.ajax({
                url:  "$urlProducts",
                type: 'post',
                data: {
                    'category_id': categoryId,
                    'producent_id': producentId
                },
                success: function (data) {
                    //$('#propertiesChild').html(data.search);
                    if( data.search ){
                        $('#section2').removeClass("hidden");
                        var html = "";
                        $.each(data.search, function(idx, el) {
                            html += '<option value="' + el.id + '">' + el.name + '</option>';
                        });
                        $('#adsform-product_id').html(html);
                    } else {
                        $('#section1').addClass("hidden");
                        $('#section2').addClass("hidden");
                        $('#adsform-producent_id').html("");
                    }
                }
            });
    }
    function getProducents(){
            var val = $('#adsform-category_id').val();
            $.ajax({
                url:  "$urlProducents",
                type: 'post',
                data: {
                    'category_id': val
                },
                success: function (data) {
                    //$('#propertiesChild').html(data.search);
                    if( data.search ){
                        $('#section1').removeClass("hidden");
                        var html = "";
                        $.each(data.search, function(idx, el) {
                            html += '<option value="' + el.id + '">' + el.name + '</option>';
                        });
                        $('#adsform-producent_id').html(html);
                        $('#section2').addClass("hidden");
                        getProducts();
                    } else {
                        $('#section1').addClass("hidden");
                        $('#section2').addClass("hidden");
                        $('#adsform-producent_id').html("");
                    }
                }
            });
    }
  
    getProducents();
    $('#adsform-category_id').change(function(){ 
         getProducents();   
    });
    $('#adsform-producent_id').change(function(){ 
         getProducts();  
    });
});
    
    
    
    
JS;
$this->registerJs(
    $script,
    yii\web\View::POS_END,
    'properties-child-show'
);
?>





