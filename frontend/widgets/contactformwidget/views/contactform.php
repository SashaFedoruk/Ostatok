<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\ContactForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="contact-form">


<?php $form = ActiveForm::begin(['action' => ['site/contact-form'], 'enableClientValidation' => false, 'options' => ['class' => 'navbar-form']]); ?>
    <div class="row">
        <div class="col-lg-12">
            <h4>Посоветуйте, как улучшить наш сервис?</h4>
        </div>
    </div>
<div class="row">
    <div class="col-lg-6 col-xs-12">
        <?= $form->field($model, 'name', ['template' => "{input}"])->input('text', ['placeholder' => 'Имя'])->label(false); ?>
    </div>
    <div class="col-lg-6 col-xs-12">
        <?= $form->field($model, 'email', ['template' => "{input}"])->input('text', ['placeholder' => 'Email'])->label(false); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <?= $form->field($model, 'body', ['template' => "{input}"])->textarea(['placeholder' => 'Текст сообщения...', 'resize' => 'none'])->label(false); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-xs-12">
        <?= Html::submitButton("Отправить", ['class' => 'btn btn-default my2-btn']) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
</div>
