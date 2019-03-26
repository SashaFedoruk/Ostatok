<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_product".
 *
 * @property int $id
 * @property int $prop_id
 * @property int $product_id
 *
 * @property Product $product
 * @property Property $prop
 */
class PropertyProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prop_id', 'product_id'], 'required'],
            [['prop_id', 'product_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProp()
    {
        return $this->hasOne(Property::className(), ['id' => 'prop_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'prop_id']);
    }



}
