<?php

use yii\helpers\Html;
use common\models\Category;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Decoration */
/* @var common\models\Decoration []  $decorationsList  */


$this->title = 'Декорации';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info col-lg-4 col-md-4 col-sm-6">
    <h4 class="bold"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form-create-decoration', [
        'model' => $model
    ]) ?>

</div>
<div class="col-lg-4 col-md-4 col-sm-6">
    <h4><br></h4>
    <h5 class="bold">Доступные значения</h5>
    <ul class="all-data">
        <?php
        foreach ($decorationsList as $el) {
            if (!isset($el->name)) continue;
            echo '<li>' . Html::a(Html::img('img/Admin/delete.png'), ['delete-decoration', 'id' => $el->id], [
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


