<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = "Страница не найдена";

?>
<div class="container">
    <div class="row">
        <div class=" col-lg-12 col-md-12 col-sm-12">
            <div class="site-error">

                <!--    <h1>--><? //= Html::encode($this->title) ?><!--</h1>-->
                <h3 class="bold">Ошибка</h3>
                <div class="alert alert-danger">
                    Страница не найдена.
                    <!--        --><? //= nl2br(Html::encode($message)) ?>
                </div>


            </div>
        </div>
    </div>
</div>
