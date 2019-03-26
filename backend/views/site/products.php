<?php

use common\models\Producent;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\models\ProductSearch */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;

$categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
$producents = ArrayHelper::map(Producent::find()->all(), 'id', 'name');
?>
<div class="user-info col-lg-8 col-md-8 col-sm-8">

    <h4 class="bold"><?= Html::encode($this->title) ?></h4>
    <?php Pjax::begin(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'label' => 'Название',
                'filter' => false,
            ],
            [
                'attribute' => 'category_id',
                'label' => 'Категория',

                'format' => 'text', // Возможные варианты: raw, html
                'content' => function ($data) {
                    return $data->getCategoryName();
                },
                'filter' => $categories,


            ],
            [
                'attribute' => 'producent_id',
                'label' => 'Производитель',
                'format' => 'text', // Возможные варианты: raw, html
                'content' => function ($data) {
                    return $data->getProducentName();
                },
                'filter' => $producents

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Действия',
                'headerOptions' => ['width' => '80'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['site/view-product', 'id' => $model->id]);
                    },
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['site/update-product', 'id' => $model->id]);
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['site/delete-product', 'id' => $model->id]);
                    },

                ],
            ],

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
