<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="login-block admin-login-form">
        <div class="login">
            <h2>Вход</h2>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

            <?= $form->field($model, 'username')
                ->textInput(['autofocus' => true])
                ->input('text', ['placeholder' => "Логин", 'autofocus' => 'autofocus'])
                ->label(false);
            ?>

            <?= $form->field($model, 'password')
                ->input('password', ['placeholder' => 'Пароль', 'autofocus' => 'autofocus'])
                ->label(false);
            ?>


            <?= Html::submitButton('Войти', ['class' => 'btn my2-btn', 'name' => 'login-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>


    </div>
</div>
