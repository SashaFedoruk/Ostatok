<?php

use yii\helpers\Html;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $model \common\models\Producent */
/* @var $producentsList  */

$this->title = 'Производитель';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info col-lg-4 col-md-4 col-sm-6">
    <h4 class="bold"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form-create-producent', [
        'model' => $model
    ]) ?>

</div>
<div class="col-lg-4 col-md-4 col-sm-6">
    <h4><br></h4>
    <h5 class="bold">Производители</h5>
    <ul>
        <?php
        foreach ($producentsList as $el) {
            if (!$el) continue;
            echo '<li>' . Html::a(Html::img('img/Admin/delete.png'), ['delete-producent', 'id' => array_search($el, $producentsList)], [
                    'class' => '',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить это значение?',
                        'method' => 'post',
                    ],
                ]) . ' ' . $el;


            echo '</li>';
        }
        ?>
    </ul>
</div>



