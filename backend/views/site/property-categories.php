<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $categoriesList */
/* @var $model backend\models\CreatePropertyCategoriesForm */


$this->title = 'Категории и свойства';
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="user-info col-lg-5 col-md-5 col-sm-6">
        <h4 class="bold"><?= Html::encode($this->title) ?></h4>
        <?= $this->render('_form-create-property-categories', [
            'model' => $model,
            'categoriesList' => $categoriesList,
        ]) ?>


    </div>

<?php


$ajax = "
$( document ).ready(function() {
    function getChildProperties(){
            var val = $('#createpropertycategoriesform-parent_id').val();
            $.ajax({
                url: '" . URL::toRoute(['site/get-properties-for-category']) . "',
                type: 'post',
                data: {
                    id: val
                },
                success: function (data) {
                    //$('#propertiesChild').html(data.search);
                   
                        $('#propertiesChild').html(data.rez);
                        $('#multiselect').multiSelect();
                    
                }
            });
    }
    getChildProperties();
    $('#createpropertycategoriesform-parent_id').change(function(){ 
         getChildProperties();   
    });
});";
$this->registerJs(
    $ajax,
    yii\web\View::POS_END,
    'properties-child-show'
);

?>