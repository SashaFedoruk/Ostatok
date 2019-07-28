<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ads [] */
/* @var $sum */
/* @var $count */

$this->title = 'Загрузка Excel';
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
    <button>Submit</button>

<?php ActiveForm::end() ?>
    <?php else: ?>
    <?=$result?>
    <?php endif; ?>
                    </div>
                
            </div>
        </div>
    </div>
</div>
