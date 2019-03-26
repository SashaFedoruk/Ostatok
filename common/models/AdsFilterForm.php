<?php
namespace common\models;

use yii\base\Model;

/**
 * Signup form
 */
class AdsFilterForm extends Model
{
    public $minSize;
    public $maxSize;
    
    public $sortBy;
    


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['minSize', 'trim'],
            ['minSize', 'number'],
            ['maxSize', 'trim'],
            ['maxSize', 'number'],
            ['sortBy', 'integer'],



        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'minSize' => 'Минимальная площадь, м2',
            'maxSize' => 'Максимальная площадь, м2',
            'sortBy' => 'Сортировать',
        ];
    }
}
