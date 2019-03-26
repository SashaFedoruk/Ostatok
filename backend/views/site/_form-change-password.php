<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChangePasswordForm */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'password', ['labelOptions' => [ 'class' => 'normal']])->input('password',['placeholder' => "Новый пароль"]) ?>
<?= $form->field($model, 'confirm_password', ['labelOptions' => [ 'class' => 'normal']])->input('password',['placeholder' => "Повторите пароль"]) ?>

<div class="form-group">
    <?= Html::submitButton('Извенить пароль', ['class' => 'btn my2-btn']) ?>
</div>
<?php ActiveForm::end(); ?>





