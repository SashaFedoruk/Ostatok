<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;


/* @var $this yii\web\View */
/* @var $model backend\models\CreateProperyValuesForm */
/* @var $propertiesList  */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->dropDownList($propertiesList) ?>

    <?= $form->field($model, 'values')->widget(MultipleInput::className(), [
        'max'               => 6,
        'min'               => 1, // should be at least 2 rows
        'allowEmptyList'    => false,
        'enableGuessTitle'  => true,
        'addButtonPosition' => MultipleInput::POS_HEADER, // show add button in the header
    ])
        ->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn my2-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
