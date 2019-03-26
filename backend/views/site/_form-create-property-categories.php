<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\multiselect\MultiSelect;
use dosamigos\multiselect\MultiSelectListBox;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\CreateProperyValuesForm */
/* @var $categoriesList */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->dropDownList($categoriesList) ?>

    <div id="propertiesChild">
        <?= $form->field($model, 'values')->widget(MultiSelectListBox::className(), [
            'value' => '',
            'data' => ['']
        ]) ?>
    </div>
    <br>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn my2-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
