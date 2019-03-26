<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserUpdateForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $citiesList  */
?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username', ['labelOptions' => [ 'class' => 'normal']])->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'firstname', ['labelOptions' => [ 'class' => 'normal']])->textInput() ?>
    <?= $form->field($model, 'lastname', ['labelOptions' => [ 'class' => 'normal']])->textInput() ?>
    <?= $form->field($model, 'city_id', ['labelOptions' => [ 'class' => 'normal']])->dropDownList($citiesList) ?>

    <?= $form->field($model, 'email', ['labelOptions' => [ 'class' => 'normal']])->textInput(['readonly' => true]) ?>
<?= $form->field($model, 'phone', ['labelOptions' => [ 'class' => 'normal']])->textInput() ?>
    <?= $form->field($model, 'visible_email', ['labelOptions' => [ 'class' => 'normal']])->checkbox() ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn my2-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>




