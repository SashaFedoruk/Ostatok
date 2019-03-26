<?php
namespace frontend\widgets\contactformwidget;


use frontend\models\ContactForm;

class ContactFormWidget extends \yii\base\Widget
{
    public $model;

    public function run() {
        $model = $this->model ? : new ContactForm();
        return $this->render('contactform', ['model' => $model]);
    }
}