<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserUpdateForm */
/* @var $citiesList */
/* @var $changePasswordModel common\models\ChangePasswordForm */

$this->title = 'Update User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-info col-lg-4 col-md-4 col-sm-6">
    <h4 class="bold">Информация о пользователе:</h4>

    <?= $this->render('_form-user-update', [
        'model' => $model,
        'citiesList' => $citiesList
    ]) ?>

</div>
<div class="col-lg-4 col-md-4 col-sm-6">
    <h4 class="bold">Смена пароля:</h4>
    <?= $this->render('_form-change-password', [
        'model' => $changePasswordModel
    ]) ?>
    
</div>
