<?php

use common\models\Producent;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список Клиентов';
$this->params['breadcrumbs'][] = $this->title;

$categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
$producents = ArrayHelper::map(Producent::find()->all(), 'id', 'name');
?>
<div class="user-info col-lg-8 col-md-8 col-sm-8">

    <h4 class="bold"><?= Html::encode($this->title) ?></h4>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'firstname',
                'label' => 'Имя',
                'filter' => false,
            ],
            [
                'attribute' => 'lastname',
                'label' => 'Фамилия',
                'filter' => false,
            ],
            [
                'attribute' => 'phone',
                'label' => 'Телефон',
                'filter' => false,
            ],
            [
                'attribute' => 'email',
                'label' => 'Email',
                'filter' => false,
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата регистрации',
                'filter' => false,
                'value' => function ($model) {
                    $date = new DateTime();
                    $date->setTimestamp($model->created_at);
                    return $date->format('Y-m-d');
                },
            ],
        ]
    ]); ?>

</div>
