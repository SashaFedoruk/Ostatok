<?php

namespace backend\models;

use common\models\Category;
use common\models\Property;
use common\models\PropertyCategory;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class CreatePropertyCategoriesForm extends Model
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
            ['values', 'each', 'rule' => ['integer'], 'message' => 'Недопустимое значение.'],
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
            'values' => 'Свойства',
            'parent_id' => 'Категория',
        ];
    }

    /**
     * Signs user up.
     *
     * @return CreateProperyValuesForm|null the saved model or null if saving fails
     */
    public function save()
    {

        $curCategory = Category::getCategoryById($this->parent_id);
        $allPc = $curCategory->propertyCategories;
        foreach ($allPc as $el) {
            if(!in_array($el->prop_id, $this->values)){
                $el->delete();
            }
        }
        $allPc = ArrayHelper::getColumn($allPc, 'prop_id');
        foreach ($this->values as $el) {
            if(in_array($el, $allPc)){
                continue;
            }
            $pc = new PropertyCategory();
            $pc->category_id = $this->parent_id;
            $pc->prop_id = $el;
            if (!$pc->validate()) {
                continue;
            }
            $pc->save();

        }
//        if (!$this->validate()) {
//            return null;
//        }
//        foreach ($this->values as $el) {
//            if ($el == '') {
//                continue;
//            }
//            $prop = new Property();
//            $prop->name = $el;
//            $prop->parent_id = $this->parent_id;
//            if (!$prop->validate()) {
//                continue;
//            }
//            $prop->save();
//        }


        return $this;
    }
}
