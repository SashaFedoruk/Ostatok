<?php

use yii\helpers\Html;
use common\models\Category;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var common\models\Category []  $categoriesList  */


$this->title = 'Категории';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info col-lg-4 col-md-4 col-sm-6">
    <h4 class="bold"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form-create-category', [
        'model' => $model,
        'categoriesList' => ArrayHelper::map($categoriesList, 'id', 'name')
    ]) ?>

</div>
<div class="col-lg-4 col-md-4 col-sm-6">
    <h4><br></h4>
    <h5 class="bold">Доступные значения</h5>
    <ul>
        <?php
        foreach ($categoriesList as $el) {
            if (!isset($el->name)) continue;
            echo '<li>' . Html::a(Html::img('img/Admin/delete.png'), ['delete-category', 'id' => $el->id], [
                    'class' => '',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить это значение?',
                        'method' => 'post',
                    ],
                ]) . ' ' . $el->name . '</li>';

//            $childCategories = $el->getCategories()->all();
//            foreach ($childCategories as $child) {
//                echo '<li>' . Html::a(Html::img('img/Admin/delete.png'), ['delete-category', 'id' => $child->id], [
//                        'class' => '',
//                        'data' => [
//                            'confirm' => 'Вы уверены что хотите удалить это значение?',
//                            'method' => 'post',
//                        ],
//                    ]) . ' ' . $child->name . '</li>';
//            }
//            echo '</ul></li>';
        }
        ?>
    </ul>
</div>


