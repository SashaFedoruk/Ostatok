<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property int $producent_id
 * @property int $decoration_id
 * @property string $imgUrl
 *
 * @property Ads[] $ads
 * @property Category $category
 * @property Producent $producent
 * @property Decoration $decoration
 * @property PropertyProduct[] $propertyProducts
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'producent_id', 'decoration_id'], 'required'],
            [['category_id', 'producent_id', 'decoration_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['imgUrl'], 'string'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['producent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producent::className(), 'targetAttribute' => ['producent_id' => 'id']],
            [['decoration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Decoration::className(), 'targetAttribute' => ['decoration_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Название',
            'category_id' => 'Категория',
            'producent_id' => 'Производитель',
            'decoration_id' => 'Декор',
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
     * @return string
     */
    public function getCategoryName()
    {
        return $this->getCategory()->one()->name;
    }

    /**
     * @return string
     */
    public function getProducentName()
    {
        return $this->getProducent()->one()->name;
    }
    /**
     * @return string
     */
    public function getDecorationName()
    {
        return $this->getDecoration()->one()->name;
    }
    /**
     * @return string
     */
    public function getDecorationCode()
    {
        return $this->getDecoration()->one()->code;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducent()
    {
        return $this->hasOne(Producent::className(), ['id' => 'producent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyProducts()
    {
        return $this->hasMany(PropertyProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['product_id' => 'id']);
    }

    public function getMinPrice()
    {
        $ads = $this->getAds()->where(['ads.status' => 1]);
        if (isset(Yii::$app->request->cookies['city_id'])) {
            $cityId = Yii::$app->request->cookies['city_id']->value;
            $ads->joinWith(['user'])->andWhere(['city_id' => $cityId]);
        }
        return (integer)$ads->min('price');
//        return (integer)$ads->min('price / (length * width  / 1000000)');
    }

    public function getMaxPrice()
    {
        $ads = $this->getAds()->where(['ads.status' => 1]);
        if (isset(Yii::$app->request->cookies['city_id'])) {
            $cityId = Yii::$app->request->cookies['city_id']->value;
            $ads->joinWith(['user'])->andWhere(['city_id' => $cityId]);
        }
        return (integer)$ads->max('price');
//        return (integer)$ads->max('price / (length * width  / 1000000)');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecoration()
    {
        return $this->hasOne(Decoration::className(), ['id' => 'decoration_id']);
    }

}
