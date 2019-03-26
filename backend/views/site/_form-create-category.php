<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
/* @var $categoriesList  */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= //$form->field($model, 'parent_id')->dropDownList($categoriesList) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn my2-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
