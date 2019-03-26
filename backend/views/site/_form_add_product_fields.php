<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\CreateProductForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $data common\models\Property [] */
/* @var $producentsList */
/* @var $decorationsList */
?>


<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'name'); ?>
<?= $form->field($model, 'producent_id')->dropDownList($producentsList); ?>
<?= $form->field($model, 'decoration_id')->dropDownList($decorationsList); ?>
<?= $form->field($model, 'category_id')->hiddenInput()->label(false); ?>
<?php
$i = 0;
foreach ($data as $el) {
    $model->values[$i]['prop_id'] = $el->id;
    echo $form->field($model, 'values[' . $i . '][prop_id]')->hiddenInput()->label(false);
    if($el->isAnyField == 0) {
        $values = ArrayHelper::map($el->properties, 'id', 'name');
        echo $form->field($model, 'values[' . $i++ . '][value_id]')->dropDownList($values)->label($el->name);
    } else {
        echo $form->field($model, 'values[' . $i++ . '][value]')->label($el->name);
    }
}

?>


<div class="form-group">
    <?= Html::submitButton('Добавить', ['class' => 'btn my2-btn']) ?>
</div>

<div id="props"></div>

<?php ActiveForm::end(); ?>
