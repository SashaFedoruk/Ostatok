<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class TopUpForm extends Model
{
    public $money;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['money', 'number', 'message' => 'Недопустимое значение.'],
            ['money', 'compare', 'compareValue' => 30, 'operator' => '>', 'message' => 'Минимальная сумма пополнения 30 UAH'],
            ['money', 'required'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'money' => 'Сумма пополнения',
        ];
    }
}
