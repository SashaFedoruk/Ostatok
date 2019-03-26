<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $parent_id
 * @property int $isAnyField = 0
 *
 * @property Property $parent
 * @property Property[] $properties
 * @property PropertyCategory[] $propertyCategories
 * @property PropertyProduct[] $propertyProducts
 */
class Property extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id', 'isAnyField'], 'integer'],
            [['name', 'value'], 'string', 'max' => 32],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['parent_id' => 'id']],
            //['name', 'unique', 'targetClass' => '\common\models\Property', 'message' => 'This property has already been taken.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'value' => 'Значение',
            'parent_id' => 'Главное свойство',
            'isAnyField' => 'Произвольное поле'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Property::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['parent_id' => 'id']);
    }
    /**
     * @param  $props
     * @return Property
     */
    public function getChildPropertyWhere($props)
    {
        return $this->hasOne(Property::className(), ['parent_id' => 'id'])->andWhere($props)->one();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyCategories()
    {
        return $this->hasMany(PropertyCategory::className(), ['prop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyProducts()
    {
        return $this->hasMany(PropertyProduct::className(), ['prop_id' => 'id']);
    }
    /**
     * @param integer $id
     * @return Property
     */

    public static function  getPropertyById($id){
        return Property::find()->where(['id' => $id])->one();
    }
}
