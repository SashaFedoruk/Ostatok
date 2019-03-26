<?php

use yii\helpers\Html;
use common\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var common\models\Category []  $categoriesList  */
/* @var common\models\Producent [] $producentsList  */


$this->title = 'Добавления товара';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info col-lg-4 col-md-4 col-sm-6">
    <h4 class="bold"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form-add-product', [
        'model' => $model,
        'categoriesList' => $categoriesList,
    ]) ?>


</div>



<?php


$ajax = "
$( document ).ready(function() {
    function getChildProperties(){
            var val = $('#product-category_id').val();
            $.ajax({
                url: '" . URL::toRoute(['site/get-fields-for-category']) . "',
                type: 'post',
                data: {
                    id: val
                },
                success: function (data) {
                    //$('#propertiesChild').html(data.search);
                    if( data.rez != ''){
                        $('#props').html(data.rez);
                    } else {
                        $('#props').html('<h5 class=\"bold\">Значения не найдены.</h5>');
                    }
                    $('select').select2();
                }
            });
            
    }
    getChildProperties();
    $('#product-category_id').change(function(){ 
         getChildProperties();   
    });
});";
$this->registerJs(
    $ajax,
    yii\web\View::POS_END,
    'product-fields-show'
);

?>



