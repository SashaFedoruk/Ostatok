<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'firstname') ?>

                <?= $form->field($model, 'lastname') ?>

                <?= $form->field($model, 'city_id')->textInput([
                    'type' => 'number'
                ]) ?>

                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'phone') ?>
                <?= $form->field($model, 'visible_email')->textInput([
                    'type' => 'number'
                ])  ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'agreed_rules')->checkbox() ?>
<!--
                <div class="form-group">
                    <div class="checkbox">
                      <label><input class="form-control" type="checkbox" value="">Даю согласие на обработку моих данных и получение предложений.</label>
                    </div>
                </div>
-->

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
