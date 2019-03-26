<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'isAnyField')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn my2-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
