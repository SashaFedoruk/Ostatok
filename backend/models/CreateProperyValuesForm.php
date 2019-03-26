<?php

namespace backend\models;

use common\models\Property;
use yii\base\Model;

/**
 * Signup form
 */
class CreateProperyValuesForm extends Model
{
    public $parent_id;
    public $values = [];


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'required'],
            [['parent_id'], 'integer'],
            ['values', 'each', 'rule' => ['string', 'max' => 32], 'message' => 'This property size > 32.'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['parent_id' => 'id']],
            // ['values', 'each', 'rule' => [ 'unique', 'targetClass' => Property::className()], 'message' => 'This property has already been taken.'],

        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'values' => 'Значения',
            'parent_id' => 'Главное свойство',
        ];
    }

    /**
     * Signs user up.
     *
     * @return CreateProperyValuesForm|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        foreach ($this->values as $el) {
            if ($el == '') {
                continue;
            }
            $prop = new Property();
            $prop->name = $el;
            $prop->parent_id = $this->parent_id;
            if (!$prop->validate()) {
                continue;
            }
            $prop->save();
        }


        return $this;
    }
}
