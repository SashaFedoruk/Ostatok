<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TopUpForm */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'money', ['labelOptions' => ['class' => 'normal']])->input('text', ['placeholder' => "100"]) ?>

<div class="form-group">
    <?= Html::submitButton('Пополнить', ['class' => 'btn my2-btn']) ?>
</div>
<?php ActiveForm::end(); ?>





