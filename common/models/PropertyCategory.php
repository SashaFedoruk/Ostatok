<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_category".
 *
 * @property int $id
 * @property int $prop_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Property $prop
 */
class PropertyCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prop_id', 'category_id'], 'required'],
            [['prop_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['prop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['prop_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prop_id' => 'Prop ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProp()
    {
        return $this->hasOne(Property::className(), ['id' => 'prop_id']);
    }
}
