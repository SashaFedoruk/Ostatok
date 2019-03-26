<?php
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AdsForm */
/* @var common\models\Category [] $categoriesList */
/* @var common\models\Category [] $producentsList */
/* @var common\models\Category [] $decorationsList */
/* @var common\models\Category [] $heightsList */
/* @var common\models\Category [] $productsList */


$this->title = 'Редактирование обьявления';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$freeAds = User::findOne(['id' => Yii::$app->user->id])->free_ads;
echo '<script> var freeAds = '.$freeAds.';</script>'
?>

<div class="user-info col-lg-4 col-md-4 col-sm-6">
    <h4 class="bold"><?= Html::encode($this->title) ?></h4>
    
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'user_id')->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'status')->hiddenInput()->label(false); ?>
    
         <?= $form->field($model, 'category_id')->dropDownList($categoriesList); ?>
        <div id="section1" class="hidden">
            <?= $form->field($model, 'producent_id')->dropDownList($producentsList); ?>
        </div>
        <div id="section2">
            <?= $form->field($model, 'decoration_id')->dropDownList($decorationsList); ?>
        </div>
        <div id="section3">
            <?= $form->field($model, 'height_id')->dropDownList($heightsList); ?>
        </div>
        <div id="section4" class="hidden">
            <?= $form->field($model, 'product_id')->dropDownList($productsList); ?>
            <?= $form->field($model, 'length'); ?>
            <?= $form->field($model, 'width'); ?>
            <?= $form->field($model, 'price'); ?>
            <div class="form-group">
                <?= Html::submitButton('Обновить', ['class' => 'btn my2-btn']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>
<!--<div class="col-lg-4 col-md-4 col-sm-6">-->
<!--    <h4><br></h4>-->
<!--    <h5 class="bold">Площадь, м2: <span id="size">0</span></h5>-->
<!--    <h5 class="bold">Цена за публикацию: <span id="price">0</span> грн.</h5>-->
<!---->
<!--</div>-->

<?php
$urlProducents = URL::toRoute(['site/get-producents-by-category-id']);
$urlProducts = URL::toRoute(['site/products-by-category-id-and-producent-id']);
$urlDecorations = URL::toRoute(['site/decorations-by-category-id-and-producent-id']);
$urlHeights = URL::toRoute(['site/heights-by-category-id-and-producent-id']);
$script = <<< JS
    $( document ).ready(function() {
    function getProducts(){
            var decorationId = $('#adsform-decoration_id').val();
            var categoryId = $('#adsform-category_id').val();
            var producentId = $('#adsform-producent_id').val();
            var heightId = $('#adsform-height_id').val();
            $.ajax({
                url:  "$urlProducts",
                type: 'post',
                data: {
                    'category_id': categoryId,
                    'producent_id': producentId,
                    'decoration_id': decorationId,
                    'height_id': heightId
                },
                success: function (data) {
                    if( data.search ){
                        $('#section4').removeClass("hidden");
                        var html = "";
                        $.each(data.search, function(idx, el) {
                            html += '<option value="' + el.id + '">' + el.name + '</option>';
                        });
                        $('#adsform-product_id').html(html);
                        //$('#adsform-product_id option:first-child').attr("selected", "selected");
                        $('select').select2();
                        
                    } else {
                        $('#section1').addClass("hidden");
                        $('#section2').addClass("hidden");
                        $('#section3').addClass("hidden");
                        $('#section4').addClass("hidden");
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
                       // $('#adsform-producent_id option:first-child').attr("selected", "selected");
                        $('select').select2();
                        $('#section2').addClass("hidden");
                        getDecorations();
                    } else {
                        $('#section1').addClass("hidden");
                        $('#section2').addClass("hidden");
                        $('#section3').addClass("hidden");
                        $('#section4').addClass("hidden");
                        $('#adsform-producent_id').html("");
                    }
                }
            });
    }
    function getDecorations(){
            var categoryId = $('#adsform-category_id').val();
            var producentId = $('#adsform-producent_id').val();
            $.ajax({
                url:  "$urlDecorations",
                type: 'post',
                data: {
                    'category_id': categoryId,
                    'producent_id': producentId
                },
                success: function (data) {
                    if( data.search ){
                        $('#section2').removeClass("hidden");
                        var html = "";
                        $.each(data.search, function(idx, el) {
                            html += '<option value="' + idx + '">' + el + '</option>';
                        });
                        $('#adsform-decoration_id').html(html);
                         //$('#adsform-decoration_id option:first-child').attr("selected", "selected");
                         $('select').select2();
                        $('#section4').addClass("hidden");
                        getHeights();
                    } else {
                        $('#section1').addClass("hidden");
                        $('#section2').addClass("hidden");
                        $('#section3').addClass("hidden");
                        $('#section4').addClass("hidden");
                        $('#adsform-decoration_id').html("");
                    }
                }
            });
    }
    function getHeights(){
            var categoryId = $('#adsform-category_id').val();
            var producentId = $('#adsform-producent_id').val();
            var decorationId = $('#adsform-decoration_id').val();
            $.ajax({
                url:  "$urlHeights",
                type: 'post',
                data: {
                    'category_id': categoryId,
                    'producent_id': producentId,
                    'decoration_id': decorationId,
                },
                success: function (data) {
                    if( data.search ){
                        $('#section2').removeClass("hidden");
                        var html = "";
                        $.each(data.search, function(idx, el) {
                            html += '<option value="' + idx + '">' + el + '</option>';
                        });
                        $('#adsform-height_id').html(html);
                         //$('#adsform-height_id option:first-child').attr("selected", "selected");
                         $('select').select2();
                        $('#section4').addClass("hidden");
                        getProducts();
                    } else {
                        $('#section1').addClass("hidden");
                        $('#section2').addClass("hidden");
                        $('#section3').addClass("hidden");
                        $('#section4').addClass("hidden");
                        $('#adsform-height_id').html("");
                    }
                }
            });
    }
    //getProducents();
    $('#section1').removeClass("hidden");
    $('#section2').removeClass("hidden");
    $('#section3').removeClass("hidden");
    $('#section4').removeClass("hidden");
    $('#adsform-category_id').change(function(){ 
         getProducents();   
    });
    $('#adsform-producent_id').change(function(){ 
         getDecorations();  
    });
    $('#adsform-decoration_id').change(function(){ 
         getHeights();  
    });
     $('#adsform-height_id').change(function(){ 
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





