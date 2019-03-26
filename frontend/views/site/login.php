<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $signUpModel \frontend\models\SignupForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
$cities = \yii\helpers\ArrayHelper::map(\common\models\City::find()->orderBy('name')->all(), 'id', 'name');
?>

<div class="container">
    <div class="login-block ">
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

        <div class="singin">
            <h2>Регистрация</h2>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($signUpModel, 'username')
                ->input('text', ['placeholder' => 'Логин', 'autofocus' => 'autofocus'])
                ->label(false); ?>

            <?= $form->field($signUpModel, 'firstname')
                ->input('text', ['placeholder' => 'Имя', 'autofocus' => 'autofocus'])
                ->label(false); ?>

            <?= $form->field($signUpModel, 'lastname')
                ->input('text', ['placeholder' => 'Фамилия', 'autofocus' => 'autofocus'])
                ->label(false); ?>

            <?= $form->field($signUpModel, 'city_id')->dropDownList($cities)
                ->label(false); ?>

            <?= $form->field($signUpModel, 'email')
                ->input('text', ['placeholder' => 'Емейл', 'autofocus' => 'autofocus'])
                ->label(false); ?>
            <?= $form->field($signUpModel, 'phone')
                ->input('text', ['placeholder' => 'Телефон', 'autofocus' => 'autofocus'])
                ->label(false); ?>

            <?= $form->field($signUpModel, 'password')
                ->input('password', ['placeholder' => 'Пароль', 'autofocus' => 'autofocus'])
                ->label(false); ?>

            <?= $form->field($signUpModel, 'visible_email')->hiddenInput()->label(false) ?>


                <?= Html::submitButton('Создать аккаунт', ['class' => 'btn my2-btn', 'name' => 'signup-button']) ?>


            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
