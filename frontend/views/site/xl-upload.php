<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ads [] */
/* @var $sum */
/* @var $count */

$this->title = 'Импорт данных';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <div class="row">
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                
                
                    <div class="col-lg-12 col-md-12 col-sm-12">      
                <?php if(empty($result)):?>
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

   
    <?= $form->field($model, 'xlFile')->fileInput() ?>
    <?= Html::submitButton('Загрузить', ['class' => 'btn my2-btn']) ?>

<?php ActiveForm::end() ?>
                    <br>
                    <br>
                <p>Шаблон для импорта данных: <?= Html::a('Скачать', ['/site/download-template'], ['class'=>'btn my2-btn']) ?></p>
    <?php else: ?>
    <?=$result?>
    <?php endif; ?>
                    </div>
                
            </div>
        </div>
    </div>
</div>
