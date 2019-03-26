<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CreateProductForm */
/* @var $form yii\widgets\ActiveForm */
/* @var common\models\Category [] $categoriesList */
/* @var common\models\Producent [] $producentsList */
/* @var common\models\Decoration [] $decorationsList */

$this->title = 'Создание обьявления';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info col-lg-4 col-md-4 col-sm-6">
    <h4 class="bold"><?= Html::encode($this->title) ?></h4>


    <?=
    $this->render('_form-update-product-field', [
        'model' => $model,
        'categoriesList' => $categoriesList,
        'producentsList' => $producentsList,
        'decorationsList' => $decorationsList
    ]);

    ?>



</div>








