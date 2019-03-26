<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $propertiesList */
/* @var $propertiesWithotAnyField */
/* @var $cpvForm backend\models\CreateProperyValuesForm */


$this->title = 'Свойства продуктов';
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="user-info col-lg-4 col-md-4 col-sm-6">
        <h4 class="bold"><?= Html::encode($this->title) ?></h4>

        <?= $this->render('_form-create-property', [
            'model' => $model
        ]) ?>
        <?= $this->render('_form_create-property-value', [
            'model' => $cpvForm,
            'propertiesList' => $propertiesWithotAnyField,
        ]) ?>

    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
    <h4><br></h4>
    <h5 class="bold">Доступные значения</h5>
    <ul>
        <?php
        foreach ($propertiesList as $el) {

            echo '<li>' . Html::a(Html::img('img/Admin/delete.png'), ['delete-property', 'id' => array_search($el, $propertiesList)], [
                    'class' => '',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить это значение?',
                        'method' => 'post',
                    ],
                ]). ' ' . $el  .'</li>';
        }

        ?>
    </ul>
        <hr>
    <div id="propertiesChild">

    </div>
    </div>


<?php


$ajax = "
$( document ).ready(function() {
    function getChildProperties(){
            var val = $('#createproperyvaluesform-parent_id').val();
            $.ajax({
                url: '" . URL::toRoute(['site/get-property-values']) . "',
                type: 'post',
                data: {
                    id: val
                },
                success: function (data) {
                    //$('#propertiesChild').html(data.search);
                    if( data.search != ''){
                        $('#propertiesChild').html(data.search);
                    } else {
                        $('#propertiesChild').html('<h5 class=\"bold\">Значения не найдены.</h5>');
                    }
                }
            });
    }
    getChildProperties();
    $('#createproperyvaluesform-parent_id').change(function(){ 
         getChildProperties();   
    });
});";
$this->registerJs(
    $ajax,
    yii\web\View::POS_END,
    'properties-child-show'
);

?>