<?php
namespace frontend\widgets\searchwidget;


use common\models\ProductSearch;

class SearchWidget extends \yii\base\Widget
{
    public $model;

    public function run() {
        $model = $this->model ? : new ProductSearch();
        return $this->render('search', ['model' => $model]);
    }
}