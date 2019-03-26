<?php
/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin(['action' => ['site/search'], 'enableClientValidation' => false, 'options' => ['class' => 'navbar-form search-form'], 'id' => 'productsearch1']); ?>
    <?= $form->field($model, 'name', ['template' => "{input}"])->input('text', ['placeholder' => 'Найти остаток...', 'class' => 'form-control productsearch-name'])->label(false); ?>
    
    <div class="container rezult-search">
       <div class="row">
           <div class="col-lg-12">
               <h4>Результаты поиска: </h4>
           </div>
       </div>
       <div class="all-rezult">
           
       </div>

         <div class="row right-text-align">
           <div class="col-lg-12">
               <?= Html::submitButton('Показать все...', ['class' => 'btn btn-default']) ?>
           </div>
       </div>
    </div>
<?= Html::submitButton(Html::img('img/find.png', ['alt' => 'Найти']), ['class' => 'btn btn-default']) ?>

<?php ActiveForm::end(); ?>

<?php

$urlSearch = URL::toRoute(['site/search']);
$script = <<< JS
    $( document ).ready(function() {
        function getSearchRezult(id){
                var text = $(id + ' .productsearch-name').val();
                $.ajax({
                    url:  "$urlSearch",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'text': text
                    },
                    success: function (data) {
                        if( data.search ){
                            $(id + ' .all-rezult').html(data.search);
                            
                        } else {
                            $(id + ' .all-rezult').html("Ничего не найдено.");
                        }
                    }
                });
        }
        function showSearchInfo(id){
            $(id + ' .rezult-search').css('display', 'block');
            getSearchRezult(id);
        }
        function hideSearchInfo(id){
            $(id + ' .rezult-search').css('display', 'none');
        }
        $('#productsearch1 .productsearch-name').keyup(function(){ 
            var obj = $('#productsearch1 #productsearch-name').val();
            if(obj.length > 0){
                showSearchInfo('#productsearch1');
            } else {
                hideSearchInfo('#productsearch1');
            }
        });

        $('#productsearch1 .productsearch-name').focus(function(){ 
           var obj = $('#productsearch1 #productsearch-name').val();
            if(obj.length > 0){
                showSearchInfo('#productsearch1');
            }
        });
         $('#productsearch2 .productsearch-name').keyup(function(){ 
            var obj = $('#productsearch2 #productsearch-name').val();
            if(obj.length > 0){
                showSearchInfo('#productsearch2');
            } else {
                hideSearchInfo('#productsearch2');
            }
        });

        $('#productsearch2 .productsearch-name').focus(function(){ 
           var obj = $('#productsearch2 #productsearch-name').val();
            if(obj.length > 0){
                showSearchInfo('#productsearch2');
            }
        });
        $('.rezult-search').css('display', 'none');

});
    
    
    
    
JS;
$this->registerJs(
    $script,
    yii\web\View::POS_END,
    'search-rezult-show'
);
?>


