<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\CreateProductForm */
/* @var $form yii\widgets\ActiveForm */
/* @var common\models\Category [] $categoriesList */
/* @var common\models\Producent [] $producentsList */
/* @var common\models\Decoration [] $decorationsList */

?>

<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'category_id')->dropDownList($categoriesList) ?>
<?= $form->field($model, 'producent_id')->dropDownList($producentsList) ?>
<?= $form->field($model, 'decoration_id')->dropDownList($decorationsList) ?>
<?= $form->field($model, 'product_id')->hiddenInput()->label(false); ?>


<?php
foreach ($model->values as $key => $el) {

    echo $form->field($model, 'values[' . $key . '][prop_id]')->hiddenInput()->label(false);
    echo $form->field($model, 'values[' . $key . '][prop_name]')->hiddenInput()->label(false);
    if(isset($el['value_id'])) {
        $values = \common\models\Property::find()->where(['parent_id' => $el['prop_id']])->all();
        $values = ArrayHelper::map($values, 'id', 'name');
        echo $form->field($model, 'values[' . $key . '][value_id]')->dropDownList($values)->label($el['prop_name']);
    } else {
        echo $form->field($model, 'values[' . $key . '][value]')->label($el['prop_name']);
    }
}

?>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn my2-btn']) ?>
</div>
<?php ActiveForm::end(); ?>




